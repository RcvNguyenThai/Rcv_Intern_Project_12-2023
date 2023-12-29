@extends('layouts.master')

@php

    $perPageSelect = ['5' => 5, '10' => 10, '20' => 20, '50' => 50];
@endphp

@section('content')
    <div class="container-fluid p-4">
        @include('pages.products.search.product-search')
        <div class="row ">
            <div class="col-md-6 col-12">

            </div>
            <div class="col-md-6 px-0 me-6 mt-4 mb-3 row justify-content-md-between align-items-center col-12 ">
                <div class=" col-12">
                    {{-- {{ $products->links() }} --}}

                    <div id="pagination-links-first">
                        <!-- Pagination links will be placed here -->
                        {!! $products->links() !!}
                    </div>
                </div>

                <div class=" col-12">
                    Hiển thị từ 1 ~ {{ $perPage ?? 5 }} trong tổng số
                    <b>
                        {{ $products->total() }}
                    </b> người dùng

                </div>
            </div>
        </div>

        <div id="product-table">

            @include('pages.products.partial.product-table')
        </div>
        @if ($products->count() == 0)
            <div class="text-warning mt-2">
                Không có dữ liệu nào
            </div>
        @endif

        <div class="d-md-flex w-100 justify-content-between align-items-center mt-3 ">
            <div class="d-flex align-items-center " style="gap: 0.5rem">
                <div class="mt-1">
                    Hiển thị
                </div>
                <div id="per-page-select">
                    <x-forms.select-box isForm name="perPage" :options="$perPageSelect" />

                </div>
                <div class="mt-1">
                    Đơn vị
                </div>
            </div>

            <div id="pagination-links-second">
                <!-- Pagination links will be placed here -->
                {!! $products->links() !!}
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            function fetchProducts(page = 1, perPage = 5, productName = '', fromPrice = 0, toPrice = 1000000000,
                status = null) {
                $.ajax({
                    url: '{{ route('admin.product.paginate') }}/?perPage=' + perPage + '&productName=' +
                        productName + '&fromPrice=' + fromPrice + '&toPrice=' + toPrice + '&status=' +
                        status,
                    method: 'GET',
                    data: {
                        page: page,
                    },
                    dataType: 'json',
                    success: function(response) {

                        $("#product-table").html(response.view);
                        $("#pagination-links-first").html(response.pagination);
                        $("#pagination-links-second").html(response.pagination);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }


            function getParam() {
                return {
                    productName: $('#form-user-search #productName').val(),
                    perPage: $('#per-page-select select').val(),
                    fromPrice: $('#form-user-search #fromPrice').val(),
                    toPrice: $('#form-user-search #toPrice').val(),
                    status: $('#form-user-search #status').val(),
                }
            }

            // First Pagination
            $(document).on('click', '#pagination-links-first a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                const {
                    productName,
                    fromPrice,
                    toPrice,
                    status,
                    perPage
                } = getParam();
                fetchProducts(page, perPage, productName, fromPrice, toPrice, status);
            });

            // Second Pagination
            $(document).on('click', '#pagination-links-second a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                const {
                    productName,
                    fromPrice,
                    toPrice,
                    status,
                    perPage
                } = getParam();
                fetchProducts(page, perPage, productName, fromPrice, toPrice, status);
            });


            // select per page

            $(document).on('change', '#per-page-select select', function(e) {
                e.preventDefault();
                const perPage = $(this).val();
                const {
                    productName,
                    fromPrice,
                    toPrice,
                    status
                } = getParam();
                fetchProducts(1, perPage, productName, fromPrice, toPrice, status);
            });

            // search field section

            //product name
            $(document).on('change', '#form-user-search #productName', function(e) {
                e.preventDefault();
                const productName = $(this).val();
                const {
                    perPage,
                    fromPrice,
                    toPrice,
                    status
                } = getParam();

                fetchProducts(1, perPage, productName, fromPrice, toPrice, status);
            });

            //fromPrice Name
            $(document).on('change', '#form-user-search #fromPrice', function(e) {
                e.preventDefault();
                const fromPrice = $(this).val();
                const {
                    perPage,
                    productName,
                    toPrice,
                    status
                } = getParam();

                fetchProducts(1, perPage, productName, fromPrice, toPrice, status);
            });

            //fromPrice Name
            $(document).on('change', '#form-user-search #toPrice', function(e) {
                e.preventDefault();
                const toPrice = $(this).val();
                const {
                    perPage,
                    productName,
                    fromPrice,
                    status
                } = getParam();

                fetchProducts(1, perPage, productName, fromPrice, toPrice, status);
            });

            // status name field
            $(document).on('change', '#form-user-search #status', function(e) {
                e.preventDefault();
                const status = $(this).val();
                const {
                    perPage,
                    productName,
                    fromPrice,
                    toPrice
                } = getParam();

                fetchProducts(1, perPage, productName, fromPrice, toPrice, status);
            });

        });
    </script>
@endsection
