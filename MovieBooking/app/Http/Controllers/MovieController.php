<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Display the list of movies
    public function index()
    {
        $movies = Movie::all();
        return view('movies.index', compact('movies'));
    }

    // Show the booking form for a movie
    public function book($id)
    {
        $movie = Movie::find($id);
        return view('movies.book', compact('movie'));
    }

    // Handle the ticket booking submission
    public function confirmBooking(Request $request, $id)
    {
        $movie = Movie::find($id);

        // Validation (add more as needed)
        $request->validate([
            'name' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
            'selected_seats' => 'required|string', // Ensure seat numbers are present
            'email' => 'required|email',
            'mobile' => 'required|string'
        ]);

        // Parse the seat numbers (if you want to use as array)
        $seatNumbersString = $request->input('selected_seats'); // e.g., "A1,B2,C3"
        $seatNumbersArray = array_map('trim', explode(',', $seatNumbersString));

        // Pass everything to the confirmation view
        return view('movies.confirmation', [
            'movie'        => $movie,
            'name'         => $request->name,
            'email'        => $request->email,
            'mobile'       => $request->mobile,
            'seats'        => $request->seats,
            'seat_numbers' => $seatNumbersString, // as string for display
            // 'seat_numbers_array' => $seatNumbersArray, // if you want to use as array in Blade
        ]);
    }
}
