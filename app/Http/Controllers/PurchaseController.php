<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Purchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Purchase::class);
    }

    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $filterByType = $request->query('payType');
        $filterByIdName = $request->search;
        $purchaseQuery = Purchase::query();
        $allNull = true;
        $user = Auth::user();

        if ($user->type == 'C') {
            $purchaseQuery->with('customer')->whereHas('customer', function ($query) use ($user) {
                $query->where('id', $user->id);
            });
        }

        if ($filterByType != null) {
            $allNull = false;
            $purchaseQuery->where('payment_type', $filterByType);
        }

        if ($filterByIdName !== null) {
            $allNull = false;
            $purchaseQuery->where('id', 'LIKE', '%' . $filterByIdName . '%')
                ->orWhere('customer_name', 'LIKE', '%' . $filterByIdName . '%');
        }
        ;

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('purchases.index');
        }

        $purchases = $purchaseQuery
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();


        return view(
            'main.purchases.index',
            compact('purchases', 'filterByIdName', 'filterByType')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase): View
    {
        return view(
            'main.purchases.show',
            compact('purchase')
        );
    }
}
