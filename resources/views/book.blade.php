<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <strong>Whoops! Something went wrong.</strong>
                <ul class="list-unstyled mt-3 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mb-4">
                <span class="fw-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="border-bottom pb-3 mb-4">
                            <p class="text-muted small mb-1">Welcome,</p>
                            <p class="fw-medium">{{ Auth::user()->name }}</p>
                        </div>

                        <h1 class="h3 fw-light mb-4">Room Booking</h1>

                        <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="room_id" class="form-label small">Room ID</label>
                                <input type="number" name="room_id" id="room_id" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="check_in" class="form-label small">Check In</label>
                                    <input type="datetime-local" name="check_in" id="check_in" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="check_out" class="form-label small">Check Out</label>
                                    <input type="datetime-local" name="check_out" id="check_out" class="form-control" required>
                                </div>
                            </div>

                            <!-- Modified availability message section -->
                            <div class="availability-container mb-3">
                                <div id="loading-spinner" class="d-none">
                                    <div class="d-flex align-items-center text-primary mb-2">
                                        <div class="spinner-border spinner-border-sm me-2" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span class="small">Checking room availability...</span>
                                    </div>
                                </div>
                                <div id="availability-message"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="adult" class="form-label small">Adults</label>
                                    <input type="number" name="adult" id="adult" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kids" class="form-label small">Kids</label>
                                    <input type="number" name="kids" id="kids" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="payment_method" class="form-label small">Payment Method</label>
                                <input type="text" name="payment_method" id="payment_method" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="special_request" class="form-label small">Special Request</label>
                                <textarea name="special_request" id="special_request" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="total_amount" class="form-label small">Total Amount</label>
                                <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" required>
                            </div>

                            <div>
                                <button type="submit" id="submit-button" class="btn btn-primary w-100" disabled>Complete Booking</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let checkingAvailability = false;
            let timeoutId = null;

            function showLoadingSpinner() {
                $('#loading-spinner').removeClass('d-none');
                $('#availability-message').addClass('d-none');
            }

            function hideLoadingSpinner() {
                $('#loading-spinner').addClass('d-none');
                $('#availability-message').removeClass('d-none');
            }

            function checkAvailability() {
                if (checkingAvailability) return;

                let roomId = $('#room_id').val();
                let checkIn = $('#check_in').val();
                let checkOut = $('#check_out').val();

                if (roomId && checkIn && checkOut) {
                    checkingAvailability = true;
                    showLoadingSpinner();

                    $.ajax({
                        url: "{{ route('check.availability') }}",
                        method: "POST",
                        data: {
                            room_id: roomId,
                            check_in: checkIn,
                            check_out: checkOut,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            const messageElement = $('#availability-message');
                            messageElement
                                .text(response.message)
                                .removeClass('text-success text-danger alert alert-success alert-danger')
                                .addClass(response.available ? 
                                    'text-success alert alert-success' : 
                                    'text-danger alert alert-danger')
                                .addClass('p-2 small');
                            
                            // Enable or disable the submit button based on availability
                            $('#submit-button').prop('disabled', !response.available);
                        },
                        error: function() {
                            $('#availability-message')
                                .text('Error checking availability. Please try again.')
                                .removeClass('text-success alert-success')
                                .addClass('text-danger alert alert-danger p-2 small');
                            
                            // Disable the submit button on error
                            $('#submit-button').prop('disabled', true);
                        },
                        complete: function() {
                            checkingAvailability = false;
                            hideLoadingSpinner();
                        }
                    });
                } else {
                    $('#availability-message').empty();
                    $('#submit-button').prop('disabled', true);
                }
            }

            // Add input event listeners with debouncing
            $('#check_in, #check_out, #room_id').on('input change', function() {
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
                
                // Only show loading if we have all required values
                let roomId = $('#room_id').val();
                let checkIn = $('#check_in').val();
                let checkOut = $('#check_out').val();
                
                if (roomId && checkIn && checkOut) {
                    showLoadingSpinner();
                }
                
                // Debounce the API call by 500ms
                timeoutId = setTimeout(checkAvailability, 500);
            });
        });
    </script>

    <script>
        // Optional: Add validation for check-in/check-out dates
        $(document).ready(function() {
            $('#check_in').on('change', function() {
                let checkIn = new Date($(this).val());
                let checkOut = new Date($('#check_out').val());
                
                // Set minimum check-out date to check-in date
                $('#check_out').attr('min', $(this).val());
                
                // If check-out date is before check-in date, reset it
                if (checkOut <= checkIn) {
                    $('#check_out').val('');
                }
            });
            
            // Set minimum check-in date to today
            let today = new Date().toISOString().split('T')[0];
            $('#check_in').attr('min', today);
        });
    </script>
</body>
</html>