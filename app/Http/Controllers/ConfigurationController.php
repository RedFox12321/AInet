<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\ConfigurationFormRequest;

class ConfigurationController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(): View
    {
        return view('main.configurations.edit')->with('configuration', Configuration::find('1'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConfigurationFormRequest $request, Configuration $configuration): RedirectResponse
    {
        // Update
        $configuration->update($request->validated());

        // Message
        $htmlMessage = "The configurations have been updated successfully!";

        //Redirect
        return redirect()->route('configurations.edit')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
