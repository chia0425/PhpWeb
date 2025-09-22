from django.db import models

# Create your models here.
from django.db import models, transaction
from django.core.exceptions import ValidationError


class DataCenter(models.Model):
    name = models.CharField(max_length=100, unique=True)


def __str__(self):
    return self.name


class Rack(models.Model):
    datacenter = models.ForeignKey(DataCenter, on_delete=models.CASCADE, related_name='racks')
    name = models.CharField(max_length=100, unique=True)
    total_ru = models.PositiveSmallIntegerField(default=42)
    # caching the largest free block is optional but useful for fast filtering
    largest_free = models.PositiveSmallIntegerField(default=0)
    
    def update_largest_free(self):
        largest = self.free_blocks.aggregate(models.Max('length'))['length__max'] or 0
        self.largest_free = largest
        self.save()


class Meta:
    ordering = ['name']


def __str__(self):
    return f"{self.name} ({self.datacenter})"


def update_largest_free(self):
    largest = self.free_blocks.aggregate(models.Max('height'))['height__max'] or 0
    self.largest_free = largest
    self.save(update_fields=['largest_free'])


class FreeBlock(models.Model):
    rack = models.ForeignKey(Rack, on_delete=models.CASCADE, related_name="free_blocks")
    start_ru = models.PositiveIntegerField()
    length = models.PositiveIntegerField()  # <-- probably this, not height

    @property
    def end_ru(self):
        return self.start_ru + self.length - 1


class Meta:
    ordering = ['start_ru']
    unique_together = ('rack', 'start_ru')


def __str__(self):
    return f"{self.rack.name}: {self.start_ru} - {self.end_ru()} ({self.height}U)"


def end_ru(self):
    return self.start_ru + self.height - 1


class Device(models.Model):
    rack = models.ForeignKey(Rack, on_delete=models.SET_NULL, null=True, blank=True, related_name='devices')
    start_ru = models.PositiveSmallIntegerField(null=True, blank=True)
    height = models.PositiveSmallIntegerField()
    name = models.CharField(max_length=200, blank=True)
    installed_at = models.DateTimeField(auto_now_add=True)


def __str__(self):
    return f"{self.name or f'Device-{self.pk}'} @ {self.rack.name if self.rack else 'unassigned'} ({self.height}U)"