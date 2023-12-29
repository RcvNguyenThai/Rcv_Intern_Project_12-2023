@extends('layouts.master')

@php
    $isUpdate = isset($product);

    if (!function_exists('getActionRoute')) {
        function getActionRoute($isUpdate)
        {
            return $isUpdate ? 'admin.product.update' : 'admin.product.store';
        }
    }

@endphp

@section('content')
    <div class="container-fluid pt-2 px-4">
        <h2 class="text-left font-weight-bold">
            {{ $isUpdate ? 'Sửa' : 'Tạo' }} sản phẩm
        </h2>
        <form action="{{ route(getActionRoute($isUpdate), $isUpdate ? ['id' => $product->id] : null) }}" method="post"
            enctype="multipart/form-data">
            @method($isUpdate ? 'PUT' : 'POST')
            @csrf
            <div class="row ">
                <div class="col-xl-6 col-12">
                    @include('pages.products.upsert.product-upsert-left')
                </div>
                <div class="col-xl-6 col-12">
                    @include('pages.products.upsert.product-upsert-right')

                </div>
            </div>

            <div class="d-flex justify-content-end mt-3" style="gap: 0.5rem">
                <x-forms.button type="reset" icon="fas fa-undo" class="btn-secondary">
                    Hủy
                </x-forms.button>
                <x-forms.button type="submit" icon="fas fa-save">
                    {{ $isUpdate ? 'Cập nhật' : 'Tạo' }}
                </x-forms.button>

            </div>

        </form>

    </div>
@endsection
