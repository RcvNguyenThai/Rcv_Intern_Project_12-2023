@extends('layouts.master')

@php
    $headers = ['id' => '#', 'name' => 'Họ Tên', 'email' => 'Email', 'group_name' => 'Nhóm', 'active_name' => 'Trạng thái', 'action' => 'Thao tác'];

    $perPageSelect = ['5' => 5, '10' => 10, '20' => 20, '50' => 50];
@endphp

@section('content')
    <div class="container-fluid p-4">
        @include('pages.users.search.user-search')
        <div class="row ">
            <div class="col-md-6 col-12">

            </div>
            <div class="col-md-6 px-0 me-6 mt-4 mb-3 row justify-content-md-between align-items-center col-12 ">
                <div class=" col-12">
                    {{ $users->links() }}

                </div>

                <div class=" col-12">
                    Hiển thị từ 1 ~ {{ $perPage ?? 5 }} trong tổng số
                    <b>
                        {{ $users->total() }}
                    </b> người dùng

                </div>
            </div>
        </div>
        <x-table :headers="$headers" :inputs="$users" />
        @if ($users->count() == 0)
            <div class="text-warning mt-2">
                Không có dữ liệu nào
            </div>
        @endif

        <div class="d-md-flex w-100 justify-content-between align-items-center mt-3 ">
            <div class="d-flex align-items-center " style="gap: 0.5rem">
                <div class="mt-1">
                    Hiển thị
                </div>
                <x-forms.select-box name="perPage" :options="$perPageSelect" />
                <div class="mt-1">
                    Đơn vị
                </div>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
