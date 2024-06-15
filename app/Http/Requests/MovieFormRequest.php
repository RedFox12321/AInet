<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieFormRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'genre_code' => 'required|exists:genre,code',
            'year' => 'required|date',
            'poster_filename' => 'sometimes|image|max:4096',
            'synopsis' => 'required|string|min:10|max:65535',
            'trailer_url' => 'sometimes|'
        ];
    }
}
