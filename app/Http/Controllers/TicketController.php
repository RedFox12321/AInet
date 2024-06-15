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
        return view('main.tickets.index')->with('tickets', Ticket::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): View
    {
        return view('main.tickets.show')->with('ticket', $ticket);
    }

    public function myTickets(Ticket $ticket): View
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

        $url = route('tickets.show', ['ticket' => $newTicket]);

        $htmlMessage = "Ticket <a href='$url'><u>{$newTicket->id} ({$newTicket->screening->movie->name})</u></a> has been created successfully!";

        return redirect()->route('tickets.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
