<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SeatFormRequest;
use App\Models\Seat;

class SeatController extends Controller
{
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('main.seats.index')->with('seats', Seat::orderBy('seat_number')->orderBy('row')->paginate(20));
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

        $url = route('seat.show', ['seat' => $newSeat]);

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

        $url = route('seat.show', ['seat' => $seat]);

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
            $url = route('seat.index', ['seat' => $seat]);

            $hasTickets = DB::scalar(
                'SELECT COUNT(*) FROM TICKETS WHERE SEAT_ID = ?',
                [$seat->id]
            );

            if ($hasTickets == 0) {
                $seat->delete();

                $alertType = 'success';
                $alertMsg = "Seat {$seat} has been deleted successfully!";
            } else {
                $ticketJustif = match ($hasTickets) {
                    1 => "is 1 ticket",
                    default => "are {$hasTickets} tickets",
                };

                $justification = "there {$ticketJustif} purchased for it.";

                $alertType = 'warning';
                $alertMsg = "Seat <a href='$url'><u>{$seat}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the seat <a href='$url'><u>{$seat}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('seat.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
