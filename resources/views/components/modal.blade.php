<div class="modal fade {{ $isAjax ? 'modal-ajax' : '' }}" data-id={{ $id }} id={{ $id }}
    tabindex="-1" aria-labelledby="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id . '-title' }}">{{ $title }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if (!$isAjax)
                <form action="{{ $action }}" id="{{ $id . '-form' }}"
                    method="{{ $method == 'get' ? 'get' : 'post' }}">
                    @if ($method !== 'get')
                        @csrf
                    @endif

                    @method($method)
                    <div class="modal-body">

                        {{ $slot }}
                        {{-- <input type="hidden" name="_token" id="{{ $id . '-token' }}" value="{{ csrf_token() }}"> --}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" id="{{ $id . '-submit' }}" class="btn btn-primary">Lưu lại</button>
                    </div>
                </form>
            @else
                <div>
                    <div class="modal-body">

                        {{ $slot }}


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" id="{{ $id . '-submit' }}"
                            class="btn btn-primary btn-modal-ajax">OK</button>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@if (isset($isAjax) && $isAjax)
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function deleteProduct(id, page = 1, perPage = 5, productName = '', fromPrice = 0, toPrice =
                1000000000,
                status = null) {
                $.ajax({
                    url: `/admin/product/delete/ajax/${id.split('-')[1]}/?perPage=` +
                        perPage +
                        '&productName=' +
                        productName + '&fromPrice=' + fromPrice + '&toPrice=' + toPrice + '&status=' +
                        status,
                    method: 'DELETE',
                    data: {
                        "page": page,
                        "_token": "{{ csrf_token() }}"
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

            $(document).on('click', '.btn-modal-ajax', function(e) {
                e.preventDefault();

                const modal = $(this).closest('.modal-ajax');

                const modalId = modal.data('id');
                const {
                    productName,
                    perPage,
                    fromPrice,
                    toPrice,
                    status
                } = getParam();
                deleteProduct(modalId, 1, perPage, productName, fromPrice, toPrice, status);
            });
        })
    </script>
@endif
