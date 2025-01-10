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

        .legend {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Booking Calendar</h1>

        <div class="legend">
            <div class="legend-item">
                <div class="legend-color" style="background-color: #28a745;"></div>
                <span>Approved</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #ffc107;"></div>
                <span>Pending</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #dc3545;"></div>
                <span>Cancelled</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #17a2b8;"></div>
                <span>Completed</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #6c757d;"></div>
                <span>Other</span>
            </div>
        </div>

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
                    // Function to determine event color based on status
                    function getStatusColor(status) {
                        switch (status.toLowerCase()) {
                            case 'approved':
                                return '#28a745'; // Green
                            case 'pending':
                                return '#ffc107'; // Yellow
                            case 'cancelled':
                                return '#dc3545'; // Red
                            case 'completed':
                                return '#17a2b8'; // Blue
                            default:
                                return '#6c757d'; // Gray
                        }
                    }

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
                        backgroundColor: getStatusColor(booking.status)
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
