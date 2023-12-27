@php
    $listInput = [
        [
            'name' => 'name',
            'label' => 'Tên',
            'type' => 'text',
            'placeholder' => 'Nhập tên tìm kiếm',
            'value' => $nameParam,
        ],
        [
            'name' => 'email',
            'label' => 'Email',
            'type' => 'text',
            'placeholder' => 'Nhập email tìm kiếm',
            'value' => $emailParam,
        ],
    ];

    $listSelect = [
        [
            'title' => 'Loại nhóm',
            'options' => $arrGroupTransform,
            'name' => 'group',
        ],
        [
            'title' => 'Trạng thái',
            'options' => [
                '--- Trạng thái ---' => -1,
                'Hoạt động' => 1,
                'Không hoạt động' => 0,
            ],
            'name' => 'status',
        ],
    ];

    $addNewUserInput = [
        [
            'name' => 'addName',
            'label' => 'Tên',
            'type' => 'text',
            'placeholder' => 'Nhập tên',
        ],
        [
            'name' => 'addEmail',
            'label' => 'Email',
            'type' => 'text',
            'placeholder' => 'Nhập email',
        ],
        [
            'name' => 'password',
            'label' => 'Password',
            'type' => 'password',
            'placeholder' => 'Nhập mật khẩu',
        ],
        [
            'name' => 'password_confirmation',
            'label' => 'Re-enter Password',
            'type' => 'password',
            'placeholder' => 'Nhập lại mật khẩu',
        ],
    ];

    $addNewSelect = [
        [
            'title' => 'Loại nhóm',
            'options' => $arrGroupTransform,
            'name' => 'group',
        ],
        [
            'title' => 'Trạng thái',
            'options' => [
                'Hoạt động' => 1,
                'Không hoạt động' => 0,
            ],
            'name' => 'status',
        ],
    ];
@endphp

@extends('layouts.custom.search-layout')
<div class="container-fluid px-4 ">

    @section('title')
        User
    @endsection

    @section('search-content')
        <form method="get" action="{{ route('admin.user.get', $strQuery) }}" id="form-user-search">
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
                <input type="hidden" name="perPage" value="{{ $perPage }}">

            </div>

            <div>
                <div class="row  gap-2 mx-0 mt-2">
                    <div class=" row g-2 col-md-6 mx-0  col-12">

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewUserModal">
                            Thêm mới
                        </button>
                    </div>
                    <div class="row gx-2 mx-0 mt-4 mt-md-0  col-md-6 col-12 justify-content-md-end" style="gap: 0.5rem">
                        <x-forms.button type="submit" icon="fas fa-search ">
                            Tìm Kiếm
                        </x-forms.button>
                        <x-forms.button id="search-reset" type="button" class="btn-success" icon="fas fa-sync-alt">
                            Xóa tìm
                        </x-forms.button>

                    </div>
                </div>
            </div>
        </form>

        <x-modal action="{{ route('admin.user.post') }}" method="post" id="addNewUserModal" title="Thêm người dùng">

            @foreach ($addNewUserInput as $input)
                <x-forms.input :placeholder="$input['placeholder']" :name="$input['name']" :label="$input['label']" :type="$input['type']"
                    :error="$errors->first($input['name'])" />
            @endforeach
            <div class="mt-2"></div>
            @foreach ($addNewSelect as $select)
                <x-forms.select-box :name="$select['name']" :options="$select['options']" :title="$select['title']" isForm />
            @endforeach

        </x-modal>
    @endsection
</div>

@section('js')
    <script>
        $(document).ready(function() {
            $('#search-reset').on('click', function() {
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
