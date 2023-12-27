@props(['headers', 'inputs'])

@php

    $successName = ['active_name'];
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
                                <a href="{{ route('admin.user.edit', ['id' => $item['id']]) }}">
                                    <x-forms.button class="m-0 p-0 text-info" type="button" icon="fas fa-edit ">
                                </a>

                                </x-forms.button>
                                <x-forms.button class="m-0 p-0 text-danger"
                                    modalID="{{ '#deleteUserModal' . $item['id'] }}" type="button"
                                    icon="fas fa-trash-alt ">
                                </x-forms.button>
                                <x-forms.button class="m-0 p-0 " type="button" icon="fas fa-user-times "
                                    modalID="{{ '#changeActiveModal' . $item['id'] }}">
                                </x-forms.button>



                                <x-modal action="{{ route('admin.user.change.active', ['id' => $item['id']]) }}"
                                    method="put" id="{{ 'changeActiveModal' . $item['id'] }}"
                                    title="Bạn có muốn thay đổi trạng thái ?">
                                    <div class="d-flex justify-content-end" style="gap: 0.5rem">

                                        Bạn có muốn thay đổi trạng thái {{ $item['active_name'] }}
                                    </div>

                                </x-modal>

                                <x-modal action="{{ route('admin.user.delete', ['id' => $item['id']]) }}"
                                    method="delete" id="{{ 'deleteUserModal' . $item['id'] }}"
                                    title="Bạn có muốn xóa user này ?">
                                    <div class="d-flex justify-content-end" style="gap: 0.5rem">

                                        Bạn có muốn xóa user này {{ $item['email'] }}
                                    </div>

                                </x-modal>



                            </div>
                        </td>
                    @endif

                    @if (in_array($attr, $successName))
                        <td class="{{ $item[$attr] === 'Hoạt động' ? 'text-success' : 'text-danger' }}">
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
