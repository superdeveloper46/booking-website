@extends('admin.admin_dashboard')
@section('admin')

{{-- <link href="{{asset('backend/assets/plugins/fullcalendar/css/main.min.css')}}" rel="stylesheet"> --}}
{{-- <script src="{{asset('backend/assets/plugins/fullcalendar/js/main.min.js')}}"></script> --}}
<link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.css') }}">
<script src="{{ asset('frontend/assets/js/jquery-ui.js') }}"></script>

<script src='https://cdn.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.10/index.global.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@6.1.10/index.global.min.js'></script>

<link rel="stylesheet" href="{{ asset('backend/assets/css/pages/book.css') }}">


<div class="page-content">
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Booking Calendar</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" onclick="changeRoomType()" title="Change Room Type">
                <i class="bx bx-recycle"></i>
            </button>
        </div>
    </div>

    <hr/>

    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

    <hr/>
</div>

<script>
    var bookings = @json($bookings);
    var rooms = @json($rooms);
    var current_date = "<?php echo date("Y-m-d"); ?>";
</script>

<script src="{{ asset('backend/assets/js/pages/book.js') }}"></script>

@endsection
