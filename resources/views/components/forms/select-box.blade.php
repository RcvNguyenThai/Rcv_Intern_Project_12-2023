<div class="form-group">
    <label class="form-label {{ !$title && 'd-none' }}">{{ $title }}</label>
    <select class="form-select form-control" name="{{ $name ?? '' }}" id="{{ $name ?? '' }}">
        @foreach ($options as $label => $value)
            <option value="{{ $value }}"
                {{ ($defaultValue == $value ? 'selected' : request()->input($name) === (string) $value) ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

@if (!$isForm)
    <script>
        $('#{{ $name ?? '' }}').on('change', function() {

            let url = new URL(window.location.href);
            let params = new URLSearchParams(url.search);
            params.set('{{ $name }}', this.value);
            url.search = params.toString();
            window.location.assign(url.toString());
        });
    </script>
@endif
