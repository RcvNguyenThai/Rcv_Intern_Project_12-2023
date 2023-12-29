@props(['headers', 'inputs'])

@php

    $successName = ['active_name'];
    $productHightlight = ['status_name'];

    if (!function_exists('getStatusClass')) {
        function getStatusClass($status)
        {
            switch ($status) {
                case 'Hoạt động':
                    return 'text-success';
                case 'Đang bán':
                    return 'text-success';
                case 'Dừng bán':
                    return 'text-warning';
                default:
                    return 'text-danger';
            }
        }
    }
@endphp

<table class="table">
    <thead class="bg-danger">
        <tr>
            @foreach ($headers as $attr => $headerName)
                <th scope="col">{{ $headerName }}</th>
            @endforeach


        </tr>
    </thead>
    <tbody class="table-group-divider">
        @foreach ($inputs as $item)
            <tr>
                @foreach ($headers as $attr => $headerName)
                    @if ($loop->last)
                        <td>
                            <div class="d-flex justify-content-start " style="gap: 0.5rem">
                                <a href="{{ route('admin.product.edit', ['id' => $item['id']]) }}">
                                    <x-forms.button class="m-0 p-0 text-info" type="button" icon="fas fa-edit ">
                                    </x-forms.button>
                                </a>



                                <x-forms.button class="m-0 p-0 text-danger"
                                    modalID="{{ '#deleteProductModal' . '-' . $item['id'] }}" type="button"
                                    icon="fas fa-trash-alt ">
                                </x-forms.button>

                                <x-modal isAjax action="{{ route('admin.product.delete.ajax', ['id' => $item['id']]) }}"
                                    method="DELETE" id="{{ 'deleteProductModal' . '-' . $item['id'] }}"
                                    title="Bạn có muốn xóa sản phẩm ?">
                                    <div class="d-flex justify-content-end" style="gap: 0.5rem">

                                        Bạn có muốn xóa sản phẩm {{ $item['product_name'] }}
                                    </div>

                                </x-modal>


                            </div>
                        </td>
                    @endif



                    @if (in_array($attr, $successName))
                        <td class="{{ $item[$attr] === 'Hoạt động' ? 'text-success' : 'text-danger' }}">
                            {{ $item[$attr] }}</td>
                    @elseif (in_array($attr, $productHightlight))
                        <td class="{{ getStatusClass($item[$attr]) }}">
                            {{ $item[$attr] }}</td>
                    @else
                        <td>
                            {{ $item[$attr] }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
