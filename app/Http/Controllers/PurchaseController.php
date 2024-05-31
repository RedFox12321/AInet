<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PurchaseFormRequest;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('main.purchases.index')->with('purchases', Purchase::orderBy('date', 'desc')->paginate(20));
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase): View
    {
        return view('main.purchases.show')->with('purchase', $purchase);
    }

    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseFormRequest $request): RedirectResponse
    {
        $newPurchase = Purchase::create($request->validated());

        $url = route('purchase.show', ['purchase' => $newPurchase]);

        $htmlMessage = "Purchase <a href='$url'><u>{$newPurchase}</u></a> has been created successfully!";

        return redirect()->route('purchase.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase): RedirectResponse
    {
        try {
            $url = route('purchase.index', ['purchase' => $purchase]);

            $hasTickets = DB::scalar(
                'SELECT count(*) FROM TICKETS WHERE PURCHASE_ID = ?',
                [$purchase->id]
            );

            if ($hasTickets == 0) {
                $purchase->delete();

                $alertType = 'success';
                $alertMsg = "Purchase {$purchase} has been deleted successfully!";
            } else {
                $ticketJustif = match ($hasTickets) {
                    1 => "is 1 ticket",
                    default => "are {$hasTickets} tickets",
                };

                $justification = "there {$ticketJustif} linked to this purchase.";

                $alertType = 'warning';
                $alertMsg = "Purchase <a href='$url'><u>{$purchase}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the purchase <a href='$url'><u>{$purchase}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('purchase.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
