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

    // Handle movie booking
    public function book($id)
    {
        $movie = Movie::find($id);
        return view('movies.book', compact('movie'));
    }

    // Handle the ticket booking submission
    public function confirmBooking(Request $request, $id)
    {
        $movie = Movie::find($id);

        // Here, you could store the booking data, but for now, we'll just simulate a successful booking

        // Validation (you can add more validation as needed)
        $request->validate([
            'name' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
        ]);

        // For simplicity, we'll just pass the data to the confirmation view
        return view('movies.confirmation', [
            'movie' => $movie,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'seats' => $request->seats,
        ]);
    }
}

