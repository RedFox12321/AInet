<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'password' => 'required|password|string',
            'type' => 'required|in:A,E,C',
            'photo_filename' => 'sometimes|image|max:4096',
            'nif' => 'nullable|digits:9',
            'payType' => 'nullable|string|uppercase|in:PAYPAL,MBWAY,VISA'
        ];

        if ($this?->payType) {
            match ($this->payType) {
                'PAYPAL' => $rules = array_merge($rules, [
                    'payRef' => 'required|string|max:255'
                ]),
                'MBWAY' => $rules = array_merge($rules, [
                    'payRef' => 'required|digits:9|regex:/^9/'
                ]),
                'VISA' => $rules = array_merge($rules, [
                    'payRef' => 'required|digits:16'
                ]),
            };
        }

        return $rules;
    }
}
