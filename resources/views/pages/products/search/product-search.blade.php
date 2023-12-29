@php
    $listInput = [
        [
            'name' => 'productName',
            'label' => 'Tên sản phẩm',
            'type' => 'text',
            'placeholder' => 'Nhập tên sản phẩm tìm kiếm',
            'value' => $strProductName ?? '',
        ],
        [
            'name' => 'fromPrice',
            'label' => 'Giá bán từ',
            'type' => 'text',
            'placeholder' => 'Nhập giá bán từ',
            'value' => $fFromPrice ?? '',
        ],
        [
            'name' => 'toPrice',
            'label' => 'Giá bán đến',
            'type' => 'text',
            'placeholder' => 'Nhập giá bán đến',
            'value' => $fToPrice ?? '',
        ],
    ];

    $listSelect = [
        [
            'title' => 'Trạng thái',
            'options' => [
                '--- Trạng thái ---' => -1,
                'Đang bán' => 0,
                'Dừng bán' => 1,
                'Hết hàng' => 2,
            ],
            'name' => 'status',
        ],
    ];

@endphp

@extends('layouts.custom.search-layout')
<div class="container-fluid px-4 ">

    @section('title')
        Sản phẩm
    @endsection

    @section('search-content')
        <form method="get" action="{{ route('admin.product.get') }}" id="form-user-search">
            <div class="row row-cols-1 mx-0 row-cols-md-3 gap-4">
                @foreach ($listInput as $input)
                    <div class="col-md-6 col-12 col-xs-12 col-lg-3">

                        <x-forms.input :placeholder="$input['placeholder']" :name="$input['name']" :value="$input['value']" :label="$input['label']"
                            :type="$input['type']" :error="$errors->first($input['name'])" />
                    </div>
                @endforeach
                @foreach ($listSelect as $select)
                    <div class="col-md-6 col-12 col-xs-12 col-lg-3">

                        <x-forms.select-box :name="$select['name']" :options="$select['options']" :title="$select['title']" isForm />
                    </div>
                @endforeach
                <input type="hidden" name="perPage" value="{{ $iPerPage ?? 5 }}">

            </div>

            <div>
                <div class="row  gap-2 mx-0 mt-2">
                    <div class=" row g-2 col-md-6 mx-0  col-12">
                        <a href="{{ route('admin.product.create') }}">
                            <x-forms.button orms.button type="button" icon="fas fa-plus ">
                                Thêm mới
                            </x-forms.button>
                        </a>
                    </div>
                    <div class="row gx-2 mx-0 mt-4 mt-md-0  col-md-6 col-12 justify-content-md-end" style="gap: 0.5rem">
                        <x-forms.button type="submit" icon="fas fa-search ">
                            Tìm Kiếm
                        </x-forms.button>
                        <x-forms.button id="upsert-reset" type="button" class="btn-success" icon="fas fa-sync-alt">
                            Xóa tìm
                        </x-forms.button>

                    </div>
                </div>
            </div>
        </form>
    @endsection
</div>

@section('js')
    <script>
        $(document).ready(function() {
            $('#upsert-reset').on('click', function() {
                // Loop through the list of input elements
                @foreach ($listInput as $input)
                    // Set the value of each input element to an empty string by id
                    $('#{{ $input['name'] }}').val('');
                @endforeach

                // Loop through the list of select elements
                @foreach ($listSelect as $select)
                    // Set the value of each select element to an empty string by id
                    $('#{{ $select['name'] }}').val('');
                @endforeach
            });
        });
    </script>
@endsection
