<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MovieFormRequest;
use App\Models\Movie;

class MovieController extends Controller
{
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('main.movies.index')->with('movies', Movie::orderBy('title')->paginate(20));
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): View
    {
        return view('main.movies.show')->with('movie', $movie);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('main.movies.create')->with('movie', new Movie());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie): View
    {
        return view('main.movies.edit')->with('movie', $movie);
    }


    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieFormRequest $request): RedirectResponse
    {
        $newMovie = Movie::create($request->validated());

        if ($request->hasFile('image_file')) {
            $request->image_file->storeAs('public/posters', $newMovie->poster_filename);
        }

        $url = route('movie.show', ['movie' => $newMovie]);

        $htmlMessage = "Movie <a href='$url'><u>{$newMovie}</u></a> has been created successfully!";

        return redirect()->route('movie.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovieFormRequest $request, Movie $movie): RedirectResponse
    {
        $movie->update($request->validated());

        if ($request->hasFile('image_file')) {
            if ($movie->imageExists) {
                Storage::delete("public/posters/{$movie->poster_filename}");
            }

            $request->image_file->storeAs('public/posters', $movie->poster_filename);
        }

        $url = route('movie.show', ['movie' => $movie]);

        $htmlMessage = "Movie <a href='$url'><u>{$movie}</u></a> has been updated successfully!";

        return redirect()->route('movie.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        try {
            $url = route('movie.index', ['movie' => $movie]);

            $hasScreenings = DB::scalar(
                'SELECT COUNT(*) FROM SCREENINGS WHERE MOVIE_ID = ?',
                [$movie->id]
            );

            if ($hasScreenings) {
                $movie->delete();

                if ($movie->imageExists) {
                    Storage::delete("public/posters/{$movie->poster_filename}");
                }

                $alertType = 'success';
                $alertMsg = "Movie {$movie} has been deleted successfully!";
            } else {
                $screeningJustif = match ($hasScreenings) {
                    1 => "is 1 screening",
                    default => "are {$hasScreenings} screenings",
                };

                $justification = "there {$screeningJustif} for this movie.";

                $alertType = 'warning';
                $alertMsg = "Movie <a href='$url'><u>{$movie}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the movie <a href='$url'><u>{$movie}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('movie.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
