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
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .team-members {
            text-align: center;
            margin-bottom: 20px;
        }
        .team-members p {
            font-size: 1.2em;
            color: #333;
        }
        .search-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 50%;
        }
        .search-bar button {
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #0056b3;
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
        /* Center the 'Developed By' section */
        .Developed-By {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
        }
        .Developed-By h2 {
            font-size: 1.5em;
            color: #333;
        }
        .Developed-By p {
            font-size: 1.2em;
            color: #333;
        }
        .Developed-By b {
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Movies Available for Booking</h1>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search for a movie..." onkeyup="searchMovies()">
            <button onclick="searchMovies()">Search</button>
        </div>

        <div class="movie-list" id="movieList">
            @foreach ($movies as $movie)
                <div class="movie" data-title="{{ strtolower($movie->title) }}">
                    <h3>{{ $movie->title }}</h3>
                    <p>Genre: {{ $movie->genre }}</p>
                    <p>Duration: {{ $movie->duration }} minutes</p>
                    <a href="{{ url('/movies/book/' . $movie->id) }}" class="button">Book Now</a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Team Members Section -->
    <div class="Developed-By">
        <h2><strong><u>Developed By:</u></strong></h2><br>
        <p><b>
            1. Arjun Kanani<br><br>
            2. Arydeepsinh Jadeja<br><br>
            3. Fenil Galani
        </b></p>
    </div>

    <script>
        function searchMovies() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let movies = document.querySelectorAll('.movie');

            movies.forEach(function(movie) {
                let title = movie.getAttribute('data-title');
                if (title.includes(input)) {
                    movie.style.display = '';
                } else {
                    movie.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
