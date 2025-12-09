@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-lg border-0" style="width: 100%; max-width: 420px;">

            <!-- HEADER -->
            <div class="card-header bg-dark text-white text-center py-4">
                <h4 class="mb-0">
                    <i class="fa-solid fa-user-shield me-2"></i>
                    ADMIN LOGIN
                </h4>
            </div>
            <!-- BODY -->
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.login') }}" novalidate>
                    @csrf

                    <!-- USERNAME -->
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
                            placeholder="Enter admin account..."
                        >
                        </div>

                        {{--  LỖI HIỂN THỊ DƯỚI USERNAME --}}
                        @error('username')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- PASSWORD -->
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
                            placeholder="Enter admin password"
                        >
                        </div>

                        {{--  LỖI HIỂN THỊ DƯỚI PASSWORD --}}
                        @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- BUTTON -->
                    <button type="submit" class="btn btn-dark w-100 mt-3">
                        <i class="fa-solid fa-right-to-bracket me-1"></i>
                        Login
                    </button>
                </form>

            </div>

        </div>
    </div>
@endsection
