<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketFormRequest;
use App\Notifications\PurchasePaid;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use App\Models\Theater;

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
        $filterByTheater = $request->query('theater');

        $ticketQuery = Ticket::query();
        $allNull = true;
        $user = Auth::user();

        if ($user->type == 'C') {
            $ticketQuery->with('purchase.customer')->whereHas('purchase.customer', function ($query) use ($user) {
                $query->where('id', $user->id);
            });
        }

        if ($filterByStatus != null) {
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
        if ($filterByTheater !== null) {
            $allNull = false;
            $ticketQuery->with('screening.theater')->whereHas('screening.theater', function ($userQuery) use ($filterByTheater) {
                $userQuery->where('name', 'LIKE', '%' . $filterByTheater . '%');
            });
        }

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('tickets.index');
        }

        $tickets = $ticketQuery
            ->with(['purchase','screening.theater'])
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();

        $theaters = Theater::all();


        return view(
            'main.tickets.index',
            compact('tickets', 'filterByStatus', 'filterByIdName', 'filterByTheater', 'theaters')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): View
    {
        return view('main.tickets.show')->with('ticket', $ticket);
    }

    public function update(Ticket $ticket, TicketFormRequest $request): RedirectResponse
    {
        $ticket->update($request->validated());

        $url = route('tickets.show', ['ticket' => $ticket]);

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
