<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

/**
 * A ChangePasswordRequest class for check validation when change user password
 * 27/12/2023
 * version:1
 */
class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the admin user is authorized to make this request.
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
            'oldPassword' => [
                'required',
                'min:6',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('The old password is incorrect.');
                    }
                },
            ],
            'newPassword' => 'required|min:6|max:255|confirmed',
        ];
    }
}
