@extends('admin.admin_dashboard')
@section('admin')

<link href="{{asset('backend/assets/plugins/fullcalendar/css/main.min.css')}}" rel="stylesheet">
<script src="{{asset('backend/assets/plugins/fullcalendar/js/main.min.js')}}"></script>

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
	document.addEventListener('DOMContentLoaded', function () {
		var calendarEl = document.getElementById('calendar');
		var calendar = new FullCalendar.Calendar(calendarEl, {
			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
			},
			initialView: 'dayGridMonth',
			initialDate: '2020-09-12',
			navLinks: true, // can click day/week names to navigate views
			selectable: true,
			nowIndicator: true,
			editable: true,
			selectable: true,
			businessHours: true,
			dayMaxEvents: true, // allow "more" link when too many events
			events: [{
				title: 'All Day Event',
				start: '2020-09-01',
			}, {
				title: 'Long Event',
				start: '2020-09-07',
				end: '2020-09-10'
			},
            {
				title: 'Conference',
				start: '2020-09-11',
				end: '2020-09-13'
			}, {
				title: 'Meeting',
				start: '2020-09-12T10:30:00',
				end: '2020-09-12T12:30:00'
			}, {
				title: 'Lunch',
				start: '2020-09-12T12:00:00'
			}, {
				title: 'Meeting',
				start: '2020-09-12T14:30:00'
			}, {
				title: 'Happy Hour',
				start: '2020-09-12T17:30:00'
			}, {
				title: 'Dinner',
				start: '2020-09-12T20:00:00'
			}, {
				title: 'Birthday Party',
				start: '2020-09-13T07:00:00'
			}, {
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2020-09-28'
			}]
		});
		calendar.render();
	});
</script>

@endsection
