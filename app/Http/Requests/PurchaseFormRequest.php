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
        // TODO
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers',
            'date' => 'required|date|after_or_equal:today',
            'total_price' => 'required|decimal:0,2|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|string|lowercase|max:255',
            'nif' => 'nullable|integer|regex:\d{9}',
            'payment_type' => 'nullable|string|uppercase|in:VISA,PAYPAL,MBWAY',
            'payment_ref' => 'nullable|string|max:255'
        ];
    }
}
