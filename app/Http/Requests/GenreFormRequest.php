<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreFormRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255|unique:genres,name,' . ($this->genre ? $this->genre->code : null) . ',code'
        ];
        if (empty($this->genre)) {
            $rules = array_merge($rules, [
                'code' => 'required|string|max:20|unique:genres,code'
            ]);
        }
        return $rules;
    }
}
