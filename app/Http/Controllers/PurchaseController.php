<?php

namespace App\Http\Controllers;

use App\Notifications\PurchasePaid;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\PurchaseFormRequest;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View | RedirectResponse
    {
        $filterByType = $request->query('payType');
        $filterByIdName = $request->search;
        $purchaseQuery = purchase::query();
        $allNull = true;

        if ($filterByType !== null && $filterByType != 'BOTH') {
            $allNull = false;
            $purchaseQuery->where('payment_type', $filterByType);
        }

        if ($filterByIdName !== null) {
            $allNull = false;
            $purchaseQuery->where('id', 'LIKE', '%' . $filterByIdName . '%')
                  ->orWhere('customer_name', 'LIKE', '%' . $filterByIdName . '%');
            };

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('purchases.index');
        }

        $purchases=$purchaseQuery
        ->orderBy('id', 'desc')
        ->paginate(20)
        ->withQueryString();


        return view(
            'main.purchases.index',
        compact('purchases','filterByIdName','filterByType')
    );
    }

    public function myPurchases(Request $request): View
    {
        if ($request->user()?->type == 'C') {
            $idPurchases = $request->user()?->customer?->purchases?->pluck('id')?->toArray();
            if (empty($idPurchases)) {
                return view('main.purchases.index')->with('disciplines', new Collection);
            }
        }

        $purchases = Purchase::whereIntegerInRaw('id', $idPurchases)
            ->orderBy('date', 'desc')
            ->get();

        return view(
            'main.purchases.index',
            compact('purchases')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase): View
    {
        $purchaseQuery = \App\Models\purchase::query();

        $purchaseQuery->where('purchase_id', $purchase->id);

        $purchases = $purchaseQuery
            ->get();

        return view(
            'main.purchases.show',
            compact('purchase', 'purchases')
        );
    }

    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseFormRequest $request): RedirectResponse
    {
        $newPurchase = Purchase::create($request->validated());

        $url = route('purchases.show', ['purchase' => $newPurchase]);

        $newPurchase->generatePDF();
        Auth::user()->notify(new PurchasePaid($newPurchase));

        $htmlMessage = "Purchase <a href='$url'><u>{$newPurchase}</u></a> has been created successfully!";

        return redirect()->route('purchase.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
