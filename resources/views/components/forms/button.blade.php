<div class="d-flex align-items-center" style="{{ $icon ? 'gap: 0.5rem' : '' }}">

    <button data-toggle="{{ $modalID ? 'modal' : '' }}" data-target="{{ $modalID }}"
        type="{{ $type ? $type : 'submit' }}" class="{{ $class ? $class : 'btn-primary' }} btn btn-block">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif

        {{ $slot }}
    </button>
</div>
