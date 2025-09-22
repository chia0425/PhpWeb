from django.shortcuts import render
from django.http import JsonResponse

def allocate_view(request):
    # example: just return a test JSON
    return JsonResponse({"status": "ok"})