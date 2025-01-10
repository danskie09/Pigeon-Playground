<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <!-- DataTables Buttons CSS -->
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .date-filter {
            min-width: 300px;
        }

        .dt-buttons {
            margin-bottom: 1rem;
        }

        .dt-button {
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <h4 class="mb-0">Bookings</h4>
                    <div class="d-flex gap-3">
                        <input type="text" id="dateFilter" class="form-control date-filter"
                            placeholder="Select date range">
                        <select id="statusFilter" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="bookingsTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>booking_number</th>
                                <th>Guest</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Guests</th>
                                <th>Room(s)</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->booking_number }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y H:i') }}</td>
                                    <td>
                                        {{ $booking->adult }} Adult(s)
                                        @if ($booking->kids)
                                            <br>
                                            {{ $booking->kids }} Kid(s)
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($booking->rooms as $room)
                                            <span class="badge bg-info">{{ $room->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>P {{ number_format($booking->total_amount, 2) }}</td>
                                    <td>{{ $booking->payment_method }}</td>
                                    <td>
                                        @switch($booking->status)
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @break

                                            @case('confirmed')
                                                <span class="badge bg-success">Confirmed</span>
                                            @break

                                            @case('cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @break

                                            @case('completed')
                                                <span class="badge bg-primary">Completed</span>
                                            @break

                                            @default
                                                <span class="badge bg-secondary">{{ $booking->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if ($booking->status === 'pending')
                                                <form action="{{ route('bookings.approved', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success">Approve
                                                        Booking</button>
                                                </form>
                                            @elseif($booking->status === 'approved')
                                                <form action="" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger">Cancel
                                                        Booking</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Required JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <!-- Date Range Picker JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize date range picker
            $('#dateFilter').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'MMM DD, YYYY'
                }
            });

            $('#dateFilter').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MMM DD, YYYY') + ' - ' + picker.endDate.format(
                    'MMM DD, YYYY'));
                filterTable();
            });

            $('#dateFilter').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                filterTable();
            });

            var table = $('#bookingsTable').DataTable({
                responsive: true,
                order: [
                    [0, 'desc']
                ], // Sort by ID column descending
                columnDefs: [{
                    targets: -1, // Last column (Actions)
                    orderable: false,
                    searchable: false
                }],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                language: {
                    search: "Search bookings:",
                    lengthMenu: "Show _MENU_ bookings per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ bookings",
                    infoEmpty: "No bookings available",
                    infoFiltered: "(filtered from _MAX_ total bookings)"
                },
                dom: 'Bfrtip', // Restore 'B' to dom to handle buttons
                buttons: [{
                        extend: 'collection',
                        text: 'Export',
                        buttons: [{
                                extend: 'excel',
                                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                                className: 'btn btn-success',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude Actions column
                                },
                                title: 'Bookings_' + new Date().toISOString().slice(0, 10)
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                                className: 'btn btn-danger',
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                },
                                title: 'Bookings_' + new Date().toISOString().slice(0, 10)
                            }
                        ]
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer"></i> Print',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });

            // Remove the line that appends buttons to exportButtons
            // table.buttons().container().appendTo('#exportButtons');

            // Combined filter function
            function filterTable() {
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    var dateRange = $('#dateFilter').val();

                    if (!dateRange) {
                        return true;
                    }

                    var dates = dateRange.split(' - ');
                    var startDate = moment(dates[0], 'MMM DD, YYYY');
                    var endDate = moment(dates[1], 'MMM DD, YYYY');
                    var checkIn = moment(data[3], 'MMM DD, YYYY HH:mm'); // Index 3 is Check In column

                    return checkIn.isBetween(startDate, endDate, null, '[]');
                });

                table.draw();
                $.fn.dataTable.ext.search.pop(); // Remove the filter after drawing
            }

            // Add status filter functionality
            $('#statusFilter').on('change', function() {
                var status = $(this).val();
                table.column(9).search(status).draw();
            });
        });
    </script>
</body>

</html>
