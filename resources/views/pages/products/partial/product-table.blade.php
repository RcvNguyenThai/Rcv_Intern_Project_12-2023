@php

    $headers = ['id' => '#', 'product_name' => 'Tên sản phẩm', 'description' => 'Mô tả', 'price' => 'Giá (USD)', 'status_name' => 'Trạng thái', 'action' => 'Thao tác'];
@endphp

<x-table-ajax :headers="$headers" :inputs="$products" />

@if ($products->count() == 0)
    <span class="text-warning text-center">Không có sản phẩm nào hết</span>
@endif

@if (isset($deleteMessage))
    <span class="text-success text-center">Xóa sản phẩm thành công</span>
@endif
