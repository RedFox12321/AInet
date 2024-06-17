<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends \Illuminate\Routing\Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function editPassword(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        DB::transaction(function () use ($validatedData, $request) {
            $user = $request->user();
            if ($user?->customer) {
                if (!empty($validatedData['nif'])) {
                    $user->customer->nif = $validatedData['nif'];
                }

                if (!empty($validatedData['payType'])) {
                    $user->customer->payment_type = $validatedData['payType'];
                }

                if (!empty($validatedData['payRef'])) {
                    $user->customer->payment_ref = $validatedData['payRef'];
                }
                $user->customer->save();
            }

            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->save();

            if ($request->hasFile('image_file')) {
                // if ($customer->user->photo_filename && Storage::fileExists("public/photos/{$customer->user->photo_filename}")) {
                //     Storage::delete("public/photos/{$customer->user->photo_filename}");
                // }
                if ($user->imageExists) {
                    Storage::delete("public/photos/{$user->photo_filename}");
                }

                $path = $request->image_file->store('public/photos');
                $user->photo_filename = basename($path);
                $user->save();
            }
        });

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
