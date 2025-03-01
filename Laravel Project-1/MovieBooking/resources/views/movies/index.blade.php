<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .movie-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .movie {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .movie img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .movie h3 {
            font-size: 1.5em;
            color: #333;
        }
        .movie p {
            font-size: 1em;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Movies Available for Booking</h1>
        <div class="movie-list">
            @foreach ($movies as $movie)
                <div class="movie">
                    
                    <h3>{{ $movie->title }}</h3>
                    <p>Genre: {{ $movie->genre }}</p>
                    <p>Duration: {{ $movie->duration }} minutes</p>
                    <a href="{{ url('/movies/book/' . $movie->id) }}" class="button">Book Now</a>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
