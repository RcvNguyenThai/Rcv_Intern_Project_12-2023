@php

    $listInput = [
        [
            'name' => 'name',
            'label' => 'Họ Tên',
            'type' => 'text',
            'placeholder' => 'Nhập họ tên',
            'value' => $user->name,
        ],
        [
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email',
            'placeholder' => 'Nhập email',
            'value' => $user->email,
        ],
    ];

    $listSelect = [
        [
            'title' => 'Loại nhóm',
            'options' => $arrGroupTransform,
            'name' => 'group',
            'defaultValue' => $user->group_id,
        ],
    ];
@endphp

<div>

    <form action="{{ route('admin.user.put', $user->id) }}" method="post">
        @method('PUT')
        @csrf

        @foreach ($listInput as $input)
            <x-forms.input :error="$errors->first($input['name'])" :label="$input['label']" :name="$input['name']" :type="$input['type']" :placeholder="$input['placeholder']"
                :value="$input['value']" />
        @endforeach

        @foreach ($listSelect as $select)
            <x-forms.select-box :title="$select['title']" :options="$select['options']" :defaultValue="$select['defaultValue']" :name="$select['name']" />
        @endforeach

        <div class="d-flex justify-content-end" style="gap: 0.5rem">
            <x-forms.button type="submit" icon="fas fa-search ">
                Chỉnh sửa
            </x-forms.button>
            <x-forms.button id="add-reset" type="button" class="btn-success" icon="fas fa-sync-alt">
                Reset
            </x-forms.button>

        </div>
    </form>



</div>
@section('js')
    <script>
        $(document).ready(function() {
            $('#add-reset').on('click', function() {
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
