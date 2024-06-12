<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeatFormRequest extends FormRequest
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
            'theater_id' => 'required|exists:theaters',
            'row' => 'required|string|max:1',
            'seat_number' => 'required|integer|min:1'
        ];
    }
}
