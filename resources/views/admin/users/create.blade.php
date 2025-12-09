@extends('layouts.app')

@section('page_title', 'Create New User')

@section('content')
    @if(session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Create New User</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{route('admin.users.store')}}">
                @csrf
                @method('POST')
                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="Enter email">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ROLE -->
                <div class="mb-4">
                    <label class="form-label d-block">Role</label>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="role" value="employee" id="roleEmployee" checked>
                        <label class="form-check-label" for="roleEmployee">Employee</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="role" value="manager" id="roleManager">
                        <label class="form-check-label" for="roleManager">Manager</label>
                    </div>

                    @error('role')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NAME -->
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Enter full name">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PHONE -->
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="number" name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}"
                           placeholder="Enter phone number">
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ✅ MANAGER SELECT (CHỈ HIỆN KHI LÀ EMPLOYEE) -->
                <div class="mb-3" id="managerBox">
                    <label class="form-label">Select Manager</label>
                    <select name="manager_id"
                            class="form-select @error('manager_id') is-invalid @enderror">
                        <option value="">-- Select Manager --</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}">
                                {{ $manager->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('manager_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ✅ POSITION (CHỈ HIỆN KHI LÀ MANAGER) -->
                <div class="mb-3 d-none" id="positionBox">
                    <label class="form-label">Position</label>
                    <input type="text" name="position"
                           class="form-control @error('position') is-invalid @enderror"
                           value="{{ old('position') }}"
                           placeholder="Enter position">
                    @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUTTONS -->
                <div class="d-flex justify-content-between mt-3">
                    <a href="/admin" class="btn btn-secondary">
                        Back
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-user-plus me-1"></i> Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script>
        const roleEmployee = document.getElementById('roleEmployee');
        const roleManager = document.getElementById('roleManager');
        const managerBox = document.getElementById('managerBox');
        const positionBox = document.getElementById('positionBox');

        function toggleRoleUI() {
            if (roleEmployee.checked) {
                managerBox.classList.remove('d-none');
                positionBox.classList.add('d-none');
            } else {
                managerBox.classList.add('d-none');
                positionBox.classList.remove('d-none');
            }
        }

        roleEmployee.addEventListener('change', toggleRoleUI);
        roleManager.addEventListener('change', toggleRoleUI);

        toggleRoleUI(); // load lần đầu
        document.addEventListener('DOMContentLoaded', function () {
            // Kiểm tra xem có toast element không (tức là có session success)
            var toastEl = document.getElementById('successToast');
            if (toastEl) {
                // Khởi tạo bootstrap toast
                // delay: 3000 nghĩa là 3 giây sau tự tắt
                var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
            }
        });
    </script>
@endpush

