from django.shortcuts import render
from racks.models import DataCenter, Rack, FreeBlock
from racks.utils import allocate_best_fit

def ep_allocation_view(request):
    dc = DataCenter.objects.get(name="TestDC")

    # Example EP device requests
    device_requests = [
        {"id": "EP101", "ru": 2},
        {"id": "EP102", "ru": 2},
        {"id": "EP103", "ru": 3},
    ]

    allocations = []

    for req in device_requests:
        result = allocate_best_fit(req["ru"], datacenter_name=dc.name)
        if result:
            allocated_range = (result["start_ru"], result["start_ru"] + result["length"] - 1)
            allocations.append({
                "id": req["id"],
                "ru_req": req["ru"],
                "rack": result["rack"],
                "range": allocated_range
            })
        else:
            allocations.append({
                "id": req["id"],
                "ru_req": req["ru"],
                "rack": None,
                "range": None
            })

    # Show remaining free blocks per rack
    racks_info = []
    for rack in Rack.objects.filter(datacenter=dc):
        free_blocks = [
            {"start": b.start_ru, "length": b.length, "slot": (b.start_ru, b.start_ru + b.length - 1)}
            for b in rack.free_blocks.all().order_by('start_ru')
        ]
        racks_info.append({
            "name": rack.name,
            "free_blocks": free_blocks,
            "original_config": rack.original_config  # include original config
        })

    context = {
        "allocations": allocations,
        "racks_info": racks_info,
    }
    return render(request, "racks/ep_allocation.html", context)


############take 2 - in memmory application #################

from django.shortcuts import render
from .utils import fetch_racks, fetch_ep_requests, allocate_best_fit_in_memory

def ep_allocation_view2(request):
    racks_data = fetch_racks()  # list of dicts
    ep_requests = fetch_ep_requests()

    # Prepare separate dict for allocation
    rack_dict = {r["rack_name"]: r["free_blocks"][:] for r in racks_data}  # copy so we don't mutate original

    allocations = []

    for req in ep_requests:
        result = allocate_best_fit_in_memory(req["ru"], rack_dict)
        if result:
            allocated_range = (result["start_ru"], result["start_ru"] + result["length"] - 1)
            allocations.append({
                "id": req["id"],
                "ru_req": req["ru"],
                "rack": result["rack"],
                "range": allocated_range
            })
        else:
            allocations.append({
                "id": req["id"],
                "ru_req": req["ru"],
                "rack": None,
                "range": None
            })

    context = {
        "allocations": allocations,
        "racks_info": racks_data,  # keep original config for display
        "remaining_free": rack_dict  # leftover free blocks after allocation
    }
    return render(request, "racks/ep_allocation2_inmem.html", context)