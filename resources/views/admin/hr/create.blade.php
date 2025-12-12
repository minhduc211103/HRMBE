@extends('layouts.admin')

@section('title', 'Create New User')
@section('page-title', 'Staff Management')

@section('content')

    {{-- TOAST NOTIFICATION --}}
    @if(session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1060;">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fs-6">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- MAIN CARD --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-bottom border-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-person-plus-fill me-2"></i>Create New Staff
            </h5>
            <a href="/admin/hr" class="btn btn-light btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.hr.store') }}">
                @csrf

                <div class="row g-4">
                    {{-- CỘT TRÁI: THÔNG TIN CƠ BẢN --}}
                    <div class="col-md-6 border-end-md">
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">
                            <i class="bi bi-person-vcard me-1"></i> Personal & Account
                        </h6>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Please enter full name !">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}" placeholder="Please enter phone number !">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="text" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="Please enter email !">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Please enter password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- CỘT PHẢI: VAI TRÒ & PHÂN QUYỀN --}}
                    <div class="col-md-6 ps-md-4">
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">
                            <i class="bi bi-sliders me-1"></i> Role & Assignment
                        </h6>

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Select Role <span class="text-danger">*</span></label>
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

                        <hr class="border-light">

                        <div class="role-content">
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
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <button type="reset" class="btn btn-light px-4">Reset</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Create User
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('css')
    <style>
        /* Đường kẻ dọc giữa 2 cột trên desktop */
        @media (min-width: 768px) {
            .border-end-md {
                border-right: 1px solid #dee2e6;
            }
        }
        /* Hiệu ứng chuyển đổi mượt mà */
        .fade-transition {
            animation: fadeIn 0.4s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
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
        .form-check-input:checked + .form-check-label span {
            color: #0d6efd;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Logic ẩn hiện Dynamic Form
            const roleEmployee = document.getElementById('roleEmployee');
            const roleManager = document.getElementById('roleManager');
            const managerBox = document.getElementById('managerBox');
            const positionBox = document.getElementById('positionBox');

            function toggleRoleUI() {
                if (roleEmployee.checked) {
                    // Hiện Manager Select, Ẩn Position
                    managerBox.classList.remove('d-none');
                    positionBox.classList.add('d-none');
                } else {
                    // Ẩn Manager Select, Hiện Position
                    managerBox.classList.add('d-none');
                    positionBox.classList.remove('d-none');
                }
            }

            // Gán sự kiện
            roleEmployee.addEventListener('change', toggleRoleUI);
            roleManager.addEventListener('change', toggleRoleUI);

            // Chạy ngay khi load để đảm bảo đúng trạng thái cũ (old inputs)
            toggleRoleUI();

            // 2. Logic Toast Notification
            var toastEl = document.getElementById('successToast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
            }
        });
    </script>
@endpush
