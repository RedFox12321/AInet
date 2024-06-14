<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SeatFormRequest;
use App\Models\Theater;
use App\Models\Seat;

class SeatController extends Controller
{
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $filterByTheater = $request->query('theater');
        $seatQuery = Seat::query();
        $allNull = true;

        if ($filterByTheater !== null) {
            $allNull = false;
            $seatQuery->with('theater')->whereHas('theater', function ($query) use ($filterByTheater) {
                $query->where('name', 'LIKE', '%' . $filterByTheater . '%');
            });
        }

        if ($allNull && $request->query()) {
            return redirect()->route('seats.index');
        }

        $seats = $seatQuery
            ->with('theater')
            ->orderBy('row')
            ->orderBy('seat_number')
            ->paginate(20)
            ->withQueryString();

        $theaters = Theater::all();

        return view(
            'main.seats.index',
            compact('seats', 'filterByTheater', 'theaters')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Seat $seat): View
    {
        return view('main.seats.show')->with('seat', $seat);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('main.seats.create')->with('seat', new Seat());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seat $seat): View
    {
        return view('main.seats.edit')->with('seat', $seat);
    }


    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(SeatFormRequest $request): RedirectResponse
    {
        $newSeat = Seat::create($request->validated());

        $url = route('seats.show', ['seat' => $newSeat]);

        $htmlMessage = "Seat <a href='$url'><u>{$newSeat}</u></a> has been created successfully!";

        return redirect()->route('seat.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeatFormRequest $request, Seat $seat): RedirectResponse
    {
        $seat->update($request->validated());

        $url = route('seats.show', ['seat' => $seat]);

        $htmlMessage = "Seat <a href='$url'><u>{$seat}</u></a> has been updated successfully!";

        return redirect()->route('seat.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seat $seat): RedirectResponse
    {
        try {
            $url = route('seats.index', ['seat' => $seat]);

            $seat->delete();

            $alertType = 'success';
            $alertMsg = "Seat {$seat} has been deleted successfully!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the seat <a href='$url'><u>{$seat}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('seat.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
