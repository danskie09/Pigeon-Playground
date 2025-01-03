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
                        <input type="text" class="form-control" id="checkIn" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Check-out Date & Time</label>
                        <input type="text" class="form-control" id="checkOut" required>
                    </div>
                </div>
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
                <h4 class="section-title">Room Selection</h4>
                <div class="row g-3 scrollable-rooms" style="max-height: 400px; overflow-y: auto;">
                    <!-- Deluxe Room -->
                    <div class="col-12">
                        <div class="card room-card">
                            <input type="radio" class="btn-check" name="roomType" id="room1" value="1"
                                required>
                            <label class="btn card-body" for="room1">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <img src="{{ asset('assets/images/room101.webp') }}" class="img-fluid rounded"
                                            alt="Deluxe Room" style="width: 150px; height: 100px; object-fit: cover;">
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-title">Room 101</h5>
                                        <div class="d-flex gap-3">
                                            <span><i class="bi bi-people-fill"></i> Max 2 Adults</span>
                                            <span><i class="bi bi-wifi"></i> Free WiFi</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Superior Room -->
                    <div class="col-12">
                        <div class="card room-card">
                            <input type="radio" class="btn-check" name="roomType" id="room2" value="2"
                                required>
                            <label class="btn card-body" for="room2">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <img src="{{ asset('assets/images/room102.webp') }}" class="img-fluid rounded"
                                            alt="Superior Room" style="width: 150px; height: 100px; object-fit: cover;">
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-title">Room 102</h5>
                                        <div class="d-flex gap-3">
                                            <span><i class="bi bi-people-fill"></i> Max 3 Adults</span>
                                            <span><i class="bi bi-wifi"></i> Free WiFi</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Executive Suite -->
                    <div class="col-12">
                        <div class="card room-card">
                            <input type="radio" class="btn-check" name="roomType" id="room3" value="3"
                                required>
                            <label class="btn card-body" for="room3">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <img src="{{ asset('assets/images/room103.webp') }}" class="img-fluid rounded"
                                            alt="Executive Suite"
                                            style="width: 150px; height: 100px; object-fit: cover;">
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-title">Room 103</h5>
                                        <div class="d-flex gap-3">
                                            <span><i class="bi bi-people-fill"></i> Max 4 Adults</span>
                                            <span><i class="bi bi-wifi"></i> Free WiFi</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
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
        flatpickr("#checkIn", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today"
        });

        flatpickr("#checkOut", {
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
    </script>

</body>

</html>
