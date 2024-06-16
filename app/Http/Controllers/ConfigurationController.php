<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\ConfigurationFormRequest;

class ConfigurationController extends Controller
{
    public function edit(): View
    {
        return view('main.configurations.edit')->with('configuration', Configuration::find(1));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConfigurationFormRequest $request): RedirectResponse
    {
        // Update
        Configuration::find(1)->update($request->validated());
        // Message
        $htmlMessage = "The configurations have been updated successfully!";

        //Redirect
        return redirect()->route('configurations.edit')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
