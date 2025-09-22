from django.db import transaction
from uuid import uuid4
from .models import Rack, FreeBlock, Device

def allocate_best_fit(size, datacenter_name=None):
    qs = Rack.objects.all()
    if datacenter_name:
        qs = qs.filter(datacenter__name=datacenter_name)

    # Debug: print candidate racks and free blocks
    print("Candidate racks and free blocks:")
    for rack in qs:
        print(f"Rack {rack.name}")
        for b in rack.free_blocks.all().order_by('start_ru'):
            print(f"  Free block: start={b.start_ru}, length={b.length}")

    best_candidate = None

    # Find best candidate block across all racks
    for rack in qs:
        for block in rack.free_blocks.all().order_by('start_ru'):
            if block.length >= size:
                waste = block.length - size
                if best_candidate is None or waste < best_candidate['waste']:
                    best_candidate = {'rack': rack, 'block': block, 'waste': waste}

    if not best_candidate:
        return None

    # Transactionally allocate
    with transaction.atomic():
        block = FreeBlock.objects.select_for_update().get(pk=best_candidate['block'].pk)
        rack = best_candidate['rack']

        if block.length < size:
            return None  # another allocation already took it

        start_pos = block.start_ru
        device = Device.objects.create(
            rack=rack,
            start_ru=start_pos,
            height=size,
            name=f"auto-{uuid4().hex[:6]}"
        )

        # Shrink or remove the free block
        if block.length == size:
            block.delete()
        else:
            block.start_ru += size
            block.length -= size
            block.save(update_fields=['start_ru', 'length'])

        # Optional: update cache if you have largest_free logic
        # rack.update_largest_free()

    return {
        'rack': rack.name,
        'start_ru': start_pos,
        'length': size,
        'device_id': device.pk,
    }


#####################################take 2 - in memmory application ########################

# import pyodbc

def fetch_racks():
    """
    Fetch current rack free blocks from external SQL.
    Returns: dict of {rack_name: [ {start_ru: int, length: int}, ... ] }
    """
    # conn = pyodbc.connect("DRIVER={SQL Server};SERVER=server_name;DATABASE=db_name;UID=user;PWD=password")
    # cursor = conn.cursor()
    # cursor.execute("SELECT rack_name, start_ru, length FROM rack_free_blocks")
    # racks = {}
    # for row in cursor.fetchall():
    #     name, start_ru, length = row
    #     if name not in racks:
    #         racks[name] = []
    #     racks[name].append({"start_ru": start_ru, "length": length})
    ##temp
    racks = [
            {"rack_name": "Rack01", "free_blocks": [{"start_ru": 1, "length": 1}, {"start_ru": 4, "length": 2}]},
            {"rack_name": "Rack02", "free_blocks": [{"start_ru": 1, "length": 1}]},
            {"rack_name": "Rack03", "free_blocks": [{"start_ru": 3, "length": 2}, {"start_ru": 7, "length": 1}]},
            {"rack_name": "Rack04", "free_blocks": [{"start_ru": 2, "length": 2}, {"start_ru": 6, "length": 3}]},
            ]
    return racks


def fetch_ep_requests():
    """
    Fetch EP requests from external SQL.
    Returns: list of {id: str, ru: int}
    """
    # conn = pyodbc.connect("DRIVER={SQL Server};SERVER=server_name;DATABASE=db_name;UID=user;PWD=password")
    # cursor = conn.cursor()
    # cursor.execute("SELECT ep_id, ru_required FROM ep_requests")
    #temp
    device_requests = [
        {"id": "EP101", "ru": 2},
        {"id": "EP102", "ru": 2},
        {"id": "EP103", "ru": 3},
    ]
    return device_requests
    # return [{"id": row.ep_id, "ru": row.ru_required} for row in cursor.fetchall()]


def allocate_best_fit_in_memory(size, rack_dict):
    """
    Allocate a device of given size in free blocks (in-memory, no DB).
    Modifies rack_dict by shrinking or removing allocated free blocks.
    Returns allocation dict or None if cannot allocate.
    """
    best_candidate = None
    for rack_name, free_blocks in rack_dict.items():
        for block in free_blocks:
            if block["length"] >= size:
                waste = block["length"] - size
                if best_candidate is None or waste < best_candidate["waste"]:
                    best_candidate = {"rack_name": rack_name, "block": block, "waste": waste}

    if not best_candidate:
        return None

    block = best_candidate["block"]
    start_ru = block["start_ru"]

    # Shrink or remove the block
    if block["length"] == size:
        rack_dict[best_candidate["rack_name"]].remove(block)
    else:
        block["start_ru"] += size
        block["length"] -= size

    return {
        "rack": best_candidate["rack_name"],
        "start_ru": start_ru,
        "length": size
    }