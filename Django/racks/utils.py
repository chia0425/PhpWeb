from django.db import transaction
from uuid import uuid4
from .models import Rack, FreeBlock, Device
def allocate_best_fit(size, datacenter_name=None):
    qs = Rack.objects.all()
    if datacenter_name:
        qs = qs.filter(datacenter__name=datacenter_name)
        # Fast prune: only racks that can possibly fit
        # qs = qs.filter(largest_free__gte=size)

        print("Candidate racks:")
        for r in qs:
            print(f"Rack {r.name}")


    best_candidate = None
# Find candidate (no DB locks yet)
    for rack in qs:
        block_qs = rack.free_blocks.filter(length__gte=size).order_by('length')
        if not block_qs.exists():
            continue
        block = block_qs.first()
        waste = block.length - size
        if best_candidate is None or waste < best_candidate['waste']:
            best_candidate = {'rack': rack, 'block': block, 'waste': waste}
    if not best_candidate:
        return None


    # perform transactional allocation
    with transaction.atomic():
    # lock the particular FreeBlock row
        block = FreeBlock.objects.select_for_update().get(pk=best_candidate['block'].pk)
        rack = best_candidate['rack']
        # re-check length (race-safe)
        if block.length < size:
            return None


        start_pos = block.start_ru
        device = Device.objects.create(
        rack=rack,
        start_ru=start_pos,
        height=size,
        name=f"auto-{uuid4().hex[:6]}"
        )


        if block.length == size:
            block.delete()
        else:
            # shrink block from its start
            block.start_ru = block.start_ru + size
            block.length = block.length - size
            block.save(update_fields=['start_ru', 'length'])


        # update cache
        #rack.update_largest_free()


    return {
    'rack': rack.name,
    'start_ru': start_pos,
    'length': size,
    'device_id': device.pk,
    }

from django.db import transaction

def merge_free_blocks(rack):
    blocks = list(rack.free_blocks.order_by('start_ru'))
    if not blocks:
        #rack.update_largest_free()
        return
    merged = []
    cur = blocks[0]
    for nxt in blocks[1:]:
        if cur.end_ru() + 1 >= nxt.start_ru:
        # adjacent or overlapping (tolerate small overlaps)
            new_end = max(cur.end_ru(), nxt.end_ru())
            cur.length = new_end - cur.start_ru + 1
            cur.save()
            nxt.delete()
        else:
            cur = nxt
            #rack.update_largest_free()


def free_device(device_id):
    with transaction.atomic():
        d = Device.objects.select_for_update().get(pk=device_id)
        if not d.rack or not d.start_ru or not d.length:
        # nothing to do
            d.delete()
            return
        FreeBlock.objects.create(rack=d.rack, start_ru=d.start_ru, length=d.length)
# remove device record (or mark as removed)
        d.delete()
        merge_free_blocks(d.rack)