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

        $url = route('purchases.show', ['purchase' => $newPurchase]);

        $htmlMessage = "Purchase <a href='$url'><u>{$newPurchase}</u></a> has been created successfully!";

        return redirect()->route('purchase.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
