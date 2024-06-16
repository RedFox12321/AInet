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
    public function index(Request $request): View | RedirectResponse
    {
        $filterByStatus;
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
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $newCustomer = new Customer();
        $newUser = new User();
        $newUser->type = 'C';
        $newCustomer->user = $newUser;

        return view('main.customers.create')->with('customer', $newCustomer);
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
     * Store a newly created resource in storage.
     */
    public function store(CustomerFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newCustomer = DB::transaction(function () use ($validatedData, $request) {
            $newUser = new User();
            $newUser->type = 'C';
            $newUser->name = $validatedData['name'];
            $newUser->email = $validatedData['email'];
            $newUser->admin = $validatedData['admin'];
            $newUser->blocked = 0;
            $newUser->password = bcrypt($validatedData['password']);
            $newUser->save();

            $newCustomer = new Customer();
            $newCustomer->id = $newUser->id;
            if ($validatedData['nif'] != null) {
                $newCustomer->nif = $validatedData['nif'];
            }

            if ($validatedData['payment_type'] != null) {
                $newCustomer->payment_type = $validatedData['payment_type'];
            }

            if ($validatedData['payment_ref'] != null) {
                $newCustomer->payment_ref = $validatedData['payment_ref'];
            }
            $newCustomer->save();

            if ($request->hasFile('image_file')) {
                $path = $request->image_file->store('public/photos');
                $newUser->photo_filename = basename($path);
                $newUser->save();
            }

            return $newCustomer;
        });


        $url = route('customers.show', ['customer' => $newCustomer]);

        $htmlMessage = "Customer <a href='$url'><u>{$newCustomer}</u></a> has been created successfully!";

        return redirect()->route('customer.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerFormRequest $request, Customer $customer): RedirectResponse
    {
        
        $customer->user->update($request->validated());

        // $customer = DB::transaction(function () use ($validatedData, $customer, $request) {
        //     if (!empty($validatedData['nif']) ) {
        //         $customer->nif = $validatedData['nif'];
        //     }

        //     if (!empty($validatedData['payment_type']) ) {
        //         $customer->payment_type = $validatedData['payment_type'];
        //     }

        //     if (!empty($validatedData['payment_ref'] )) {
        //         $customer->payment_ref = $validatedData['payment_ref'];
        //     }
        //     $customer->save();

        //     $customer->user->type = 'C';
        //     $customer->user->name = $validatedData['name'];
        //     $customer->user->email = $validatedData['email'];
        //     $customer->user->admin = $validatedData['admin'];
        //     $customer->user->blocked = $validatedData['blocked'];
        //     $customer->user->password = bcrypt($validatedData['password']);
        //     $customer->user->save();

        //     if ($request->hasFile('image_file')) {
        //         // if ($customer->user->photo_filename && Storage::fileExists("public/photos/{$customer->user->photo_filename}")) {
        //         //     Storage::delete("public/photos/{$customer->user->photo_filename}");
        //         // }
        //         if ($customer->user->imageExists) {
        //             Storage::delete("public/photos/{$customer->user->photo_filename}");
        //         }

        //         $path = $request->image_file->store('public/photos');
        //         $customer->user->photo_filename = basename($path);
        //         $customer->user->save();
        //     }

        //     return $customer;
        // });


        $url = route('customers.show', ['customer' => $customer]);

        $htmlMessage = "Customer <a href='$url'><u>#{$customer->id}</u></a> has been updated successfully!";

        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        try {
            $url = route('customers.index', ['customer' => $customer]);

            DB::transaction(function () use ($customer) {
                $fileToDelete = $customer->user->photo_filename;
                $customer->delete();
                $customer->user->delete();
                if ($fileToDelete) {
                    if (Storage::fileExists("public/photos/{$fileToDelete}")) {
                        Storage::delete("public/photos/{$fileToDelete}");
                    }
                }
            });

            $alertType = 'success';
            $alertMsg = "Customer #{$customer->id} has been deleted successfully!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the customer <a href='$url'><u>#{$customer->id}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('customer.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
