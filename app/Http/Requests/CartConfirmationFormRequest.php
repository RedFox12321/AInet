<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CartConfirmationFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|lowercase|max:255',
            'nif' => 'nullable|digits:9',
            'payType' => 'required|string|uppercase|in:PAYPAL,MBWAY,VISA',
        ];

        match ($this->payType) {
            'PAYPAL' => $rules = array_merge($rules, [
                'payRef' => 'required|string|max:255'
            ]),
            'MBWAY' => $rules = array_merge($rules, [
                'payRef' => 'required|digits:9|regex:/^9/'
            ]),
            'VISA' => $rules = array_merge($rules, [
                'payRef' => 'required|digits:19'
            ])
        };

        return $rules;
    }
}
