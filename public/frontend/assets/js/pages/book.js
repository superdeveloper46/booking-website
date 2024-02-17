var roomType = 'line';
var initialView = 'resourceTimelineDay';
var right = 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth';

var eventColors = ["green", "blue", "red", "purple", "orange", "pink"];
rooms.forEach((room, index) => {
    room.eventColor = eventColors[index];
});

var real_bookings = [];
bookings.forEach((booking_data, index) => {
    var tmp = {
        id: booking_data.id,
        title: booking_data.title,
        resourceId: booking_data.resourceId,
        repeat: booking_data.repeat,
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
        views: {
            resourceTimelineDay: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            resourceTimelineWeek: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            resourceTimelineMonth: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
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

function getTimeDifference(start, end) {
    var startTime = new Date(start);
    var endTime = new Date(end);
    let difference = Math.abs(endTime - startTime);
    var hours = Math.floor(difference / (1000 * 60 * 60));
    var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    return `${hours < 10 ? '0' + hours : hours}:${minutes < 10 ? '0' + minutes : minutes}`;
}

function getTimeString(dateStr) {
    var date = new Date(dateStr);
    return formattedTime = date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true }).replace(/^0/, '');;
}

function viewRepeatDetails() {
    var repeat = $("[name='repeat']").val();
    var dateString = $('[name="date"]').val();
    if(repeat == "none") {
        $('#by-container').html('');
        $('#repeat-wrapper').slideUp();
    }else {
        $('#repeat-wrapper').slideDown();
        var html = '<div>'+
                        '<label class="title-label">On</label>'+
                    '</div>';
        if(repeat == 'weekly') {
            html += '<div class="weekly-container">'+
                        '<input class="form-check-input" type="checkbox" value="su" '+ (getWeekday(dateString) == "su" ? "checked" : "") +' id="su" name="su">'+
                        '<label class="form-check-label" for="su">Sun</label>'+
                        '<input class="form-check-input" type="checkbox" value="mo" '+ (getWeekday(dateString) == "mo" ? "checked" : "") +' id="mo" name="mo">'+
                        '<label class="form-check-label" for="mo">Mon</label>'+
                        '<input class="form-check-input" type="checkbox" value="tu" '+ (getWeekday(dateString) == "tu" ? "checked" : "") +' id="tu" name="tu">'+
                        '<label class="form-check-label" for="tu">Tus</label>'+
                        '<input class="form-check-input" type="checkbox" value="we" '+ (getWeekday(dateString) == "we" ? "checked" : "") +' id="we" name="we">'+
                        '<label class="form-check-label" for="we">Wed</label>'+
                        '<input class="form-check-input" type="checkbox" value="th" '+ (getWeekday(dateString) == "th" ? "checked" : "") +' id="th" name="th">'+
                        '<label class="form-check-label" for="th">Thu</label>'+
                        '<input class="form-check-input" type="checkbox" value="fr" '+ (getWeekday(dateString) == "fr" ? "checked" : "") +' id="fr" name="fr">'+
                        '<label class="form-check-label" for="fr">Fri</label>'+
                        '<input class="form-check-input" type="checkbox" value="sa" '+ (getWeekday(dateString) == "sa" ? "checked" : "") +' id="sa" name="sa">'+
                        '<label class="form-check-label" for="sa">Sat</label>'+
                    '</div>';
        }else if(repeat == 'monthly by days in month') {
            html += '<div>'+
                        '<input type="text" class="form-control" value="'+ getDate(dateString) +'" name="bymonthday">'+
                        '<label>(ie: 10,15)</label>'+
                    '</div>'
        }else if(repeat == 'monthly by days in week') {
            html += '<div>'+
                        '<input type="text" class="form-control" value="'+ getWeekPositionOfMonth(dateString) +'" name="bysetpos">'+
                        '<label>(ie: 1:first)</label>'+
                    '</div>'

            html += '<div>'+
                        '<input type="text" class="form-control" value="'+ getWeekday(dateString) +'" name="byweekday">'+
                        '<label>(ie mo:Monday)</label>'+
                    '</div>'
        }else {
            html = '';
        }

        $('#by-container').html(html);
    }
}

function getWeekday(dateString) {
    var date = new Date(dateString);
    var dayOfWeek = date.getDay();
    var weekdays = ["su", "mo", "tu", "we", "th", "fr", "sa"];
    var weekdayName = weekdays[dayOfWeek];
    return weekdayName;
}

function getMonth(dateString) {
    var date = new Date(dateString);
    return ((date.getMonth()+1)+"").padStart(2, '0');
}

function getDate(dateString) {
    var date = new Date(dateString);
    return date.getDate();
}

function getWeekPositionOfMonth(dateString) {
    var date = new Date(dateString);
    var dayOfWeek = date.getDay();
    var dayOfMonth = date.getDate();
    var firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);
    var firstDayOfWeek = firstDayOfMonth.getDay();
    var dayDifference = dayOfMonth - (firstDayOfWeek - 1);
    var weekPosition = Math.ceil(dayDifference / 7);
    return weekPosition;
}

function isBookingConflict(newBooking) {
    toastr.info("Checking Overlap");
    jQuery(".preloader").show();
    jQuery(".preloader").css("background", "#1B213280");
    const RRule = rrule.RRule;

    var newOccurrences = [];
    if(newBooking.repeat == 'none') {
        newOccurrences.push(newBooking.start);
    }else {
        const newRule = new RRule(newBooking.rrule);

        newOccurrences = newRule.between(
            newBooking.rrule.dtstart,
            new Date(new Date().setFullYear(newBooking.rrule.dtstart.getFullYear() + 1)),
            true
        )
    }

    for (var i = 0; i < real_bookings.length; i++) {
        var existingBooking = JSON.parse(JSON.stringify(real_bookings[i])) ;
        if(existingBooking.resourceId != newBooking.resourceId) {
            continue;
        }
        var existingOccurrences = [];
        if(existingBooking.repeat == 'none') {
            existingOccurrences.push(new Date(existingBooking.start));
        }else {
            existingBooking.rrule.freq = getRfreq(existingBooking.rrule.freq);
            existingBooking.rrule.dtstart = new Date(existingBooking.rrule.dtstart);
            if(existingBooking.rrule.until)
                existingBooking.rrule.until = new Date(existingBooking.rrule.until);
            var weekdays = ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'];
            if (existingBooking.rrule.byweekday) existingBooking.rrule.byweekday = existingBooking.rrule.byweekday.map((item) => weekdays.indexOf(item));

            var existingRule = new RRule(existingBooking.rrule);
            existingOccurrences = existingRule.between(
                existingBooking.rrule.dtstart,
                new Date(new Date().setFullYear(existingBooking.rrule.dtstart.getFullYear() + 1)),
                true
            );

        }

        for (const existingStart of existingOccurrences) {
            var existingEnd = existingBooking.repeat == 'none' ? new Date(existingBooking.end) : new Date(existingStart.getTime() + parseDuration(existingBooking.duration));
            for (const newStart of newOccurrences) {
                var newEnd = newBooking.repeat == 'none' ? newBooking.end : new Date(newStart.getTime() + parseDuration(newBooking.duration));
                if (isOverlap(existingStart, existingEnd, newStart, newEnd)) {
                    jQuery(".preloader").hide();
                    return true;
                }
            }
        }
    }
    jQuery(".preloader").hide();
    return false;
}

function getRfreq(freq) {
    var freqSArray = ['yearly', 'monthly', 'weekly', 'daily'];
    return freqSArray.indexOf(freq)
}

function isOverlap(start1, end1, start2, end2) {
    return (start1 < end2 && start2 < end1);
}

function parseDuration(durationString) {
    const [hours, minutes] = durationString.split(':').map(Number);
    return hours * 60 * 60 * 1000 + minutes * 60 * 1000;
}

function checkValidation() {
    if($('[name="room"]').val() == '') {
        toastr.warning("Room field is required.");
        return false;
    }
    if($('[name="date"]').val() == '') {
        toastr.warning("Date field is required.");
        return false;
    }
    if($('[name="name"]').val() == '') {
        toastr.warning("Name field is required.");
        return false;
    }
    if($('[name="number"]').val() == '') {
        toastr.warning("Phone field is required.");
        return false;
    }
    if($('[name="email"]').val() == '') {
        toastr.warning("Email field is required.");
        return false;
    }
    if($('[name="title"]').val() == '') {
        toastr.warning("Title field is required.");
        return false;
    }
    if($('[name="reason"]').val() == '') {
        toastr.warning("Reason field is required.");
        return false;
    }
    return true;
}

function checkDateValidation() {
    var start = new Date($('[name="date"').val() + " " +  $('[name="start_at"').val()).getTime();
    var currnet = new Date().getTime();
    if(start - currnet < 86400) {
        toastr.warning("Booking must be made one day in advance.");
        return false;
    }
    return true;
}

function checkTimeValidation() {
    var start = new Date($('[name="date"').val() + " " +  $('[name="start_at"').val());
    var end = new Date($('[name="date"').val() + " " +  $('[name="end_at"').val());
    if(start>=end) {
        toastr.warning("The end time must be later than the start time.");
        return false;
    }
    return true;
}

function checkOverlapping() {
    var resourceId = parseInt($('[name="room"]').val());
    var repeat = $('[name="repeat"]').val();
    var date = $('[name="date"]').val();
    var start = new Date(date + " " + $('[name="start_at"]').val());
    var end = new Date(date + " " + $('[name="end_at"]').val());
    var interval = parseInt($('[name="interval"]').val());
    var until = $('[name="until"]').val();
    var count = $('[name="count"]').val();
    var byweekday = $('[name="byweekday"]').val();
    var bymonthday = $('[name="bymonthday"]').val();
    var bysetpos = $('[name="bysetpos"]').val();

    var newBooking = {repeat, resourceId};
    if(repeat == 'none') {
        newBooking.start = start,
        newBooking.end = end
    }else {
        var rrule = {
            freq: getRfreq(repeat.search('monthly') == -1 ? repeat: 'monthly'),
            interval,
            dtstart: start,
        };

        if ($("[name='rend']").val() == 'until') rrule.until = new Date(until);
        if ($("[name='rend']").val() == 'count') rrule.count = parseInt(count);

        var weekdays = ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'];
        if (byweekday && weekdays.includes(byweekday)) {
            rrule.byweekday.push(weekdays.indexOf(byweekday));
        }
        for (i=0; i<weekdays.length; i++) {
            if ($('[name="'+weekdays[i]+'"]').prop('checked')) {
                rrule.byweekday.push(i);
            }
        }

        if (bymonthday) {
            if (bymonthday.endsWith(',')) {
                bymonthday = bymonthday.slice(0, -1);
            }
            rrule.bymonthday = bymonthday.split(",");
            rrule.bymonthday = rrule.bymonthday.map(element => parseInt(element));
        }
        if (bysetpos) rrule.bysetpos = parseInt(bysetpos);

        newBooking.rrule = rrule;
        newBooking.duration = getTimeDifference(start, end);
    }

    if (isBookingConflict(newBooking)) {
        toastr.warning("Booking conflicts with existing bookings. Please choose another time.");
        return false;
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    view();
});

$("[name='rend']").change(function() {
    var selected = $(this).val();
    $("[name='until']").attr("disabled", true);
    $("[name='count']").attr("disabled", true);
    $("[name='"+selected+"']").attr("disabled", false);
});

var checked = false;
$("#buyForm").submit(function(event) {
    if(!checked) {
        event.preventDefault();
        if(checkValidation()){
            if(checkDateValidation()) {
                if(checkTimeValidation()) {
                    if(checkOverlapping()) {
                        checked = true;
                        toastr.success("succes")
                        $(this).submit();
                    }
                }
            }
        }
    }
});


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
