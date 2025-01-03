<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />






    <title>Document</title>


    <style>
        .room-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .room-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-check:checked+.card-body {
            border: 2px solid #0d6efd;
            background-color: #f8f9ff;
        }

        #gcashQRSection {
            display: none;
        }

        .image-preview {
            max-width: 200px;
            display: none;
            margin-top: 10px;
        }

        .booking-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="row px-2 py-2">
        <!-- Left Column -->
        <div class="col-md-6 mb-4">

            <form action="" method="POST">
                @csrf
                <!-- Guest Information Section -->
                <div class="booking-section">
                    <h4 class="section-title">Guest Information</h4>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Guest Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <select class="form-control" id="country">
                                <option value="">Select a country</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Dates Section -->
                <div class="booking-section">
                    <h4 class="section-title">Booking Dates</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Check-in Date & Time</label>
                            <input type="text" class="form-control" id="check_in" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Check-out Date & Time</label>
                            <input type="text" class="form-control" id="check_out" required>
                        </div>
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

                <!-- Guest Count Section -->
                <div class="booking-section">
                    <h4 class="section-title">Guest Count</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Number of Adults</label>
                            <input type="number" class="form-control" id="adult" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Number of Children</label>
                            <input type="number" class="form-control" id="kids" min="0">
                        </div>
                    </div>
                </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-6">
            <!-- Room Selection Section -->
            <div class="booking-section">

                <div id="rooms-container">
                    <div class="room-selection mb-4 border-bottom pb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Room 1</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-room"
                                style="display: none;">Remove Room</button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Select Room</label>
                            <select name="room_ids[]" class="form-select room-select" required>
                                <option value="">Choose a room...</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" data-price="{{ $room->price }}">
                                        {{ $room->name }} - P {{ $room->price }}/night
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="button" id="add-room" class="btn btn-outline-primary btn-sm">
                    + Add Another Room
                </button>
            </div>
            <!-- Payment Section -->
            <div class="booking-section">
                <h4 class="section-title">Payment Details</h4>
                <div class="mb-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="cashPayment"
                            value="cash" checked>
                        <label class="form-check-label" for="cashPayment">Cash on Hand</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="gcash"
                            value="gcash">
                        <label class="form-check-label" for="gcashPayment">GCash</label>
                    </div>
                </div>

                <!-- GCash QR Section -->
                <div id="gcashQRSection" class="border rounded p-3 bg-light">
                    <div class="text-center mb-3">
                        <img src="assets/images/gcash-qr.png" alt="GCash QR Code" style="max-width: 200px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Payment Screenshot</label>
                        <input type="file" class="form-control" id="paymentProof" accept="image/*">
                        <img id="proofPreview" class="image-preview mt-2">
                    </div>
                </div>

                <!-- Special Request -->
                <div class="mb-3">
                    <label class="form-label">Special Requests</label>
                    <textarea class="form-control" id="specialRequest" rows="3"></textarea>
                </div>

                <!-- Total Amount -->
                <div class="mb-3">
                    <label class="form-label">Total Amount</label>
                    <input type="text" class="form-control form-control-lg" id="totalAmount" value="₱0.00"
                        readonly>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">Confirm Booking</button>
            </div>
            </form>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Include jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Initialize date pickers
        flatpickr("#check_in", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today"
        });

        flatpickr("#check_out", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today"
        });

        $(document).ready(function() {
            // Initialize Select2
            $('#country').select2({
                placeholder: 'Select a country',
                allowClear: true
            });

            // Load countries from JSON file
            fetch('/countries/country.json')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    const countrySelect = $('#country');
                    data.forEach(country => {
                        const option = new Option(country, country, false, false);
                        countrySelect.append(option).trigger('change');
                    });
                })
                .catch(error => {
                    console.error('Error loading countries:', error);
                    const countrySelect = $('#country');
                    const option = new Option("Error loading countries", "", false, false);
                    countrySelect.append(option).trigger('change');
                });
        });


        $(document).ready(function() {
            let roomCount = 1;

            // Add room
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
        }); // Added closing bracket for document.ready
    </script>

</body>

</html>
