<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TheaterFormRequest;
use App\Models\Theater;

class TheaterController extends Controller
{
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filterByName = $request->search;
        $theaterQuery = Theater::query();
        $allNull = true;

        if ($filterByName !== null) {
            $allNull = false;
            $theaterQuery->where(function ($userQuery) use ($filterByName) {
                $userQuery->where('name', 'LIKE', '%' . $filterByName . '%');
            });
        }

        if ($allNull && $request->query()) {
            return redirect()->route('theaters.index');
        }

        $theaters = $theaterQuery
            ->paginate()
            ->withQueryString();

        return view(
            'main.theaters.index',
            compact('theaters')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Theater $theater): View
    {
        return view('main.theaters.show')->with('theater', $theater);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('main.theaters.create')->with('theater', new Theater());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theater $theater): View
    {
        return view('main.theaters.edit')->with('theater', $theater);
    }


    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(TheaterFormRequest $request): RedirectResponse
    {
        $newTheater = Theater::create($request->validated());

        if ($request->hasFile('image_file')) {
            $request->image_file->storeAs('public/theaters', $newTheater->photo_filename);
        }

        $url = route('theaters.show', ['theater' => $newTheater]);

        $htmlMessage = "Theater <a href='$url'><u>{$newTheater}</u></a> has been created successfully!";

        return redirect()->route('theater.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TheaterFormRequest $request, Theater $theater): RedirectResponse
    {
        $theater->update($request->validated());

        if ($request->hasFile('image_file')) {
            if ($theater->imageExists) {
                Storage::delete("public/theaters/{$theater->photo_filename}");
            }

            $request->image_file->storeAs('public/theaters', $theater->photo_filename);
        }

        $url = route('theaters.show', ['theater' => $theater]);

        $htmlMessage = "Theater <a href='$url'><u>{$theater}</u></a> has been updated successfully!";

        return redirect()->route('theater.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theater $theater): RedirectResponse
    {
        try {
            $url = route('theaters.index', ['theater' => $theater]);

            $theater->delete();

            if ($theater->imageExists) {
                Storage::delete("public/theaters/{$theater->photo_filename}");
            }

            $alertType = 'success';
            $alertMsg = "Theater {$theater} has been deleted successfully!";

        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the theater <a href='$url'><u>{$theater}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('theater.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
