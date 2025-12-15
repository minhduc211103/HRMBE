<div class="mb-4">
    <label class="form-label fw-bold d-block">Select Role </label>
    <div class="d-flex gap-3">
        {{-- Employee Radio --}}
        <div class="form-check custom-radio-card">
            <input class="form-check-input" type="radio" name="role" value="employee" id="roleEmployee"
                {{ old('role', 'employee') == 'employee' ? 'checked' : '' }}>
            <label class="form-check-label" for="roleEmployee">
                <span class="d-block fw-bold">Employee</span>
                <small class="text-muted">Managed by a manager</small>
            </label>
        </div>

        {{-- Manager Radio --}}
        <div class="form-check custom-radio-card">
            <input class="form-check-input" type="radio" name="role" value="manager" id="roleManager"
                {{ old('role') == 'manager' ? 'checked' : '' }}>
            <label class="form-check-label" for="roleManager">
                <span class="d-block fw-bold">Manager</span>
                <small class="text-muted">Manages a team</small>
            </label>
        </div>
    </div>
    @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>

@push('css')
    <style>
        /* Style cho Radio button to đẹp hơn */
        .custom-radio-card {
            border: 1px solid #dee2e6;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            flex: 1;
        }
        .custom-radio-card:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush

