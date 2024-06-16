<?php

namespace App\Http\Controllers;

use App\Notifications\PurchasePaid;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;

class TicketController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Ticket::class);
    }
    /* Views */

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
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

        $tickets = $ticketQuery
            ->with('purchase')
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view(
            'main.tickets.index',
            compact('tickets', 'filterByStatus', 'filterByIdName')
        );
    }
    public function myTickets(Request $request): View|RedirectResponse
    {
        $filterByStatus = $request->query('status');
        $filterById = $request->search;
        $ticketQuery = Ticket::query();
        $allNull = true;

        if ($request->user()?->type == 'C') {
            $idTickects = $request->user()?->customer?->purchases?->tickets?->pluck('id')?->toArray();
            if (empty($idTickects)) {
                $tickets = new Collection;
                return view(
                    'main.tickets.my',
                    compact('tickets', 'filterByStatus', 'filterById')
                );
            }
        }

        $ticketQuery->whereIntegerInRaw('id', $idTickects);

        if ($filterByStatus !== null) {
            $allNull = false;
            $ticketQuery->where('status', $filterByStatus);
        }

        if ($filterById !== null) {
            $allNull = false;
            $ticketQuery->where('id', 'LIKE', '%' . $filterById . '%');
        }

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('tickets.my');
        }

        $tickets = $ticketQuery
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view(
            'main.tickets.my',
            compact('tickets', 'filterByStatus', 'filterById')
        );
    }
    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): View
    {
        return view('main.tickets.show')->with('ticket', $ticket);
    }

    public function update(Ticket $ticket, Request $request): RedirectResponse
    {
        $ticket->update($request->validated());

        $url = route('tickets.index', ['theater' => $ticket]);

        $htmlMessage = "Ticket <a href='$url'><u>#{$ticket->id}</u></a> has been updated successfully!";

        return redirect()->route('tickets.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public static function generatePDF(Collection $tickets)
    {
        $base64Image = [];
        foreach ($tickets as $ticket) {
            $imageContent = Storage::get("ticket_qrcodes/$ticket->qrcode_url");
            $base64Image["$ticket->id"] = 'data:image/png;base64,' . base64_encode($imageContent);
        }

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('main.tickets.pdf', compact('tickets', 'base64Image'));
        return $pdf->output();
    }
}
