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
        return [
            'customer_id' => 'exists:customers',
            'payment_type' => 'required|',
            'payment_ref' => 'required|'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->user()) {
                    if ($this->user()->type == 'C') {
                        $userCustomerId = $this->user()?->student?->number;
                        if ($this->student_number != $userCustomerId) {
                            $validator->errors()->add('student_number', "Your customer number is $userCustomerId");
                        }
                    }
                }
            }
        ];
    }
}
