<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AdminFormRequest;
use App\Models\User;

class AdminController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }
    /* Views */

    /**
     * Display a listing of the resource.  ->with('admins', User::all()->paginate(20))
     */
    public function index(): View
    {
        $userQuery = User::query();

        $userQuery->where('type','A');

        $admins = $userQuery
            ->orderBy('id')
            ->paginate(20)
            ->withQueryString();

        return view(
            'main.admins.index',
            compact('admins')
    );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('main.admins.show')->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('main.admins.create')->with('user', new User());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('main.admins.edit')->with('user', $user);
    }


    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminFormRequest $request): RedirectResponse
    {
        $newUser = User::create($request->validated());

        if ($request->hasFile('image_file')) {
            $request->image_file->storeAs('public/photos', $newUser->photo_filename);
        }

        $url = route('admins.show', ['user' => $newUser]);

        $htmlMessage = "Admin <a href='$url'><u>{$newUser->name}</u></a> has been created successfully!";

        return redirect()->route('user.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminFormRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        if ($request->hasFile('image_file')) {
            if ($user->imageExists) {
                Storage::delete("public/photos/{$user->photo_filename}");
            }

            $request->image_file->storeAs('public/photos', $user->photo_filename);
        }


        $url = route('admins.show', ['user' => $user]);

        $htmlMessage = "Admin <a href='$url'><u>{$user->name}</u></a> has been updated successfully!";

        return redirect()->route('user.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $url = route('admins.index', ['user' => $user]);

            $user->delete();

            if ($user->imageExists) {
                Storage::delete("public/photos/{$user->photo_filename}");
            }

            $alertType = 'success';
            $alertMsg = "Admin {$user->name} has been deleted successfully!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the admin <a href='$url'><u>{$user->name}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('admins.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
