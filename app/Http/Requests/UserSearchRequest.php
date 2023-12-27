<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * A UserSearchRequest class for check validation when search user
 * 27/12/2023
 * version:1
 */
class UserSearchRequest extends FormRequest
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
            'email' => "max:255",
            'name' => "max:255",
        ];
    }

    public function messages(): array
    {
        return [
            'email.max' => 'Email quá dài',
            'name.max' => 'Tên quá dài',
        ];
    }
}
