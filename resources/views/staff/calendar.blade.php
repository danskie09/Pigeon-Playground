<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Calendar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <style>
        .fc-event {
            cursor: pointer;
        }

        .fc-event-title {
            font-weight: bold;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4">Booking Calendar</h1>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <div class="d-flex align-items-center">
                        <div class="legend-color bg-success me-2"></div>
                        <span>Approved</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="legend-color bg-warning me-2"></div>
                        <span>Pending</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="legend-color bg-danger me-2"></div>
                        <span>Cancelled</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="legend-color bg-info me-2"></div>
                        <span>Completed</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="legend-color bg-secondary me-2"></div>
                        <span>Other</span>
                    </div>
                </div>

                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
