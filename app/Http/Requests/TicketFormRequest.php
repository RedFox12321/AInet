<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketFormRequest extends FormRequest
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
            'screening_id' => 'required|exists:screenings',
            'seat_id' => 'required|exists:seats',
            'purchase_id' => 'required|exists:purchases',
            'price' => 'required|decimal:0,2|min:0',
            'qrcode_url' => 'required|string|lowercase|max:255',
            'status' => 'required|string|in:valid,invalid'
        ];
    }
}
