<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GenreFormRequest;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Genre::class);
    }

    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $filterByName = $request->search;
        $genreQuery = Genre::query();
        $allNull = true;

        if ($filterByName !== null) {
            $allNull = false;
            $genreQuery->where(function ($userQuery) use ($filterByName) {
                $userQuery->where('name', 'LIKE', '%' . $filterByName . '%');
            });
        }

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('genres.index');
        }

        $genres = $genreQuery
            ->paginate(20)
            ->withQueryString();



        return view(
            'main.genres.index',
            compact('genres', 'filterByName')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre): View
    {
        return view('main.genres.show')->with('genre', $genre);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('main.genres.create')->with('genre', new Genre());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre): View
    {
        return view('main.genres.edit')->with('genre', $genre);
    }


    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(GenreFormRequest $request): RedirectResponse
    {
        $newGenre = Genre::create($request->validated());

        $url = route('genres.show', ['genre' => $newGenre]);

        $htmlMessage = "Genre <a href='$url'><u>{$newGenre->code}</u></a> has been created successfully!";

        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GenreFormRequest $request, Genre $genre): RedirectResponse
    {
        $genre->update($request->validated());

        if ($request->hasFile('image_file')) {
            if ($genre->imageExists) {
                Storage::delete("public/photos/{$genre->photo_filename}");
            }

            $request->image_file->storeAs('public/photos', $genre->photo_filename);
        }

        $url = route('genres.show', ['genre' => $genre]);

        $htmlMessage = "Genre <a href='$url'><u>{$genre->code}</u></a> has been updated successfully!";

        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre): RedirectResponse
    {
        try {
            $url = route('genres.index', ['genre' => $genre]);

            $hasMovies = DB::scalar(
                'SELECT count(*) FROM movies WHERE ID = ?',
                [$genre->id]
            );

            if ($hasMovies == 0) {
                $genre->delete();

                $alertType = 'success';
                $alertMsg = "Genre {$genre->code} has been deleted successfully!";
            } else {
                $justification = match ($hasMovies) {
                    1 => "there is 1 movie",
                    default => "there are $hasMovies"
                };

                $alertType = 'warning';
                $alertMsg = "Genre <a href='$url'><u>{$genre->code}</u></a> cannot be deleted because $justification with this genre.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the genre <a href='$url'><u>{$genre->code}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('genres.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
