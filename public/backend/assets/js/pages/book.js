var roomType = 'grid';
var right = 'resourceTimeGridDay,resourceTimeGridWeek,resourceDayGridMonth,listWeek';
var initialView = 'resourceTimeGridDay';
var eventColors = ["#039BE5", "#3F51B5", "#F4511E", "#8E24AA", "#0B8043", "#D50000", "#33B679", "#7986CB", "#616161"];
rooms.forEach((room, index) => {
    room.eventColor = eventColors[index];
});
var real_bookings = [];


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
        titleFormat: function(data) {
            if(data.end.day == data.start.day) {
                return `${data.start.year}/${data.start.month+1}/${data.start.day}`
            }else {
                return `${data.start.year}/${data.start.month+1}/${data.start.day} - ${data.end.year}/${data.end.month+1}/${data.end.day}`
            }
        },
        eventClick: function(info) {
            viewDetail(info.event.id, "calendar");
        },
        select: function(info) {
            $('[name="date"]').val(info.startStr.substring(0, 10))
            $('[name="room"]').val(info.resource.id);
            $('[name="start_at"]').val(getTimeString(info.startStr));
            $('[name="end_at"]').val(getTimeString(info.endStr));
            $("#book_now_modal").modal("show");
        },
    });
    calendar.render();
}

