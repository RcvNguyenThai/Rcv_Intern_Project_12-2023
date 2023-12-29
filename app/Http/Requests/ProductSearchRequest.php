<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * A ProductSearchRequest class for check validation when search product
 * 27/12/2023
 * version:1
 */
class ProductSearchRequest extends FormRequest
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
            'productName' => "max:255|nullable",
            'fromPrice' => "gte:0|lte:1000000000|nullable",
            'toPrice' => "gte:0|lte:1000000000|nullable",
        ];
    }

    public function messages(): array
    {
        return [
            'productName.max' => 'Tên sản phẩm quá dài',
            'fromPrice.gte' => 'Giá không được nhỏ hơn 0',
            'fromPrice.lte' => 'Giá không được lớn hơn 1 tỷ',
            'toPrice.gte' => 'Giá không được nhỏ hơn 0',
            'toPrice.lte' => 'Giá không được lớn hơn 1 tỷ',
        ];
    }
}
