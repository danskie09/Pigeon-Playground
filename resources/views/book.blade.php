<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto p-4">

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Whoops! Something went wrong.</strong>
            <ul class="mt-3 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @if (session('success'))
        <div class="bg-gray-100 border border-gray-400 text-gray-700 px-4 py-3 rounded relative mb-4">
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-8">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <p class="text-sm text-gray-600">Welcome,</p>
            <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
        </div>

        <h1 class="text-3xl font-light mb-8 text-gray-900">Room Booking</h1>
    @endif


    
        <p>{{ Auth::user()->name }}</p>
        <h1 class="text-2xl font-bold mb-4">Booking Form</h1>
        <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="room_id" class="block text-sm font-medium text-gray-700">Room ID</label>
                <input type="number" name="room_id" id="room_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            
            <div>
                <label for="check_in" class="block text-sm font-medium text-gray-700">Check In</label>
                <input type="datetime-local" name="check_in" id="check_in" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label for="check_out" class="block text-sm font-medium text-gray-700">Check Out</label>
                <input type="datetime-local" name="check_out" id="check_out" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>


            <!-- Availability Message Display -->
<div id="availability-message"></div>

            
            <div>
                <label for="adult" class="block text-sm font-medium text-gray-700">Adults</label>
                <input type="number" name="adult" id="adult" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label for="kids" class="block text-sm font-medium text-gray-700">Kids</label>
                <input type="number" name="kids" id="kids" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <input type="text" name="payment_method" id="payment_method" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
           
            <div>
                <label for="special_request" class="block text-sm font-medium text-gray-700">Special Request</label>
                <textarea name="special_request" id="special_request" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
            </div>
            <div>
                <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                <input type="number" step="0.01" name="total_amount" id="total_amount" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
            </div>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#check_in, #check_out, #room_id').on('change', function() {
            // Gather the values
            let roomId = $('#room_id').val();
            let checkIn = $('#check_in').val();
            let checkOut = $('#check_out').val();

            // Check that all required fields have values
            if (roomId && checkIn && checkOut) {
                // Send AJAX request to check availability
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
                        if (response.available) {
                            $('#availability-message').text(response.message).css('color', 'green');
                        } else {
                            $('#availability-message').text(response.message).css('color', 'red');
                        }
                    },
                    error: function() {
                        $('#availability-message').text('Error checking availability. Please try again.').css('color', 'red');
                    }
                });
            }
        });
    });
</script>
</body>
</html>