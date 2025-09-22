from django.core.management.base import BaseCommand
from racks.models import DataCenter, Rack, FreeBlock

class Command(BaseCommand):
    help = "Create racks with non-contiguous free blocks and store original configuration"

    def handle(self, *args, **kwargs):
        # Step 1: Get or create the datacenter
        dc, _ = DataCenter.objects.get_or_create(name="TestDC")
        
        # Step 2: Optional: delete previous racks to start fresh
        # dc.racks.all().delete()

        # Step 3: Define racks and their non-contiguous free blocks - need to find a way to get start ru of each indentation
        rack_configs = [
            {"rack_name": "Rack01", "free_blocks": [{"start_ru": 1, "length": 1}, {"start_ru": 4, "length": 2}]},
            {"rack_name": "Rack02", "free_blocks": [{"start_ru": 1, "length": 1}]},
            {"rack_name": "Rack03", "free_blocks": [{"start_ru": 3, "length": 2}, {"start_ru": 7, "length": 1}]},
            {"rack_name": "Rack04", "free_blocks": [{"start_ru": 2, "length": 2}, {"start_ru": 6, "length": 3}]},
        ]

        for rc in rack_configs:
            total_ru = sum(b["length"] for b in rc["free_blocks"])
            rack, created = Rack.objects.get_or_create(
                name=rc["rack_name"],
                datacenter=dc,
                defaults={
                    "total_ru": total_ru,
                    "original_config": rc["free_blocks"]
                }
            )

            # Step 4: Update existing racks with original config if not newly created
            if not created:
                rack.total_ru = total_ru
                rack.original_config = rc["free_blocks"]
                rack.save()

            # Step 5: Clear existing FreeBlocks and create new ones
            rack.free_blocks.all().delete()
            for block in rc["free_blocks"]:
                FreeBlock.objects.create(
                    rack=rack,
                    start_ru=block["start_ru"],
                    length=block["length"]
                )

        self.stdout.write(self.style.SUCCESS("All racks with non-contiguous free blocks created and original_config set!"))