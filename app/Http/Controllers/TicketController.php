<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TicketFormRequest;
use App\Models\Ticket;

class TicketController extends Controller
{
    /* Views */

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('main.tickets.index')->with('tickets', Ticket::all()->paginate(20));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): View
    {
        return view('main.tickets.show')->with('ticket', $ticket);
    }

    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketFormRequest $request): RedirectResponse
    {
        $newTicket = Ticket::create($request->validated());

        $url = route('ticket.show', ['ticket' => $newTicket]);

        $htmlMessage = "Ticket <a href='$url'><u>{$newTicket->id} ({$newTicket->screening->movie->name})</u></a> has been created successfully!";

        return redirect()->route('tickets.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        try {
            $url = route('tickets.index', ['ticket' => $ticket]);

            $ticket->delete();

            $alertType = 'success';
            $alertMsg = "Ticket {$ticket->id} ({$ticket->screening->movie->name}) has been deleted successfully!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the ticket <a href='$url'><u>{$ticket->id} ({$ticket->screening->movie->name})</u></a> because there was an error with the operation!";
        }

        return redirect()->route('tickets.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
