<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Bookings</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
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
                        @foreach($bookings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->booking_number }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y H:i') }}</td>
                            <td>
                                {{ $booking->adult }} Adult(s)
                                @if($booking->kids)
                                    <br>
                                    {{ $booking->kids }} Kid(s)
                                @endif
                            </td>
                            <td>
                                @foreach($booking->rooms as $room)
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
                                    @if($booking->status === 'pending')
                                        <form action="{{ route('bookings.approved', $booking) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">Approve Booking</button>
                                        </form>
                                    @elseif($booking->status === 'approved')
                                        <form action="" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger">Cancel Booking</button>
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

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</body>
</html>