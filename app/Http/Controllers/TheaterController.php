<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TheaterFormRequest;
use App\Models\Theater;

class TheaterController extends Controller
{
    //TODO
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('main.theaters.index')->with('theaters', Theater::all()->paginate(20));
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
            $request->image_file->storeAs('public/photos', $newTheater->photo_filename);
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
                Storage::delete("public/photos/{$theater->photo_filename}");
            }

            $request->image_file->storeAs('public/photos', $theater->photo_filename);
        }

        $url = route('theater.show', ['theater' => $theater]);

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
            $url = route('theater.index', ['theater' => $theater]);

            $hasCustomer = DB::scalar(
                'SELECT COUNT(*) FROM COLLUMN WHERE ID = ?',
                [$theater->id]
            );

            if ($hasCustomer) {
                $theater->delete();

                if ($theater->imageExists) {
                    Storage::delete("public/photos/{$theater->photo_filename}");
                }

                $alertType = 'success';
                $alertMsg = "Theater {$theater} has been deleted successfully!";
            } else {
                $justification = "";

                $alertType = 'warning';
                $alertMsg = "Theater <a href='$url'><u>{$theater}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the theater <a href='$url'><u>{$theater}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('theater.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
