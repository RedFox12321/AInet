<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserFormRequest;
use App\Models\User;

class UserController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }
    /* Views */

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('main.users.index')->with('users', User::all()->paginate(20));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('main.users.show')->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('main.users.create')->with('user', new User());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('main.users.edit')->with('user', $user);
    }


    /* CRUD operations */
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request): RedirectResponse
    {
        $newUser = User::create($request->validated());

        if ($request->hasFile('image_file')) {
            $request->image_file->storeAs('public/photos', $newUser->photo_filename);
        }

        $url = route('users.show', ['user' => $newUser]);

        $htmlMessage = "User <a href='$url'><u>{$newUser->name}</u></a> has been created successfully!";

        return redirect()->route('user.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        if ($request->hasFile('image_file')) {
            if ($user->imageExists) {
                Storage::delete("public/photos/{$user->photo_filename}");
            }

            $request->image_file->storeAs('public/photos', $user->photo_filename);
        }


        $url = route('users.show', ['user' => $user]);

        $htmlMessage = "User <a href='$url'><u>{$user->name}</u></a> has been updated successfully!";

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
            $url = route('users.index', ['user' => $user]);

            $user->delete();

            if ($user->imageExists) {
                Storage::delete("public/photos/{$user->fileName}");
            }

            $alertType = 'success';
            $alertMsg = "User {$user->name} has been deleted successfully!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the user <a href='$url'><u>{$user->name}</u></a> because there was an error with the operation!";
        }

        return redirect()->route('user.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
