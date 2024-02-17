@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

@php
  $bookings = App\Models\Booking::latest()->get();
  $todayBookings = App\Models\Booking::whereDate('created_at', today())->get();
  $users = App\Models\User::latest()->get();
  $todayUsers = App\Models\User::whereDate('created_at', today())->get();
  $rooms = App\Models\Room::latest()->get();
  $meetingRooms = App\Models\Room::latest()->where('type', 'meeting')->get();

@endphp

<div class="page-content">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Users</p>
                            <h4 class="my-1 text-info">{{ count($users) }}</h4>
                            <p class="mb-0 font-13">Today registered: {{count($todayUsers)}}</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bx-user'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Booking</p>
                            <h4 class="my-1 text-success">{{ count($bookings) }}</h4>
                            <p class="mb-0 font-13">Today booking: {{count($todayBookings)}}</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bx-calendar'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Rooms</p>
                        <h4 class="my-1 text-primary">{{ count($rooms) }}</h4>
                        <p class="mb-0 font-13">Meeting Rooms: {{count($meetingRooms)}}</p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i class='bx bx-windows'></i>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
</script>

@endsection
