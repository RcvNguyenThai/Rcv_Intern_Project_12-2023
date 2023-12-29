<div>
    <label for="{{ $name }}">
        {{ $label ?? '' }}
    </label>
    <div>
        <textarea id="{{ $name }}" name="{{ $name }}" placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
            rows="{{ $rows ?? 4 }}" cols="{{ $cols ?? 20 }}">
{{ $slot }} 
</textarea>

        @if ($error)
            <span class="text-danger">{{ $error }}</span>
        @endif
    </div>

</div>
