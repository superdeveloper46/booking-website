var roomType = 'line';
var right = 'resourceTimeGridDay,resourceTimeGridWeek,resourceDayGridMonth,listWeek';
var initialView = 'resourceTimeGridDay';
var eventColors = ["#039BE5", "#3F51B5", "#F4511E", "#8E24AA", "#0B8043", "#D50000", "#33B679", "#7986CB", "#616161"];
rooms.forEach((room, index) => {
    room.eventColor = eventColors[index];
});
var real_bookings = [];
bookings.forEach((booking_data, index) => {
    var tmp = {
        id: booking_data.id,
        title: booking_data.title,
        resourceId: booking_data.resourceId,
        repeat: booking_data.repeat
    };

    if (booking_data.repeat !== 'none') {
        var rrule = {
            freq: booking_data.freq,
            interval: booking_data.interval,
            dtstart: booking_data.start,
        };

        if (booking_data.until) rrule.until = booking_data.until;
        if (booking_data.count) rrule.count = booking_data.count;
        if (booking_data.byweekday) {
            if (booking_data.byweekday.endsWith(',')) {
                booking_data.byweekday = booking_data.byweekday.slice(0, -1);
            }
            rrule.byweekday = booking_data.byweekday.split(",");
        }
        if (booking_data.bymonthday) {
            if (booking_data.bymonthday.endsWith(',')) {
                booking_data.bymonthday = booking_data.bymonthday.slice(0, -1);
            }
            rrule.bymonthday = booking_data.bymonthday.split(",");
            rrule.bymonthday = rrule.bymonthday.map(element => parseInt(element));
        }
        if (booking_data.bysetpos) rrule.bysetpos = booking_data.bysetpos;

        tmp.rrule = rrule;
        tmp.duration = getTimeDifference(booking_data.start, booking_data.end);
    } else {
        tmp.start = booking_data.start;
        tmp.end = booking_data.end;
    }
    real_bookings.push(tmp);
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
        editable: true,
        selectable: true,
        businessHours: true,
        dayMaxEvents: true,
        resourceAreaHeaderContent: 'Rooms',
        resources: rooms,
        events: real_bookings,
        contentHeight: 'auto',
        slotMinWidth: 80,
        dayMinWidth: 100,
        resourceAreaWidth: '150px',
        views: {
            resourceTimelineDay: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            resourceTimelineWeek: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            resourceTimelineMonth: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            resourceTimeGridDay: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            resourceTimeGridWeek: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            resourceTimeGridMonth: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            listWeek: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
        },
        eventClick: function(info) {
            viewDetail(info.event.id, "calendar");
        }
    });
    calendar.render();
}

function getTimeDifference(start, end) {
    var startTime = new Date(start);
    var endTime = new Date(end);
    let difference = Math.abs(endTime - startTime);
    var hours = Math.floor(difference / (1000 * 60 * 60));
    var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    return `${hours < 10 ? '0' + hours : hours}:${minutes < 10 ? '0' + minutes : minutes}`;
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

document.addEventListener('DOMContentLoaded', function () {
    view();
});


