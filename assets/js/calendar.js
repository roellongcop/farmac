"use strict";

var KTCalendarBasic = function() {

    // [
    //     {
    //         id: 'asd',
    //         title: 'All Day Event',
    //         url: '',
    //         start: YM + '-01',
    //         end: YM + '-14',
    //         description: 'Toto lorem ipsum dolor sit incid idunt ut',
    //         className: "fc-event-light fc-event-solid-warning",
    //     },
    // ]

    const setCalendar = (events) => {
         var todayDate = moment().startOf('day');
        var TODAY = todayDate.format('YYYY-MM-DD');

        var calendarEl = document.getElementById('kt_calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [
                'bootstrap', 
                // 'interaction', 
                'dayGrid', 
                'timeGrid', 
                'list' 
            ],
            themeSystem: 'bootstrap',

            isRTL: KTUtil.isRTL(),

            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            height: 800,
            contentHeight: 780,
            aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

            nowIndicator: true,
            // now: TODAY + 'T09:25:00', // just for demo

            views: {
                dayGridMonth: { buttonText: 'month' },
                timeGridWeek: { buttonText: 'week' },
                timeGridDay: { buttonText: 'day' }
            },

            defaultView: 'dayGridMonth',
            defaultDate: TODAY,

            editable: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            events: events,

            eventClick: function(info) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    message: 'Loading Event...',
                    state: 'primary'
                });
                $.ajax({
                    url: app.baseUrl + 'event/view',
                    data: {token: info.event.id},
                    dataType: 'json',
                    success: (s) => {
                        if (s.status == 'success') {
                            $('#modal-event .modal-body').html(s.form);
                            $('#modal-event').modal('show');
                        }
                        else {
                            Swal.fire('Error', s.errorSummary, 'error');
                        }
                        KTApp.unblockPage();
                    },
                    error: (e) => {
                        Swal.fire('Error', e.responseText, 'error');
                        KTApp.unblockPage();
                    }
                })
            },


            eventRender: function(info) {
                var element = $(info.el);

                if (info.event.extendedProps && info.event.extendedProps.description) {
                    if (element.hasClass('fc-day-grid-event')) {
                        element.data('content', info.event.extendedProps.description);
                        element.data('placement', 'top');
                        KTApp.initPopover(element);
                    } else if (element.hasClass('fc-time-grid-event')) {
                        element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    } else if (element.find('.fc-list-item-title').lenght !== 0) {
                        element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    }
                }
            }
        });

        calendar.render();
    }

    const loadEvents = () => {
        $.ajax({
            url: app.baseUrl + 'event/load',
            dataType: 'json',
            success: (s) => {
                if (s.status == 'success') {
                    setCalendar(s.events);
                }
                else {
                    Swal.fire('Error', s.errorSummary, 'error');
                }
            },
            error: (e) => {
                Swal.fire('Error', e.responseText, 'error');
            }
        })
    }

    return {
        //main function to initiate the module
        init: function() {
           loadEvents();
            
        }
    };
}();

jQuery(document).ready(function() {
    KTCalendarBasic.init();
});

$('.btn-save-event').click(function() {
    KTApp.block('#modal-event .modal-body', {
        overlayColor: '#000000',
        message: 'Loading Event...',
        state: 'primary'
    });
    $(document).find('form#ajax-event-form').submit();
})
