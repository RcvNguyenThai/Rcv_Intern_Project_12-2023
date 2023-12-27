@php

    $listInput = [
        [
            'name' => 'oldPassword',
            'label' => 'Mật khẩu cũ',
            'type' => 'password',
            'placeholder' => 'Nhập mật khẩu cũ',
            'value' => '',
        ],
        [
            'name' => 'newPassword',
            'label' => 'Mật khẩu mới',
            'type' => 'password',
            'placeholder' => 'Nhập mật khẩu mới',
            'value' => '',
        ],
        [
            'name' => 'newPassword_confirmation',
            'label' => 'Nhập lại mật khẩu mới',
            'type' => 'password',
            'placeholder' => 'Nhập lại mật khẩu mới',
            'value' => '',
        ],
    ];

@endphp

<div>

    <form action="{{ route('admin.user.change.password', $user->id) }}" method="post">
        @method('PUT')
        @csrf

        @foreach ($listInput as $input)
            <x-forms.input :label="$input['label']" :name="$input['name']" :type="$input['type']" 
            :error="$errors->first($input['name'])"
            :placeholder="$input['placeholder']" :value="$input['value']" />
        @endforeach


        <div class="d-flex justify-content-end mt-2" style="gap: 0.5rem">
            <x-forms.button type="submit" icon="fas fa-search ">
                Cập nhật lại mật khẩu
            </x-forms.button>
            <x-forms.button id="change-password-reset" type="button" class="btn-success" icon="fas fa-sync-alt">
                Reset
            </x-forms.button>

        </div>
    </form>



</div>
@section('js')
    <script>
        $(document).ready(function() {
            $('#change-password-reset').on('click', function() {
                // Loop through the list of input elements
                @foreach ($listInput as $input)
                    // Set the value of each input element to an empty string by id
                    $('#{{ $input['name'] }}').val('');
                @endforeach

            });
        });
    </script>
@endsection
