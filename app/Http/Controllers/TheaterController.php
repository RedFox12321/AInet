<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TheaterFormRequest;
use App\Models\Theater;

//use App\Models\Seats;

class TheaterController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Theater::class);
    }
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
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

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('theaters.index');
        }

        $theaters = $theaterQuery
            ->paginate(20)
            ->withQueryString();

        return view(
            'main.theaters.index',
            compact('theaters', 'filterByName')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Theater $theater): View
    {
        $seatQuery = \App\Models\Seat::query();
        $seatQuery->withTrashed('theater')->whereHas('theater', function ($query) use ($theater) {
            $query->where('id', $theater->id);
        });

        $seats = $seatQuery
            ->with(['theater'])
            ->get();

        $rows = $seats->unique('row')->pluck('row')->sort();
        $numbers = $seats->unique('seat_number')->pluck('seat_number')->sort();

        $seatsByNumbers = $seats->groupBy('row')->map(function ($group) {
            return $group->sortBy('seat_number');
        });



        return view(
            'main.theaters.show',
            compact('theater', 'seatsByNumbers', 'rows', 'numbers')
        );
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
            $newTheater->photo_filename = $newTheater->id . "_theater_image.jpg";
            $newTheater->update();

            $request->image_file->storeAs('public/theater', $newTheater->photo_filename);
        }

        $url = route('theaters.show', ['theater' => $newTheater]);

        $htmlMessage = "Theater <a href='$url'><u>#{$newTheater->id}</u></a> has been created successfully!";

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
                Storage::delete("public/theater/{$theater->photo_filename}");
            }

            if (empty($theater->photo_filename)) {
                $theater->photo_filename = $theater->id . "_theater_image";
                $theater->update();
            }

            $request->image_file->storeAs('public/theater/', $theater->photo_filename);
        }

        $url = route('theaters.show', ['theater' => $theater]);

        $htmlMessage = "Theater <a href='$url'><u>#{$theater->id}</u></a> has been updated successfully!";

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
            $alertMsg = "Theater #{$theater->id} has been deleted successfully!";

        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the theater <a href='$url'><u>#{$theater->id}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('theater.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyImage(Theater $theater): RedirectResponse
    {
        if ($theater->photo_filename) {
            if (Storage::fileExists('public/photos/' . $theater->photo_filename)) {
                Storage::delete('public/photos/' . $theater->photo_filename);
            }
            $theater->photo_filename = null;
            $theater->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of user {$theater->name} has been deleted.");
        }
        return redirect()->back();
    }

}
