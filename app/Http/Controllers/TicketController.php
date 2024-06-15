<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TicketFormRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /* Views */

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View | RedirectResponse
    {
        $filterByStatus = $request->query('status');
        $filterByIdName = $request->search;
        $ticketQuery = Ticket::query();
        $allNull = true;

        if ($filterByStatus !== null) {
            $allNull = false;
            $ticketQuery->where('status', $filterByStatus);
        }

        if ($filterByIdName !== null) {
            $allNull = false;
            $ticketQuery->where(function ($query) use ($filterByIdName) {
            $query->where('id', 'LIKE', '%' . $filterByIdName . '%')
                  ->orWhereHas('purchase', function ($purchaseQuery) use ($filterByIdName) {
                      $purchaseQuery->where('customer_name', 'LIKE', '%' . $filterByIdName . '%');
                  });
            });
      }

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('tickets.index');
        }

        $tickets=$ticketQuery
        ->with('purchase')
        ->orderBy('id', 'desc')
        ->paginate(20)
        ->withQueryString();

        return view(
            'main.tickets.index',
            compact('tickets','filterByStatus','filterByIdName')
        );
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

        $htmlMessage = "Ticket <a href='$url'><u>{$newTicket->id} ({$newTicket->screening->ticket->name})</u></a> has been created successfully!";

        return redirect()->route('tickets.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
