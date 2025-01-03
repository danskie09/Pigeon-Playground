<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Room Booking Form</title>
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
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="border-bottom pb-3 mb-4">
                            <p class="text-muted small mb-1">Welcome,</p>
                            <p class="fw-medium">{{ Auth::user()->name }}</p>
                        </div>

                        <h1 class="h3 fw-light mb-4">Room Booking</h1>

                        <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="rooms-container">
                                <div class="room-selection mb-4 border-bottom pb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Room 1</h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-room" style="display: none;">Remove Room</button>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Select Room</label>
                                        <select name="room_ids[]" class="form-select room-select" required>
                                            <option value="">Choose a room...</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->id }}" data-price="{{ $room->price }}">
                                                    {{ $room->name }} - P {{ $room->price }}/night
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <button type="button" id="add-room" class="btn btn-outline-primary btn-sm">
                                    + Add Another Room
                                </button>
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

                            <div class="availability-container mb-3">
                                <div id="loading-spinner" class="d-none">
                                    <div class="d-flex align-items-center text-primary mb-2">
                                        <div class="spinner-border spinner-border-sm me-2" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span class="small">Checking rooms availability...</span>
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
                                <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" readonly>
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
            let roomCount = 1;
            let checkingAvailability = false;
            let timeoutId = null;
            
            $('#add-room').click(function() {
                roomCount++;
                const roomHtml = `
            <div class="room-selection mb-4 border-bottom pb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Room ${roomCount}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-room">Remove Room</button>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Select Room</label>
                    <select name="room_ids[]" class="form-select room-select" required>
                        <option value="">Choose a room...</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" data-price="{{ $room->price }}">
                                {{ $room->name }} - ${{ $room->price }}/night
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        `;
                $('#rooms-container').append(roomHtml);
                updateRemoveButtons();
                checkAvailability();
            });

            // Remove room
            $(document).on('click', '.remove-room', function() {
                $(this).closest('.room-selection').remove();
                roomCount--;
                updateRemoveButtons();
                checkAvailability();
                calculateTotal();
            });

            function updateRemoveButtons() {
                if (roomCount > 1) {
                    $('.remove-room').show();
                } else {
                    $('.remove-room').hide();
                }
            }

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

                let roomIds = [];
                $('.room-select').each(function() {
                    let value = $(this).val();
                    if (value) roomIds.push(value);
                });

                let checkIn = $('#check_in').val();
                let checkOut = $('#check_out').val();

                if (roomIds.length > 0 && checkIn && checkOut) {
                    checkingAvailability = true;
                    showLoadingSpinner();

                    $.ajax({
                        url: "{{ route('check.availability') }}",
                        method: "POST",
                        data: {
                            room_ids: roomIds,
                            check_in: checkIn,
                            check_out: checkOut,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            const messageElement = $('#availability-message');
                            messageElement
                                .text(response.message)
                                .removeClass(
                                    'text-success text-danger alert alert-success alert-danger')
                                .addClass(response.available ?
                                    'text-success alert alert-success' :
                                    'text-danger alert alert-danger')
                                .addClass('p-2 small');

                            $('#submit-button').prop('disabled', !response.available);
                        },
                        error: function() {
                            $('#availability-message')
                                .text('Error checking availability. Please try again.')
                                .removeClass('text-success alert-success')
                                .addClass('text-danger alert alert-danger p-2 small');

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

            function calculateTotal() {
                let total = 0;

                // Calculate room cost
                let checkIn = new Date($('#check_in').val());
                let checkOut = new Date($('#check_out').val());
                if (checkIn && checkOut) {
                    let nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));

                    $('.room-select').each(function () {
                        let selected = $(this).find('option:selected');
                        let price = selected.data('price');
                        if (price) {
                            total += price * nights;
                        }
                    });
                }



                // Calculate additional charges for adults and kids
                let adultCount = parseInt($('#adult').val()) || 0;
                let kidsCount = parseInt($('#kids').val()) || 0;

                total += (adultCount * 100) + (kidsCount * 50);

                // Update the total amount input
                $('#total_amount').val(total.toFixed(2));
            }

            // Attach event listeners for adults and kids input fields
            $('#adult, #kids').on('input', calculateTotal);

            // Update calculateTotal on other relevant events
            $(document).on('change', '.room-select', calculateTotal);
            $('#check_in, #check_out').on('input change', calculateTotal);

            $('#check_in, #check_out').on('input change', function() {
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
                
                if ($('.room-select').val() && $('#check_in').val() && $('#check_out').val()) {
                    showLoadingSpinner();
                }
                
                timeoutId = setTimeout(function() {
                    checkAvailability();
                    calculateTotal();
                }, 500);
            });

            // Date validation
            $('#check_in').on('change', function() {
                let checkIn = new Date($(this).val());
                let checkOut = new Date($('#check_out').val());
                
                $('#check_out').attr('min', $(this).val());
                
                if (checkOut <= checkIn) {
                    $('#check_out').val('');
                }
                calculateTotal();
            });
            
            let today = new Date().toISOString().split('T')[0];
            $('#check_in').attr('min', today);
        }); // End of document.ready
    </script>
</body>
</html>