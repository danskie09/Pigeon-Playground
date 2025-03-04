<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

            <form action="{{ route('book.store') }}" method="POST">
                @csrf
                <!-- Guest Information Section -->
                <div class="booking-section">
                    <h4 class="section-title">Guest Information</h4>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Guest Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        {{-- <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <select class="form-control" id="country">
                                <option value="">Select a country</option>
                            </select>
                        </div> --}}

                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Stay Duration</label>
                        <select name="stay_duration" id="stay_duration" class="form-select" required>
                            <option value="">Select duration...</option>
                            <option value="daytime">Daytime (8am-9pm)</option>
                            <option value="overnight">Overnight (6pm-11pm)</option>
                        </select>
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
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" data-price="{{ $room->price }}" data-overnight="{{ $room->overnight_rate }}">
                                        {{ $room->name }} - Day: P{{ $room->price }}/day - Night: P{{ $room->overnight_rate }}/night
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
                        <input class="form-check-input" type="radio" name="paymentMethod" id="gcashPayment"
                            value="gcash">
                        <label class="form-check-label" for="gcashPayment">GCash</label>
                    </div>

                </div>

                <!-- GCash QR Section -->
                <!-- <div id="gcashQRSection" class="border rounded p-3 bg-light">
                    <div class="text-center mb-3">
                        <img src="assets/images/gcash-qr.png" alt="GCash QR Code" style="max-width: 200px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Payment Screenshot</label>
                        <input type="file" class="form-control" id="paymentProof" accept="image/*">
                        <img id="proofPreview" class="image-preview mt-2">
                    </div>
                </div> -->

                <!-- Special Request -->
                <div class="mb-3">
                    <label class="form-label">Special Requests</label>
                    <textarea class="form-control" id="special_request" rows="3"></textarea>
                </div>

                <!-- Total Amount -->
                <div class="mb-3">
                    <label class="form-label">Total Amount</label>
                    <input type="number" step="0.01" class="form-control form-control-lg" id="total_amount">
                </div>

                <button type="submit" id="submit-button" class="btn btn-primary btn-lg w-100">Confirm
                    Booking</button>
            </div>
            </form>

            <!-- Add this right after your form starts -->
            <div id="error-message" class="alert alert-danger" style="display: none;"></div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Include jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
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
                            <option value="{{ $room->id }}" 
                                data-price="{{ $room->price }}"
                                data-overnight="{{ $room->overnight_rate }}">
                                {{ $room->name }} - Day: P{{ $room->price }} / Night: P{{ $room->overnight_rate }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        `;
                    $('#rooms-container').append(roomHtml);
                    updateRemoveButtons();
                    checkAvailability();
                    calculateTotal(); // Add this to update total when new room is added
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
                    let stayDuration = $('#stay_duration').val();
                    
                    // Get only the date part, ignore time
                    let checkIn = $('#check_in').val().split(' ')[0];
                    let checkOut = $('#check_out').val().split(' ')[0];
                    
                    if (checkIn && checkOut) {
                        // Convert to Date objects for comparison
                        let checkInDate = new Date(checkIn);
                        let checkOutDate = new Date(checkOut);
                        
                        // Calculate number of days
                        let timeDiff = checkOutDate - checkInDate;
                        let daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                        
                        // Calculate room costs
                        $('.room-select').each(function() {
                            let selected = $(this).find('option:selected');
                            if (selected.val()) {
                                let dayPrice = parseFloat(selected.data('price')) || 0;
                                let nightPrice = parseFloat(selected.data('overnight')) || 0;
                                
                                if (stayDuration === 'daytime') {
                                    // If same date or 1 day difference, charge one day rate
                                    if (daysDiff <= 1) {
                                        total += dayPrice;
                                    } else {
                                        total += dayPrice * daysDiff;
                                    }
                                } else if (stayDuration === 'overnight') {
                                    // For overnight stays, charge night rate per night
                                    if (daysDiff <= 1) {
                                        total += nightPrice;
                                    } else {
                                        total += nightPrice * daysDiff;
                                    }
                                }
                            }
                        });

                        // Update display with room total
                        $('#total_amount').val(total);

                        // Fetch and add entrance fees
                        $.ajax({
                            url: "{{ route('entrance.fees') }}",
                            method: "GET",
                            success: function(response) {
                                let adultCount = parseInt($('#adult').val()) || 0;
                                let kidsCount = parseInt($('#kids').val()) || 0;
                                let entranceFees = (adultCount * parseFloat(response.adult_rate)) + (kidsCount * parseFloat(response.child_rate));
                                let finalTotal = parseFloat(total) + parseFloat(entranceFees);
                                
                                // Format the total to avoid the leading zeros and ensure proper decimal places
                                $('#total_amount').val(finalTotal.toFixed(2));
                            },
                            error: function() {
                                console.error('Failed to fetch entrance fees');
                            }
                        });
                    } else {
                        $('#total_amount').val('0.00');
                    }
                }

                // Make sure to call calculateTotal when adding a new room
                $('#add-room').on('click', function() {
                    // Wait for the new room to be added to the DOM
                    setTimeout(calculateTotal, 100);
                });

                // Add event listeners for all inputs that affect total
                $('#adult, #kids, #stay_duration').on('input change', calculateTotal);
                
                // Update total when room is selected
                $(document).on('change', '.room-select', function() {
                    calculateTotal();
                    checkAvailability();
                });

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

            // Form submission handling
            $('form').on('submit', function(e) {
                e.preventDefault();
                
                // Populate the modal with booking details
                $('#summary-name').text($('#name').val());
                $('#summary-email').text($('#email').val());
                $('#summary-duration').text($('#stay_duration option:selected').text());
                $('#summary-checkin').text($('#check_in').val());
                $('#summary-checkout').text($('#check_out').val());
                $('#summary-total').text($('#total_amount').val());
                
                // Populate rooms summary
                let roomsSummary = '';
                $('.room-selection').each(function(index) {
                    let roomType = $(this).find('select[name="room_ids[]"] option:selected').text();
                    roomsSummary += `<p>Room ${index + 1}: ${roomType}</p>`;
                });
                $('#summary-rooms').html(roomsSummary);
                
                // Show the modal
                $('#confirmationModal').modal('show');
            });
            
            // Handle confirmation button click
            $('#confirmSubmit').on('click', function() {
                // Get the form data
                let formData = {
                    _token: $('input[name="_token"]').val(),
                    name: $('#name').val(),
                    email: $('#email').val(),
                    check_in: $('#check_in').val(),
                    check_out: $('#check_out').val(),
                    adult: $('#adult').val() || '1', // Default to 1 if not set
                    kids: $('#kids').val() || '0',   // Default to 0 if not set
                    payment_method: $('input[name="payment_method"]:checked').val() || 'cash', // Default to cash if not set
                    special_request: $('#special_request').val() || '',
                    total_amount: $('#total_amount').val(),
                    room_ids: []
                };

                // Get room IDs
                $('.room-selection').each(function() {
                    let roomId = $(this).find('select[name="room_ids[]"]').val();
                    if (roomId) {
                        formData.room_ids.push(roomId);
                    }
                });

                // Debug log
                console.log('Sending data:', formData);
                
                // Submit the form data
                $.ajax({
                    url: $('form').attr('action'),
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Success:', response);
                        $('#confirmationModal').modal('hide');
                        if (response.success) {
                            alert('Booking successful!');
                            window.location.reload();
                        } else {
                            alert(response.message || 'Booking completed successfully!');
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error details:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText
                        });
                        
                        let errorMessage = 'Error submitting booking: ';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Handle Laravel validation errors
                            const errors = xhr.responseJSON.errors;
                            errorMessage += Object.values(errors).flat().join('\n');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += xhr.responseJSON.message;
                        } else {
                            errorMessage += 'Please try again.';
                        }
                        
                        alert(errorMessage);
                    }
                });
            });
        });
    </script>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Booking Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Guest Information</h6>
                            <p><strong>Name:</strong> <span id="summary-name"></span></p>
                            <p><strong>Email:</strong> <span id="summary-email"></span></p>
                            <p><strong>Stay Duration:</strong> <span id="summary-duration"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Booking Details</h6>
                            <p><strong>Check-in:</strong> <span id="summary-checkin"></span></p>
                            <p><strong>Check-out:</strong> <span id="summary-checkout"></span></p>
                            <p><strong>Total Amount:</strong> ₱<span id="summary-total"></span></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h6>Selected Rooms</h6>
                        <div id="summary-rooms"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                    <button type="button" class="btn btn-primary" id="confirmSubmit">Confirm Booking</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
