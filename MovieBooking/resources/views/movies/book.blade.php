<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Movie - {{ $movie->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
            color: #666;
        }
        .form-group {
            margin: 20px 0;
        }
        label {
            font-size: 1em;
            color: #333;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #218838;
        }
        .otp-container {
            margin-top: 10px;
        }
        .seat-selection {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            grid-gap: 10px;
            margin-top: 20px;
        }
        .seat {
            width: 40px;
            height: 40px;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
            font-size: 14px;
        }
        .seat.selected {
            background-color: #28a745;
            color: white;
        }
        .seat.booked {
            background-color: #ddd;
            cursor: not-allowed;
        }
        .seat:hover {
            background-color: #dcdcdc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book Movie: {{ $movie->title }}</h1>
        <p>Director: {{ $movie->director }}</p>
        <p>Duration: {{ $movie->duration }} minutes</p>

        <form action="{{ url('/movies/book/' . $movie->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="seats">Number of Seats:</label>
                <input type="number" id="seats" name="seats" required min="1" max="10">
            </div>
            <div class="form-group seat-selection-container">
                <label for="seat-selection">Select Your Seats:</label>
                <div class="seat-selection" id="seatSelection">
                    <!-- Seats will be dynamically generated here -->
                </div>
            </div>
            <div class="form-group">
                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Your Mobile Number:</label>
                <input type="text" id="mobile" name="mobile" required>
            </div>

            <div class="form-group otp-container">
                <label for="otp">Enter OTP:</label>
                <input type="text" id="otp" name="otp" readonly required>
                <button type="button" id="generateOtp" class="button">Generate OTP</button>
            </div>

            <button type="submit" class="button">Confirm Booking</button>
        </form>
    </div>

    <script>
        // OTP Generation Logic
        document.getElementById('generateOtp').addEventListener('click', function() {
            const otp = Math.floor(100000 + Math.random() * 900000); // Generates a 6-digit OTP
            document.getElementById('otp').value = otp;  // Display OTP in input field
            alert("OTP Generated: " + otp);  // Show OTP in an alert (for testing purposes)
        });

        // Seat Selection Logic
        const seatSelectionContainer = document.getElementById('seatSelection');
        const numSeatsInput = document.getElementById('seats');
        let selectedSeats = [];

        // Function to create seats
        function createSeats() {
            const numSeats = parseInt(numSeatsInput.value);
            seatSelectionContainer.innerHTML = ''; // Clear previous seats
            selectedSeats = []; // Clear previously selected seats

            // Create 50 seats (can be adjusted as needed)
            for (let i = 1; i <= 50; i++) {
                const seat = document.createElement('div');
                seat.classList.add('seat');
                seat.textContent = i;

                // Prevent booking more than the available number of seats
                if (i <= numSeats) {
                    seat.addEventListener('click', function() {
                        if (!seat.classList.contains('booked')) {
                            seat.classList.toggle('selected');
                            const seatNumber = seat.textContent;

                            // Add or remove the seat number from selectedSeats array
                            if (seat.classList.contains('selected')) {
                                selectedSeats.push(seatNumber);
                            } else {
                                const index = selectedSeats.indexOf(seatNumber);
                                if (index > -1) {
                                    selectedSeats.splice(index, 1);
                                }
                            }
                            console.log(selectedSeats);
                        }
                    });
                } else {
                    seat.classList.add('booked'); // Mark seats as booked (cannot be selected)
                }

                seatSelectionContainer.appendChild(seat);
            }
        }

        // Update seat selection when the number of seats changes
        numSeatsInput.addEventListener('input', createSeats);

        // Initial seat creation
        createSeats();
    </script>
</body>
</html>
