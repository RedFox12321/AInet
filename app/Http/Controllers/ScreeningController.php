<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ScreeningFormRequest;
use App\Models\Screening;
use App\Models\Genre;


class ScreeningController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Screening::class);
    }
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $filterByTitleSynopsis = $request->search;
        $filterByGenre = $request->query('genre');
        $filterByDate = $request->query('date');
        $filterByTheater = $request->query('theater');
        $screeningQuery = Screening::query();
        $user = Auth::user();

        $allNull = true;

        if ($user === null || $user->type == 'C') {
            $screeningQuery->whereBetween('date', [today(), today()->addWeeks(2)]);
        }

        if ($filterByTitleSynopsis !== null) {
            $allNull = false;
            $screeningQuery->with('movie')->whereHas('movie', function ($userQuery) use ($filterByTitleSynopsis) {
                $userQuery->where('title', 'LIKE', '%' . $filterByTitleSynopsis . '%')
                    ->orWhere('synopsis', 'LIKE', '%' . $filterByTitleSynopsis . '%');
            });
        }

        if ($filterByGenre !== null) {
            $allNull = false;
            $screeningQuery->with('movie.genre')->whereHas('movie.genre', function ($query) use ($filterByGenre) {
                $query->where('code', $filterByGenre);
            });
        }

        if ($filterByDate !== null) {
            $allNull = false;
            match ((int) $filterByDate) {
                1 => $screeningQuery->whereBetween('date', [today(), today()->addHours(23.59)]),
                2 => $screeningQuery->whereBetween('date', [today()->addDay(), today()->addDay()->addHours(23.59)]),
                3 => $screeningQuery->whereBetween('date', [today(), today()->addDays(6)])
            };
        }
        if ($filterByTheater !== null) {
            $allNull = false;
            $screeningQuery->with('theater')->whereHas('theater', function ($query) use ($filterByTheater) {
                $query->where('name', 'LIKE', '%' . $filterByTheater . '%');
            });
        }

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('screenings.index');
        }

        $screenings = $screeningQuery
            ->with(['movie.genre', 'theater'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->paginate(20)
            ->withQueryString();


        if ($user?->type == 'A') {
            $genres = Genre::withTrashed();
            $theaters = Theater::withTrashed();
        } else {
            $genres = Genre::all();
            $theaters = Theater::all();
        }

        return view(
            'main.screenings.index',
            compact('screenings', 'filterByTitleSynopsis', 'filterByGenre', 'filterByDate', 'filterByTheater', 'genres', 'theaters')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Screening $screening): View
    {
        $seatQuery = \App\Models\Seat::query();
        $seatQuery->withTrashed('theater')->whereHas('theater', function ($query) use ($screening) {
            $query->where('id', $screening->theater_id);
        });

        $seats = $seatQuery
            ->with(['theater'])
            ->get();

        $seatQuery->with('tickets')->whereHas('tickets', function ($query) use ($screening) {
            $query->where('screening_id', $screening->id);
        });

        $seatsTaken = $seatQuery
            ->with(['theater', 'tickets'])
            ->get()
            ->pluck('id');

        $rows = $seats->unique('row')->pluck('row')->sort();
        $numbers = $seats->unique('seat_number')->pluck('seat_number')->sort();

        $seatsByNumbers = $seats->groupBy('row')->map(function ($group) {
            return $group->sortBy('seat_number');
        });



        return view(
            'main.screenings.show',
            compact('screening', 'seatsByNumbers', 'rows', 'numbers', 'seatsTaken')
        );
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

        $htmlMessage = "Screening <a href='$url'><u>#{$newScreening->id}</u></a> has been created successfully!";

        return redirect()->route('screenings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScreeningFormRequest $request, Screening $screening): RedirectResponse
    {
        $url = route('screenings.show', ['screening' => $screening]);

        $hasTickets = DB::scalar(
            'SELECT count(*) FROM tickets WHERE SCREENING_ID = ?',
            [$screening->id]
        );

        if ($hasTickets == 0) {
            $screening->update($request->validated());

            $alertType = 'success';
            $alertMsg = "Screening {$screening} has been updated successfully!";
        } else {
            $ticketJustif = match ($hasTickets) {
                1 => "is 1 ticket",
                default => "are {$hasTickets} tickets",
            };

            $justification = "there {$ticketJustif} for this screening.";

            $alertType = 'warning';
            $alertMsg = "Screening <a href='$url'><u>#{$screening->id}</u></a> cannot be updated because $justification.";
        }

        return redirect()->route('screenings.edit', ['screening' => $screening])
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $screening): RedirectResponse
    {
        try {
            $url = route('screenings.index', ['screening' => $screening]);

            $hasTickets = DB::scalar(
                'SELECT count(*) FROM tickets WHERE SCREENING_ID = ?',
                [$screening->id]
            );

            if ($hasTickets == 0) {
                $screening->delete();

                $alertType = 'success';
                $alertMsg = "Screening #{$screening->id} has been deleted successfully!";
            } else {
                $ticketJustif = match ($hasTickets) {
                    1 => "is 1 ticket",
                    default => "are {$hasTickets} tickets",
                };

                $justification = "there {$ticketJustif} for this screening.";

                $alertType = 'warning';
                $alertMsg = "Screening <a href='$url'><u>#{$screening->id}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the screening <a href='$url'><u>#{$screening->id}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('screenings.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
