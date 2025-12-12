<div class="mb-3">
    <label class="form-label">Username</label>

    <div class="input-group">
        <span class="input-group-text">
            <i class="fa-solid fa-user"></i>
        </span>
        <input
            type="text"
            name="username"
            class="form-control @error('username') is-invalid @enderror"
            value="{{ old('username') }}"
            placeholder="Enter admin account...">
    </div>
    {{--  lỗi validate username --}}
    @error('username')
    <x-auth.login.error-input :message="$message"/>
    @enderror
</div>
