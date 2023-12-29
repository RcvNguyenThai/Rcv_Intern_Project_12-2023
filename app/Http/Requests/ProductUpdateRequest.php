<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * A Request class for check validation when add new user
 * 27/12/2023
 * version:1
 */
class ProductUpdateRequest extends FormRequest
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
            'productName' => "min:5|max:255|required",
            "description" => "max:255|nullable",
            "price" => "gte:0|lte:1000000000",
            "fileUpload" => "file|image|mimes:png,jpg,jpeg|max:2048|dimensions:max_width=1024,max_height=1024",
        ];
    }

    public function messages(): array
    {
        return [
            'productName.max' => 'Tên sản phẩm không được quá 255 ký tự',
            'productName.min' => 'Tên sản phẩm phải lớn hơn 5 ký tự',
            'description.max' => 'Mô tả không được quá 255 ký tự',
            'price.gte' => 'Giá không được nhỏ hơn 0',
            'price.lte' => 'Giá không được lớn hơn 1 tỷ',
            'fileUpload.image' => 'File phải là ảnh',
            'fileUpload.mimes' => 'Ảnh phải là định dạng: png,jpg,jpeg',
            'fileUpload.max' => 'Ảnh không được quá 2 mb',
            'fileUpload.dimensions' => 'Ảnh chỉ được kích thước từ 1024 x 1024 trở xuống',
            'fileUpload.file' => 'Phải là định dạng file'
        ];
    }
}
