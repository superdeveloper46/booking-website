var roomType = 'line';
var initialView = 'resourceTimelineDay';
var right = 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth';
var eventColors = ["#039BE5", "#3F51B5", "#F4511E", "#8E24AA", "#0B8043", "#D50000", "#33B679", "#7986CB", "#616161"];
rooms.forEach((room, index) => {
    room.eventColor = eventColors[index];
});
var real_bookings = [];

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
        selectOverlap: false,
        businessHours: true,
        dayMaxEvents: true,
        resourceAreaHeaderContent: 'Rooms',
        resources: rooms,
        events: real_bookings,
        contentHeight: 'auto',
        slotMinWidth: 70,
        dayMinWidth: 100,
        resourceAreaWidth: '130px',
        titleFormat: function(data) {
            if(data.end.day == data.start.day) {
                return `${data.start.year}/${data.start.month+1}/${data.start.day}`
            }else {
                return `${data.start.year}/${data.start.month+1}/${data.start.day} - ${data.end.year}/${data.end.month+1}/${data.end.day}`
            }
        },
        select: function(info) {
            $('[name="date"]').val(info.startStr.substring(0, 10))
            $('[name="room"]').val(info.resource.id).niceSelect('update');
            $('[name="start_at"]').val(getTimeString(info.startStr)).niceSelect('update');
            $('[name="end_at"]').val(getTimeString(info.endStr)).niceSelect('update');
        },
    });
    calendar.render();
}


