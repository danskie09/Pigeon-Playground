<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Calendar</title>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <style>
        .container {
            width: 90%;
            margin: 20px auto;
        }

        #calendar {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .fc-event {
            cursor: pointer;
            padding: 2px 5px;
        }

        .fc-event-title {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Booking Calendar</h1>
        <div id="calendar"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var bookings = @json($bookings);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                events: bookings.map(function(booking) {
                    return {
                        title: 'Booking #' + booking.booking_number,
                        start: booking.check_in,
                        end: booking.check_out,
                        extendedProps: {
                            customer: booking.user.name,
                            rooms: booking.rooms.map(room => room.name).join(', '),
                            adults: booking.adult,
                            kids: booking.kids,
                            status: booking.status,
                            total_amount: booking.total_amount,
                            payment_method: booking.payment_method,
                            special_request: booking.special_request,
                            check_in: new Date(booking.check_in).toLocaleDateString(),
                            check_out: new Date(booking.check_out).toLocaleDateString()
                        },
                        backgroundColor: booking.status === 'approved' ? '#28a745' : '#ffc107'
                    }
                }),
                eventClick: function(info) {
                    alert(
                        '📋 Booking Details\n' +
                        '------------------------\n' +
                        '🔖 ' + info.event.title + '\n' +
                        '👤 Customer: ' + info.event.extendedProps.customer + '\n' +
                        '🏠 Rooms: ' + info.event.extendedProps.rooms + '\n' +
                        '📅 Check-in: ' + info.event.extendedProps.check_in + '\n' +
                        '📅 Check-out: ' + info.event.extendedProps.check_out + '\n' +
                        '👥 Adults: ' + info.event.extendedProps.adults + '\n' +
                        '👶 Kids: ' + info.event.extendedProps.kids + '\n' +
                        '💰 Total Amount: ₱' + info.event.extendedProps.total_amount + '\n' +
                        '💳 Payment Method: ' + info.event.extendedProps.payment_method + '\n' +
                        '🏷️ Status: ' + info.event.extendedProps.status + '\n' +
                        (info.event.extendedProps.special_request ? '📝 Special Request: ' + info
                            .event.extendedProps.special_request + '\n' : '')
                    );
                }
            });

            calendar.render();
        });
    </script>
</body>

</html>
