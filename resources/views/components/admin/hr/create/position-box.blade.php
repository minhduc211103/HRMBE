<div id="positionBox" class="d-none fade-transition">
    <label class="form-label fw-bold text-success">
        <i class="bi bi-briefcase-fill me-1"></i> Job Title / Position
    </label>
    <input type="text" name="position"
           class="form-control @error('position') is-invalid @enderror"
           value="{{ old('position') }}"
           placeholder="Enter manager position ...">
    <div class="form-text">Specific title for this management role.</div>
    @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
@push('css')
    <style>
        /* Hiệu ứng chuyển đổi mượt mà */
        .fade-transition {
            animation: fadeIn 0.4s ease-in-out;
        }
    </style>
@endpush
