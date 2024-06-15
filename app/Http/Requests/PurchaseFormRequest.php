<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseFormRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers',
            'date' => 'required|date|after_or_equal:today',
            'total_price' => 'required|decimal:0,2|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|string|lowercase|max:255',
            'nif' => 'nullable|digits:9',
            'payType' => 'string|uppercase|in:PAYPAL,MBWAY,VISA'
        ];

        match ($this->payType) {
            'PAYPAL' => $rules = array_merge($rules, [
                'payRef' => 'required|string|max:255'
            ]),
            'MBWAY' => $rules = array_merge($rules, [
                'payRef' => 'required|digits:9|regex:/^9/'
            ]),
            'VISA' => $rules = array_merge($rules, [
                'payRef' => 'required|digits:16'
            ])
        };

        return $rules;
    }
}
