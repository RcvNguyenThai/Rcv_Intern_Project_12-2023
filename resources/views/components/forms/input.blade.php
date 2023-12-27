@php
    $allowedTypes = ['text', 'email', 'tel', 'password', 'number', 'date', 'time'];
    $type = in_array($type, $allowedTypes) ? $type : 'text';
@endphp

<div class="{{ $class ?? '' }}">
    <label for="{{ $name }}" class="form-label {{ !$label && 'd-none' }}">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" placeholder="{{ $placeholder ?? '' }}"
        name="{{ $name }}" class="form-control" value="{{ $value ?? '' }}">
    @if ($error)
        <span class="text-danger">{{ $error }}</span>
    @endif
</div>
