<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ScreeningFormRequest;
use App\Models\Screening;

class ScreeningController extends Controller
{
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('main.screenings.index')->with('screenings', Screening::orderBy('date', 'desc')->orderBy('start_time')->paginate(20));
    }

    /**
     * Display the specified resource.
     */
    public function show(Screening $screening): View
    {
        return view('main.screenings.show')->with('screening', $screening);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('main.screenings.create')->with('screening', new Screening());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Screening $screening): View
    {
        return view('main.screenings.edit')->with('screening', $screening);
    }


    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(ScreeningFormRequest $request): RedirectResponse
    {
        $newScreening = Screening::create($request->validated());

        $url = route('screenings.show', ['screening' => $newScreening]);

        $htmlMessage = "Screening <a href='$url'><u>{$newScreening}</u></a> has been created successfully!";

        return redirect()->route('screening.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScreeningFormRequest $request, Screening $screening): RedirectResponse
    {
        $screening->update($request->validated());

        $url = route('screenings.show', ['screening' => $screening]);

        $htmlMessage = "Screening <a href='$url'><u>{$screening}</u></a> has been updated successfully!";

        return redirect()->route('screening.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $screening): RedirectResponse
    {
        try {
            $url = route('screenings.index', ['screening' => $screening]);

            $hasTickets = DB::scalar(
                'SELECT count(*) FROM TICKETS WHERE SCREENING_ID = ?',
                [$screening->id]
            );

            if ($hasTickets == 0) {
                $screening->delete();

                $alertType = 'success';
                $alertMsg = "Screening {$screening} has been deleted successfully!";
            } else {
                $ticketJustif = match ($hasTickets) {
                    1 => "is 1 ticket",
                    default => "are {$hasTickets} tickets",
                };

                $justification = "there {$ticketJustif} for this .";

                $alertType = 'warning';
                $alertMsg = "Screening <a href='$url'><u>{$screening}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the screening <a href='$url'><u>{$screening}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('screening.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
