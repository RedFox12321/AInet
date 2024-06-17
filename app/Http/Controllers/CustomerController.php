<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CustomerFormRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }
    /* Views */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $filterByIdName = $request->search;
        $customerQuery = Customer::query();
        $allNull = true;

        if ($filterByIdName !== null) {
            $allNull = false;
            $customerQuery->with('user')->whereHas('user', function ($userQuery) use ($filterByIdName) {
                $userQuery->where('id', 'LIKE', '%' . $filterByIdName . '%')
                    ->orWhere('name', 'LIKE', '%' . $filterByIdName . '%');
            });
        }

        if ($allNull && $request->query() && !$request?->page) {
            return redirect()->route('customers.index');
        }

        $customers = $customerQuery
            ->orderBy('id')
            ->paginate(20)
            ->withQueryString();

        return view(
            'main.customers.index',
            compact('customers', 'filterByIdName')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): View
    {
        return view('main.customers.show')->with('customer', $customer);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        return view('main.customers.edit')->with('customer', $customer);
    }


    /* CRUD operations */
    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerFormRequest $request, Customer $customer): RedirectResponse
    {

        $customer->user->update($request->validated());

        $url = route('customers.show', ['customer' => $customer]);

        $htmlMessage = "Customer <a href='$url'><u>#{$customer->id}</u></a> has been updated successfully!";

        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
