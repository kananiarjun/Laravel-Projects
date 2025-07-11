<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
            display: block;
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
            border: none;
            cursor: pointer;
            font-size: 1em;
        }
        .button:hover {
            background-color: #218838;
        }
        .otp-container {
            margin-top: 10px;
        }
        /* Seat Selection Styles */
        .seat-selection-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 24px;
            background: #f7f9fa;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        }
        .seat-label {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 18px;
            display: block;
            color: #1a202c;
        }
        .seat-selection {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 18px;
        }
        .seat-row {
            display: flex;
            gap: 6px;
            justify-content: center;
        }
        .seat {
            width: 28px;
            height: 28px;
            background: #e2e8f0;
            border-radius: 6px 6px 8px 8px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
            transition: background 0.2s, border 0.2s, box-shadow 0.2s;
            position: relative;
            text-align: center;
            line-height: 24px;
            font-size: 0.9em;
            user-select: none;
        }
        .seat.selected {
            background: #38bdf8;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 2px #38bdf855;
            color: #fff;
        }
        .seat.booked, .seat.occupied {
            background: #94a3b8;
            border-color: #64748b;
            cursor: not-allowed;
            opacity: 0.7;
            color: #fff;
        }
        .seat:hover:not(.booked):not(.selected) {
            background: #bae6fd;
            border-color: #38bdf8;
        }
        .legend {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-top: 10px;
            color: #475569;
        }
        .legend .seat {
            display: inline-block;
            margin-right: 6px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book Movie: {{ $movie->title }}</h1>
        <p>Director: {{ $movie->director }}</p>
        <p>Duration: {{ $movie->duration }} minutes</p>

        <form action="{{ url('/movies/book/' . $movie->id) }}" method="POST" id="bookingForm">
            @csrf
            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required />
            </div>
            <div class="form-group">
                <label for="seats">Number of Seats:</label>
                <input type="number" id="seats" name="seats" required min="1" max="10" value="1" />
            </div>
            <!-- Seat Selection UI -->
            <div class="form-group seat-selection-container">
                <label for="seat-selection" class="seat-label">Select Your Seats:</label>
                <div class="seat-selection" id="seatSelection"></div>
                <div class="legend">
                    <span><span class="seat"></span> Available</span>
                    <span><span class="seat selected"></span> Selected</span>
                    <span><span class="seat booked"></span> Booked</span>
                </div>
            </div>
            <input type="hidden" name="selected_seats" id="selectedSeatsInput" />
            <div class="form-group">
                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required />
            </div>
            <div class="form-group">
                <label for="mobile">Your Mobile Number:</label>
                <input type="text" id="mobile" name="mobile" required />
            </div>
            <div class="form-group otp-container">
                <label for="otp">Enter OTP:</label>
                <input type="text" id="otp" name="otp" readonly required />
                <button type="button" id="generateOtp" class="button">Generate OTP</button>
            </div>
            <button type="submit" class="button" id="submitBtn" disabled>Confirm Booking</button>
        </form>
    </div>

    <script>
        // Example of booked seats (could come from backend)
        const bookedSeats = [
            'A1', 'A2', 'B5', 'C3', 'H7', 'J10', 'D4', 'F9', 'G6', 'E2'
        ];

        // Elements
        const seatSelection = document.getElementById('seatSelection');
        const numSeatsInput = document.getElementById('seats');
        const selectedSeatsInput = document.getElementById('selectedSeatsInput');
        const generateOtpBtn = document.getElementById('generateOtp');
        const otpInput = document.getElementById('otp');
        const submitBtn = document.getElementById('submitBtn');
        const bookingForm = document.getElementById('bookingForm');

        let selectedSeats = [];

        // Generate 10x10 grid of seats
        function renderSeats() {
            seatSelection.innerHTML = '';
            selectedSeats = [];
            selectedSeatsInput.value = '';
            const rows = 10, cols = 10;
            for (let r = 1; r <= rows; r++) {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'seat-row';
                for (let c = 1; c <= cols; c++) {
                    const seatNum = String.fromCharCode(64 + r) + c; // e.g., A1, B2
                    const seat = document.createElement('div');
                    seat.className = 'seat';
                    seat.dataset.seat = seatNum;
                    seat.textContent = seatNum;

                    // Mark as booked if in bookedSeats array
                    if (bookedSeats.includes(seatNum)) {
                        seat.classList.add('booked');
                    }

                    // Click logic
                    seat.addEventListener('click', function() {
                        if (seat.classList.contains('booked')) return;
                        if (seat.classList.contains('selected')) {
                            seat.classList.remove('selected');
                            selectedSeats = selectedSeats.filter(s => s !== seatNum);
                        } else {
                            if (selectedSeats.length < parseInt(numSeatsInput.value)) {
                                seat.classList.add('selected');
                                selectedSeats.push(seatNum);
                            } else {
                                alert('You can only select up to ' + numSeatsInput.value + ' seats.');
                            }
                        }
                        selectedSeatsInput.value = selectedSeats.join(',');
                    });

                    rowDiv.appendChild(seat);
                }
                seatSelection.appendChild(rowDiv);
            }
        }

        // When number of seats changes, reset selection
        numSeatsInput.addEventListener('input', function() {
            renderSeats();
        });

        // Initial render
        renderSeats();

        // OTP Generation Logic
        generateOtpBtn.addEventListener('click', function () {
            const otp = Math.floor(100000 + Math.random() * 900000); // 6-digit OTP
            otpInput.value = otp;
            otpInput.setCustomValidity('');
            alert("OTP Generated: " + otp);
            submitBtn.disabled = false;
        });

        // Form submission validation
        bookingForm.addEventListener('submit', function (e) {
            if (otpInput.value.trim() === '') {
                e.preventDefault();
                otpInput.setCustomValidity('OTP field is required');
                otpInput.reportValidity();
                return;
            }
            if (selectedSeats.length !== parseInt(numSeatsInput.value)) {
                e.preventDefault();
                alert('Please select exactly ' + numSeatsInput.value + ' seats.');
                return;
            }
            selectedSeatsInput.value = selectedSeats.join(',');
        });
    </script>
</body>
</html>
