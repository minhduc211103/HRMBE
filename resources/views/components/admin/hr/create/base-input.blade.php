@props([])

<div class="{{ $wrapperClass }}">
    <label class="form-label fw-bold">
        {{ $label }}
    </label>

    <div class="input-group">
        <span class="input-group-text bg-light">
            <i class="{{ $icon }}"></i>
        </span>

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ $type === 'password' ? '' : old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            class="form-control {{ $inputClass }} @error($name) is-invalid @enderror"
        >
        @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
