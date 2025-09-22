from django.core.management.base import BaseCommand
from racks.models import DataCenter, Rack, FreeBlock
from racks.utils import allocate_best_fit

class Command(BaseCommand):
    help = "Test multiple racks allocation"

    def handle(self, *args, **kwargs):
        dc, _ = DataCenter.objects.get_or_create(name="TestDC")
        dc.racks.all().delete()
        # Create 4 racks
        rack_configs = [
            ("Rack01", [1, 1, 1]),
            ("Rack02", [1]),
            ("Rack03", [4, 4, 2]),
            ("Rack04", [1, 2, 2, 5]),
        ]
        racks = []
        for rack_name, free_blocks in rack_configs:
            rack, _ = Rack.objects.get_or_create(name=rack_name, datacenter=dc, total_ru=sum(free_blocks))

             # Save original config
            rack.original_config = free_blocks
            rack.save()
            
            rack.free_blocks.all().delete()
            cursor = 1
            for length in free_blocks:
                FreeBlock.objects.create(rack=rack, start_ru=cursor, length=length)
                cursor += length
            racks.append(rack)

        self.stdout.write(self.style.SUCCESS("All racks and free blocks created!"))

        # # Device requests: ID + RU Req
        # device_requests = [
        #     {"id": "EP101", "ru_req": 2},
        #     {"id": "EP102", "ru_req": 2},
        #     {"id": "EP103", "ru_req": 3},
        # ]

        # # Allocate each device
        # for req in device_requests:
        #     dev_id = req["id"]
        #     size = req["ru_req"]

        #     result = allocate_best_fit(size, datacenter_name="TestDC")
        #     if result:
        #         allocated_range = (result["start_ru"], result["start_ru"] + result["length"] - 1)
        #         print(f"\nDevice {dev_id}, RU Req:{size} allocated: {result['rack']} RUs {allocated_range}")
        #     else:
        #         print(f"\nDevice {dev_id}, RU Req:{size} allocation failed (no suitable free block)")

        # # Show final free blocks in all racks
        # print("\nFinal Free slots in all racks:")
        # for rack in racks:
        #     print(f"\nRack {rack.name}:")
        #     for b in rack.free_blocks.all().order_by("start_ru"):
        #         slot_range = (b.start_ru, b.start_ru + b.length - 1)
        #         print(f"  Free block: start={b.start_ru}, length={b.length}, slot={slot_range}")