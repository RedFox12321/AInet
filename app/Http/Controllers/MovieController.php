<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MovieFormRequest;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Support\Str;

class MovieController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Movie::class);
    }
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $filterByGenre = $request->query('genre');
        $filterByTitleSynopsis = $request->search;
        $movieQuery = Movie::query();
        $allNull = true;


        if ($filterByGenre !== null) {
            $allNull = false;
            $movieQuery->whereHas('genre', function ($userQuery) use ($filterByGenre) {
                $userQuery->where('code', $filterByGenre);
            });
        }
        if ($filterByTitleSynopsis !== null) {
            $allNull = false;
            $movieQuery->where(function ($userQuery) use ($filterByTitleSynopsis) {
                $userQuery->where('title', 'LIKE', '%' . $filterByTitleSynopsis . '%')
                    ->orWhere('synopsis', 'LIKE', '%' . $filterByTitleSynopsis . '%');
            });
        }

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('movies.index');
        }

        $movies = $movieQuery
            ->with('genre')
            ->orderBy('title')
            ->paginate(20)
            ->withQueryString();

        $genres = Genre::all();

        return view(
            'main.movies.index',
            compact('movies', 'filterByGenre', 'filterByTitleSynopsis', 'genres')
        );
    }

    public function showcase(Request $request): View|RedirectResponse
    {
        $filterByGenre = $request->query('genre');
        $filterByTitleSynopsis = $request->search;
        $movieQuery = Movie::query();
        $allNull = true;

        $movieQuery->whereHas('screenings', function ($query) {
            $query->whereBetween('date', [today(), today()->addWeeks(2)]);
        });

        if ($filterByGenre !== null) {
            $allNull = false;
            $movieQuery->with('genre')->whereHas('genre', function ($query) use ($filterByGenre) {
                $query->where('code', $filterByGenre);
            });
        }

        if ($filterByTitleSynopsis !== null) {
            $allNull = false;
            $movieQuery->where(function ($userQuery) use ($filterByTitleSynopsis) {
                $userQuery->where('title', 'LIKE', '%' . $filterByTitleSynopsis . '%')
                    ->orWhere('synopsis', 'LIKE', '%' . $filterByTitleSynopsis . '%');
            });
        }

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('movies.showcase');
        }

        $movies = $movieQuery
            ->with(['screenings', 'genre'])
            ->orderBy('title')
            ->paginate(20)
            ->withQueryString();

        $genres = Genre::all();

        return view(
            'main.movies.showcase',
            compact('movies', 'filterByGenre', 'filterByTitleSynopsis', 'genres')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): View
    {
        $screeningsQuery = \App\Models\Screening::query();

        $screeningsQuery->whereBetween('date', [today(), today()->addHours(23.59)]);

        $screeningsQuery->with('movie')->whereHas('movie', function ($userQuery) use ($movie) {
            $userQuery->where('title', 'LIKE', '%' . $movie->title . '%');
        });

        $screenings = $screeningsQuery
            ->with('movie')
            ->get();

        return view(
            'main.movies.show',
            compact('movie', 'screenings')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $genres = Genre::all();
        $movie = new Movie();

        return view(
            'main.movies.create',
            compact('movie', 'genres')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie): View
    {
        $genres = Genre::all();

        return view(
            'main.movies.edit',
            compact('movie', 'genres')
        );
    }


    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieFormRequest $request): RedirectResponse
    {
        $newMovie = Movie::create($request->validated());

        if ($request->hasFile('image_file')) {
            $newMovie->poster_filename = $newMovie->id . "_" . Str::random(40);
            $newMovie->update();

            $request->image_file->storeAs('public/posters/', $newMovie->poster_filename);
        }

        $url = route('movies.show', ['movie' => $newMovie]);

        $htmlMessage = "Movie <a href='$url'><u>#{$newMovie->id}</u></a> has been created successfully!";

        return redirect()->route('movies.index')
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

            if (empty($movie->poster_filename)) {
                $movie->poster_filename = $movie->id . "_" . Str::random(40);
                $movie->update();
            }

            $request->image_file->storeAs('public/posters/', $movie->poster_filename);
        }

        $url = route('movies.show', ['movie' => $movie]);

        $htmlMessage = "Movie <a href='$url'><u>#{$movie->id}</u></a> has been updated successfully!";



        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        try {
            $url = route('movies.index', ['movie' => $movie]);

            $movie->delete();

            if ($movie->imageExists) {
                Storage::delete("public/posters/{$movie->poster_filename}");
            }

            $alertType = 'success';
            $alertMsg = "Movie #{$movie->id} has been deleted successfully!";

        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the movie <a href='$url'><u>#{$movie->id}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('movies.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
    public function destroyImage(Movie $movie): RedirectResponse
    {
        if ($movie->poster_filename) {
            if (Storage::fileExists('public/photos/' . $movie->poster_filename)) {
                Storage::delete('public/photos/' . $movie->poster_filename);
            }
            $movie->poster_filename = null;
            $movie->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of user {$movie->name} has been deleted.");
        }
        return redirect()->back();
    }
}
