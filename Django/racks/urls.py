from django.urls import path
from .views import ep_allocation_view
from .views import ep_allocation_view2

urlpatterns = [
    path('allocate/', ep_allocation_view, name='ep_allocate'),
    path('allocate2/', ep_allocation_view2, name='ep_allocate2'),
]