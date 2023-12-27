<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * A UpdateUserRequest class for check validation when update user
 * 27/12/2023
 * version:1
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the admin user is authorized to make this request.
     *
     * @throws Some_Exception_Class description of exception
     * @return bool
     * 27/12/2023
     * version:1
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * 27/12/2023
     * version:1
     */
    public function rules(): array
    {
        return [
            "name" => "min:2|max:255",
            "email" => "min:2|max:255|email",
        ];
    }
}
