from django.contrib import admin

# Register your models here.
from django.contrib import admin
from .models import DataCenter, Rack, FreeBlock, Device


@admin.register(DataCenter)
class DataCenterAdmin(admin.ModelAdmin):
    list_display = ['name']


@admin.register(Rack)
class RackAdmin(admin.ModelAdmin):
    list_display = ['name', 'datacenter', 'total_ru', 'largest_free']


@admin.register(FreeBlock)
class FreeBlockAdmin(admin.ModelAdmin):
    list_display = ("rack", "start_ru", "length", "end_ru")


@admin.register(Device)
class DeviceAdmin(admin.ModelAdmin):
    list_display = ['name', 'rack', 'start_ru', 'height', 'installed_at']