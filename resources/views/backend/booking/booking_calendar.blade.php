@extends('admin.admin_dashboard')
@section('admin')

{{-- <link href="{{asset('backend/assets/plugins/fullcalendar/css/main.min.css')}}" rel="stylesheet"> --}}
{{-- <script src="{{asset('backend/assets/plugins/fullcalendar/js/main.min.js')}}"></script> --}}
<link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.css') }}">
<script src="{{ asset('frontend/assets/js/jquery-ui.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.10/index.global.min.js"></script>


<style>
.ui-datepicker-trigger{
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    background: transparent;
    border: none;
    padding: 7px 13px 5px 13px !important;
    height: 35px!important;
}
</style>

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
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
    var roomType = 'line';
    var right = 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth,listWeek';
    var initialView = 'resourceTimelineDay';

    var bookings = @json($bookings);
    var rooms = @json($rooms);
    const eventColors = ["green", "blue", "red", "yellow", "purple", "orange"];
    rooms.forEach((room, index) => {
        room.eventColor = eventColors[index];
    });
    var current_date = "<?php echo date("Y-m-d"); ?>";

    document.addEventListener('DOMContentLoaded', function () {
        view();
    });

    function changeRoomType() {
        if(roomType == 'line') {
            right = 'resourceTimeGridDay,resourceTimeGridWeek,resourceDayGridMonth,listWeek';
            initialView = 'resourceTimeGridDay';
            roomType = 'grid';
        }else {
            right = 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth,listWeek';
            initialView = 'resourceTimelineDay';
            roomType = 'line';
        }
        view();
    }

    function view() {
        var calendarEl = document.getElementById('calendar');
		var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right
            },
            initialView,
            locale: 'en',
			initialDate: current_date,
            aspectRatio: 1.35,
			navLinks: true,
			selectable: true,
			nowIndicator: true,
			editable: false,
			selectable: true,
			businessHours: true,
			dayMaxEvents: true,
            aspectRatio: 1.35,
            resourceAreaHeaderContent: 'Rooms',
            resources: rooms,
            events: bookings,
            contentHeight: 'auto',
            slotMinWidth: 80,
            dayMinWidth: 100,
            resourceAreaWidth: '150px',
			// events: [
            //     {
			// 	title: 'All Day Event',
			// 	start: '2020-09-01',
            //     }, {
            //         title: 'Long Event',
            //         start: '2020-09-07',
            //         end: '2020-09-10'
            //     },
            //     {
            //         title: 'Conference',
            //         start: '2020-09-11',
            //         end: '2020-09-13'
            //     }, {
            //         title: 'Meeting',
            //         start: '2020-09-12T10:30:00',
            //         end: '2020-09-12T12:30:00'
            //     }, {
            //         title: 'Lunch',
            //         start: '2020-09-12T12:00:00'
            //     }, {
            //         title: 'Meeting',
            //         start: '2020-09-12T14:30:00'
            //     }, {
            //         title: 'Happy Hour',
            //         start: '2020-09-12T17:30:00'
            //     }, {
            //         title: 'Dinner',
            //         start: '2020-09-12T20:00:00'
            //     }, {
            //         title: 'Birthday Party',
            //         start: '2020-09-13T07:00:00'
            //     }, {
            //         title: 'Click for Google',
            //         url: 'http://google.com/',
            //         start: '2020-09-28'
            //     }
            // ]
		});
        // calendar.setOption('locale', 'zh-tw');
		calendar.render();


    }

    $(function () {
        $('.fc-header-toolbar > .fc-toolbar-chunk:first > .fc-button-group:first').append(
          '<div class="input-group datetimepicker"><input type="text" class="form-control fc-datepicker" placeholder="YYYY-MM-DD" style="padding: 0;width: 0;border: none;margin: 0;"></div>');
        $(".fc-datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            showOn: "button",
            buttonText: '<span class="input-group-addon"><i class="bx bx-calendar"></i></span>',
            onSelect: function(formated, dates) {
                current_date = formated;
                view();
            }
        });
        $(".ui-datepicker-trigger").addClass("fc fc-button-primary")
    });

</script>

@endsection
