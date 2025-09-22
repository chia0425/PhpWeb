from django.core.management.base import BaseCommand
from racks.models import DataCenter, Rack, FreeBlock
from racks.utils import allocate_best_fit

class Command(BaseCommand):
    help = 'Test creating racks and allocating devices'

    def handle(self, *args, **kwargs):
        dc, _ = DataCenter.objects.get_or_create(name="TestDC")
        rack, _ = Rack.objects.get_or_create(name="TestRack01", datacenter=dc, total_ru=10)
        rack.free_blocks.all().delete()
        
        contiguous_u = [1,1,1,7]
        cursor = 1
        for length in contiguous_u:
            FreeBlock.objects.create(rack=rack, start_ru=cursor, length=length)
            cursor += length

        # rack.update_largest_free() not req as testing rack creation
        self.stdout.write(self.style.SUCCESS("Test rack and free blocks created!"))



        #2 device test
        # 4️⃣ Define device requests with IDs
        device_requests = [
            {"id": "EP101", "size": 2},
            {"id": "EP102", "size": 2},
        ]

        # 5️⃣ Allocate each device
        from django.core.management.base import BaseCommand
from racks.models import DataCenter, Rack, FreeBlock
from racks.utils import allocate_best_fit


class Command(BaseCommand):
    help = "Test creating racks and allocating devices with IDs and RU requirement"

    def handle(self, *args, **kwargs):
        # Create test DataCenter and Rack
        dc, _ = DataCenter.objects.get_or_create(name="TestDC")
        rack, _ = Rack.objects.get_or_create(name="TestRack01", datacenter=dc, total_ru=10)

        # Clear old FreeBlocks
        rack.free_blocks.all().delete()

        # Create initial contiguous free blocks
        contiguous_u = [1, 1, 1, 7]
        cursor = 1
        for length in contiguous_u:
            FreeBlock.objects.create(rack=rack, start_ru=cursor, length=length)
            cursor += length

        self.stdout.write(self.style.SUCCESS("Test rack and free blocks created!"))

        # Device requests: ID + RU Req
        device_requests = [
            {"id": "EP101", "ru_req": 2},
            {"id": "EP102", "ru_req": 2},
        ]

        # Allocate each device
        for req in device_requests:
            dev_id = req["id"]
            size = req["ru_req"]

            result = allocate_best_fit(size, datacenter_name="TestDC")
            if result:
                allocated_range = (result["start_ru"], result["start_ru"] + result["length"] - 1)
                print(f"\nDevice {dev_id}, RU Req:{size} allocated: {result['rack']} RUs {allocated_range}")
            else:
                print(f"\nDevice {dev_id}, RU Req:{size} allocation failed (no suitable free block)")

            # Show free blocks after allocation
            print(f"Free slots in rack {rack.name} after {dev_id}:")
            for b in rack.free_blocks.all().order_by("start_ru"):
                slot_range = (b.start_ru, b.start_ru + b.length - 1)
                print(f"  Free block: start={b.start_ru}, length={b.length}, slot={slot_range}")


        
        #single device test
        # result = allocate_best_fit(2, datacenter_name="TestDC") #device allocated
        # if result:
        #     allocated_range = (result['start_ru'], result['start_ru'] + result['length'] - 1)
        # else:
        #     allocated_range = None
        # # Show allocated device
        # print("Allocated device:", result)
        # print("Allocated RUs:", allocated_range)

        # # Show all current FreeBlocks
        # print(f"\nFree slots in rack {rack.name}:")
        # for b in rack.free_blocks.all().order_by('start_ru'):
        #     slot_range = (b.start_ru, b.start_ru + b.length - 1)
        #     print(f"  Free block: start={b.start_ru}, length={b.length}, slot={slot_range}")