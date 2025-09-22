from django.urls import path
from .views import allocate_view


urlpatterns = [
path('allocate/', allocate_view, name='allocate'),
]