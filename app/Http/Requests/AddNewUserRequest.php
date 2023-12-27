<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * A Request class for check validation when add new user
 * 27/12/2023
 * version:1
 */
class AddNewUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * return bool
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
            'addEmail' => "email|required",
            "password" => "required|min:6|confirmed",
            "addName" => "min:2|max:255|required",
        ];
    }
}
