@php
    $isUpdate = isset($product);
    if ($isUpdate) {
        $currentImg = substr($product?->images?->first()?->img_url, 1) ? substr($product?->images?->first()?->img_url, 1) : 'images/default.png';
    }
@endphp

<div>

    <div class="d-flex justify-content-center mb-2">
        <img width="200" height="200" style="object-fit: cover" class="rounded "
            src="{{ $isUpdate ? asset($currentImg) : asset('images/default.png') }}" alt="default img"
            id="preview-image" />
    </div>
    <div class="d-flex w-100 justify-content-center">
        <div class="d-flex w-50 flex-column justify-content-center" style="gap: 0.5rem">
            <x-forms.button type="button" id="image-upload-btn" icon="fas fa-upload" class="btn-primary ">
                Upload </x-forms.button>
            <input type="file" name="fileUpload" value="{{ isset($imgUpload) ? $imgUpload : '' }}" id="image"
                class="d-none">
            @if ($errors->has('fileUpload'))
                <span class="text-danger">{{ $errors->first('fileUpload') }}</span>
            @endif
            <x-forms.button type="button" id="image-delete-btn" icon="fas fa-trash-alt"
                class="btn-danger  justify-content-center">
                Xóa file </x-forms.button>
            <p id="file-name"></p>
        </div>
    </div>
</div>

@section('js')
    <script>
        @if (isset($imgUpload))

            $('#image').val('{{ $imgUpload }}');
        @endif

        $('#image-delete-btn').on('click', function() {
            $('#image').val('');
            $('#file-name').text('');
            $('#preview-image').attr('src', '{{ asset('images/default.png') }}');
        })

        $('#image-upload-btn').on('click', function() {
            $('#image').click();
        })

        $('#image').on('change', function() {
            // Display the name of the selected file
            $('#file-name').text(this.files[0].name);

            // Preview the selected image
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        })
    </script>
@endsection
