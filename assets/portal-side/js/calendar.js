$(document).ready(function() {

    $('.calendar').fullCalendar({
        header: {
            left    : 'prev,next today',
            center  : 'title',
            right   : 'agendaDay,agendaWeek,month,listWeek'
        },
        buttonText: {
            today   : 'Today',
            month   : 'Month',
            week    : 'Week',
            day     : 'Day',
            list    : 'List View'
        },
        buttonIcons: {
            prev    : 'calendar__prev',
            next    : 'calendar__next'
        },
        theme           : false,
        defaultView     :'agendaDay',
        displayEventTime: false,
        selectable      : true,
        selectHelper    : true,
        editable        : false,
        events          : base_url+'home/appointment_events',
        slotDuration    : '00:30:00',
        slotLabelInterval: 30,
        slotLabelFormat: 'h(:mm) a',
        minTime: '10:00:00',
        maxTime: '20:30:00',
        slotEventOverlap : false,
        dayClick: function(date) {
            var isoDate     = moment(date).toISOString();
            var todaydate   = moment().format("MM-DD-YYYY");

            if (!moment(todaydate).isAfter(isoDate, 'day')) {
                load_appointment(isoDate);
            } else { 
                alert('You can not add events in past dates');
            }                
        },
        eventClick: function (event, element) {
            $('#edit-event').modal('show');
            $('.edit-event__id').val(event.id);
            $('.view-profile').attr('href',base_url+'patient/view/'+event.patient_id);
            $('.edit-appointment').attr('data-id',event.id);
            $('.delete-appointment').attr('data-id',event.id);
        }
    });
    //Calendar views switch
    $('body').on('click', '[data-calendar-view]', function(e){
        e.preventDefault();

        $('[data-calendar-view]').removeClass('actions__item--active');
        $(this).addClass('actions__item--active');
        var calendarView = $(this).attr('data-calendar-view');
        $('.calendar').fullCalendar('changeView', calendarView);
    });

    //Calendar Next
    $('body').on('click', '.actions__calender-next', function (e) {
        e.preventDefault();
        $('.calendar').fullCalendar('next');
    });

    //Calendar Prev
    $('body').on('click', '.actions__calender-prev', function (e) {
        e.preventDefault();
        $('.calendar').fullCalendar('prev');
    });
});