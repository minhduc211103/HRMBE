<div class="mb-3">
    <label class="form-label">Password</label>
    <div class="input-group">
        <span class="input-group-text">
            <i class="fa-solid fa-lock"></i>
        </span>
        <input
            type="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Enter admin password">
    </div>

    {{-- Lỗi validate password --}}
    @error('password')
    <x-auth.login.error-input :message="$message"/>
    @enderror
</div>
