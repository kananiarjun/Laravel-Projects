<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
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
        .confirmation-message {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
            color: #666;
        }
        .button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .qr-code-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        #qr-code {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-message">
            <h2>Your Booking is Confirmed!</h2>
        </div>
        <p>Movie: {{ $movie->title }}</p>
        <p>Director: {{ $movie->director }}</p>
        <p>Duration: {{ $movie->duration }} minutes</p>
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Seats Booked:</strong> {{ $seats }}</p>
        <p><strong>Seat Numbers:</strong> {{ $seat_numbers }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Mobile Number:</strong> {{ $mobile }}</p>

        <div class="qr-code-container">
            <p><strong>Scan this QR Code for your booking details:</strong></p>
            <div id="qr-code"></div>
        </div>

        <a href="{{ url('/movies') }}" class="button">Back to Movies</a>
        <button id="generatePDF" class="button">Download Ticket PDF</button>
    </div>

    <!-- Libraries at the END of body for guaranteed loading -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Safely encode Blade variables for use in JS (works in all Laravel versions)
        const movieTitle = {!! json_encode($movie->title) !!};
        const director = {!! json_encode($movie->director) !!};
        const duration = {!! json_encode($movie->duration) !!};
        const name = {!! json_encode($name) !!};
        const seats = {!! json_encode($seats) !!};
        const seatNumbers = {!! json_encode($seat_numbers) !!};
        const email = {!! json_encode($email) !!};
        const mobile = {!! json_encode($mobile) !!};

        const bookingInfo =
            "Movie: " + movieTitle + "\n" +
            "Director: " + director + "\n" +
            "Duration: " + duration + " minutes\n" +
            "Name: " + name + "\n" +
            "Seats: " + seats + "\n" +
            "Seat Numbers: " + seatNumbers + "\n" +
            "Email: " + email + "\n" +
            "Mobile: " + mobile;

        // Generate QR code
        const qrCodeElement = document.getElementById("qr-code");
        new QRCode(qrCodeElement, {
            text: bookingInfo,
            width: 128,
            height: 128
        });

        // PDF download
        document.getElementById('generatePDF').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFontSize(18);
            doc.text('Confirm Movie Ticket', 20, 20);

            doc.setFontSize(14);
            doc.text("Movie: " + movieTitle, 20, 40);
            doc.text("Director: " + director, 20, 50);
            doc.text("Duration: " + duration + " minutes", 20, 60);
            doc.text("Name: " + name, 20, 80);
            doc.text("Seats Booked: " + seats, 20, 90);
            doc.text("Seat Numbers: " + seatNumbers, 20, 100);
            doc.text("Email: " + email, 20, 110);
            doc.text("Mobile Number: " + mobile, 20, 120);

            // Add QR code to PDF
            const qrCanvas = document.querySelector('#qr-code canvas');
            if (qrCanvas) {
                const qrDataURL = qrCanvas.toDataURL();
                doc.addImage(qrDataURL, 'PNG', 20, 130, 50, 50);
            }

            doc.save('booking-confirmation.pdf');
        });
    });
    </script>
</body>
</html>
