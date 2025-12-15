<div id="managerBox" class="fade-transition">
    <label class="form-label fw-bold text-primary">
        <i class="bi bi-people-fill me-1"></i> Assign to Manager
    </label>
    <select name="manager_id" class="form-select @error('manager_id') is-invalid @enderror">
        <option value="">-- Choose a Manager --</option>
        @foreach($managers as $manager)
            <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                {{ $manager->name }}
            </option>
        @endforeach
    </select>
    <div class="form-text">Select who will manage this employee.</div>
    @error('manager_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
@push('css')
    <style>
        /* Hiệu ứng chuyển đổi mượt mà */
        .fade-transition {
            animation: fadeIn 0.4s ease-in-out;
        }
    </style>
@endpush
