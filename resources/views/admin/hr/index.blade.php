@extends('layouts.admin')
@section('title', 'HR Management')
@section('page-title', 'Human Resources')
@section('content')

    {{-- HEADER & BUTTON --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark">Staff Directory</h4>
            <p class="text-muted mb-0">Manage managers and their subordinates.</p>
        </div>
        <a href="{{route('admin.hr.create')}}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> New Staff
        </a>
    </div>

    {{-- MAIN CONTENT: DANH SÁCH MANAGER --}}
    <div class="accordion" id="hrAccordion">

        @forelse($managers as $manager)
            <div class="card border-0 shadow-sm mb-3">

                {{-- 1. MANAGER HEADER (Đã tách nút Settings) --}}
                <div class="card-header bg-white p-0 d-flex align-items-stretch" id="heading-{{ $manager->id }}">

                    {{-- A. Nút Accordion (Chiếm phần lớn) --}}
                    <button class="btn btn-link w-100 text-decoration-none text-dark d-flex justify-content-between align-items-center p-3 text-start collapsed flex-grow-1"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $manager->id }}"
                            aria-expanded="false">

                        {{-- Thông tin Manager --}}
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center flex-shrink-0" style="width: 45px; height: 45px;">
                                <i class="bi bi-person-fill-gear fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold fs-5">
                                    {{ $manager->name }}
                                    <span class="badge bg-primary ms-2" style="font-size: 0.65rem;">MANAGER</span>
                                </div>
                                <small class="text-muted"><i class="bi bi-envelope me-1"></i> {{ $manager->user->email }}</small>
                            </div>
                        </div>

                        {{-- Số lượng nhân viên & Mũi tên --}}
                        <div class="d-flex align-items-center gap-3 pe-3">
                            <span class="badge bg-light text-dark border">{{ $manager->employees->count() }} Employees</span>
                            <i class="bi bi-chevron-down transition-icon"></i>
                        </div>
                    </button>

                    {{-- B. Nút Settings cho MANAGER (Độc lập) --}}
                    <div class="d-flex align-items-center border-start px-3 bg-light">
                        <button type="button"
                                class="btn btn-outline-secondary btn-sm border-0 rounded-circle"
                                data-bs-toggle="modal"
                                data-bs-target="#managerSettingsModal-{{ $manager->id }}"
                                title="Manager Settings">
                            <i class="bi bi-gear-fill fs-5"></i>
                        </button>
                    </div>
                </div>

                {{-- === MODAL CHO MANAGER (PHIÊN BẢN MỞ RỘNG) === --}}
                <div class="modal fade" id="managerSettingsModal-{{ $manager->id }}" tabindex="-1" aria-hidden="true">
                    {{-- Sử dụng modal-lg để rộng hơn --}}
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                            {{-- HEADER --}}
                            <div class="modal-header bg-primary text-white py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                                        <i class="bi bi-person-vcard fs-4 text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="modal-title fw-bold">Manager Profile</h5>
                                        <small class="opacity-75">ID: #{{ $manager->id }} | Created: {{ $manager->created_at->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="#" method="POST">
                                @csrf @method('PUT')

                                <div class="modal-body p-0">
                                    <div class="row g-0 h-100">

                                        {{-- CỘT TRÁI: AVATAR & INFO TÓM TẮT --}}
                                        <div class="col-md-4 bg-light border-end">
                                            <div class="p-4 text-center">
                                                {{-- Avatar to --}}
                                                <div class="position-relative d-inline-block mb-3">
                                                    <div class="bg-white border shadow-sm rounded-circle d-flex justify-content-center align-items-center mx-auto"
                                                         style="width: 120px; height: 120px;">
                                                        <span class="display-4 fw-bold text-primary">{{ substr($manager->name, 0, 1) }}</span>
                                                    </div>
                                                </div>

                                                <h6 class="fw-bold text-dark mb-1">{{ $manager->name }}</h6>
                                                <p class="text-muted small mb-3">{{ $manager->user->email }}</p>

                                                {{-- Stats Box --}}
                                                <div class="card border-0 shadow-sm bg-white mb-3">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-around">
                                                            <div class="text-center">
                                                                <div class="fw-bold fs-5 text-primary">{{ $manager->employees->count() }}</div>
                                                                <small class="text-muted" style="font-size: 0.7rem;">EMPLOYEES</small>
                                                            </div>
                                                            <div class="vr opacity-25"></div>
                                                            <div class="text-center">
                                                                {{-- Giả lập số dự án --}}
                                                                <div class="fw-bold fs-5 text-warning">{{$manager->projects->count()}}</div>
                                                                <small class="text-muted" style="font-size: 0.7rem;">PROJECTS</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Read-only Meta Info --}}
                                                <div class="text-start mt-4">
                                                    <h6 class="text-uppercase text-muted small fw-bold mb-2">System Info</h6>
                                                    <ul class="list-unstyled small text-muted">
                                                        <li class="mb-2"><i class="bi bi-calendar-check me-2"></i>Joined: {{ $manager->created_at->format('M Y') }}</li>
                                                        <li class="mb-2"><i class="bi bi-shield-lock me-2"></i>Role: Manager</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- CỘT PHẢI: FORM CHỈNH SỬA --}}
                                        <div class="col-md-8 bg-white">
                                            <div class="p-4">
                                                <h6 class="text-uppercase text-primary fw-bold small mb-3 border-bottom pb-2">
                                                    <i class="bi bi-pencil-square me-1"></i> Personal Information
                                                </h6>

                                                <div class="row g-3 mb-4">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold small text-muted">Full Name <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                                            <input type="text" name="name" class="form-control" value="{{ $manager->name }}" readonly disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold small text-muted">Phone Number</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                                            <input type="text" name="phone" class="form-control" value="{{ $manager->phone ?? '' }}" readonly disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold small text-muted">Email Address (Login)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                                            <input type="email" name="email" class="form-control" value="{{ $manager->user->email }}" readonly disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold small text-muted">Position</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light"><i class="bi bi-building"></i></span>
                                                            <input type="text" name="position" class="form-control" value="{{ $manager->position ?? '' }}" readonly disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- FOOTER --}}
                                <div class="modal-footer bg-light justify-content-between p-3">
{{--                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 d-flex align-items-center"--}}
{{--                                            onclick="confirmDelete('manager-delete-form-{{ $manager->id }}')">--}}
{{--                                        <i class="bi bi-trash3 me-2"></i> Delete Manager--}}
{{--                                    </button>--}}
                                    <div class="d-flex gap-2 ms-auto">
                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>

                            {{-- Form Delete Ẩn --}}
                            <form id="manager-delete-form-{{ $manager->id }}" action="#" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>

                {{-- 2. EMPLOYEES LIST (DROPDOWN BODY) --}}
                <div id="collapse-{{ $manager->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $manager->id }}">
                        <div class="card-body bg-light">

                            @if($manager->employees->count() > 0)
                                <div class="table-responsive bg-white rounded border">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Employee Name</th>
                                            <th>Contact</th>
                                            <th>Role</th>
                                            <th>Joined Date</th>
                                            <th class="text-end pe-4">Actions</th> {{-- Thêm cột Actions --}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($manager->employees as $employee)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 35px; height: 35px;">
                                                            <span class="fw-bold small">{{ substr($employee->name, 0, 1) }}</span>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $employee->name }}</div>
                                                            <small class="text-muted">ID: #{{ $employee->id }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="small"><i class="bi bi-envelope me-1"></i> {{ $employee->user->email }}</div>
                                                    <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $employee->phone ?? 'N/A' }}</div>
                                                </td>
                                                <td><span class="badge bg-success bg-opacity-10 text-success">Employee</span></td>
                                                <td>{{ $employee->created_at ? $employee->created_at->format('d M, Y') : 'N/A' }}</td>

                                                {{-- Cột Button Bánh Răng Employee --}}
                                                <td class="text-end pe-4">
                                                    <button class="btn btn-sm btn-light border rounded-circle text-muted"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#employeeSettingsModal-{{ $employee->id }}">
                                                        <i class="bi bi-gear-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- === MODAL CHO EMPLOYEE (PHIÊN BẢN PROFILE) === --}}
                                            <div class="modal fade" id="employeeSettingsModal-{{ $employee->id }}" tabindex="-1" aria-hidden="true">
                                                {{-- Sử dụng modal-lg để rộng rãi --}}
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                                                        {{-- 1. HEADER (Màu xanh lá để phân biệt với Manager) --}}
                                                        <div class="modal-header bg-success text-white py-3">
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                                                                    <i class="bi bi-person-badge fs-4 text-white"></i>
                                                                </div>
                                                                <div>
                                                                    <h5 class="modal-title fw-bold">Employee Profile</h5>
                                                                    <small class="opacity-75">ID: #{{ $employee->id }} | Team: {{ $manager->name }}</small>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <form action="#" method="POST">
                                                            @csrf @method('PUT')

                                                            <div class="modal-body p-0">
                                                                <div class="row g-0 h-100">

                                                                    {{-- CỘT TRÁI: AVATAR & INFO TÓM TẮT --}}
                                                                    <div class="col-md-4 bg-light border-end">
                                                                        <div class="p-4 text-center">
                                                                            {{-- Avatar --}}
                                                                            <div class="position-relative d-inline-block mb-3">
                                                                                <div class="bg-white border shadow-sm rounded-circle d-flex justify-content-center align-items-center mx-auto"
                                                                                     style="width: 100px; height: 100px;">
                                                                                    <span class="display-5 fw-bold text-success">{{ substr($employee->name, 0, 1) }}</span>
                                                                                </div>
                                                                            </div>

                                                                            <h6 class="fw-bold text-dark mb-1">{{ $employee->name }}</h6>
                                                                            <p class="text-muted small mb-3">
                                                                                <i class="bi bi-envelope me-1"></i>{{ $employee->user->email }}
                                                                            </p>

                                                                            {{-- Reporting Info --}}
                                                                            <div class="text-start mt-4 bg-white p-3 rounded border">
                                                                                <label class="small text-muted fw-bold text-uppercase mb-2">Reporting To</label>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px;">
                                                                                        <i class="bi bi-person-fill-gear small"></i>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="fw-bold small">{{ $manager->name }}</div>
                                                                                        <div class="text-muted" style="font-size: 0.7rem;">Manager</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- CỘT PHẢI: FORM CHỈNH SỬA --}}
                                                                    <div class="col-md-8 bg-white">
                                                                        <div class="p-4">
                                                                            {{-- Section 1: Thông tin cá nhân --}}
                                                                            <h6 class="text-uppercase text-secondary fw-bold small mb-3 border-bottom pb-2">
                                                                                <i class="bi bi-person-lines-fill me-1"></i> Contact Information
                                                                            </h6>

                                                                            <div class="row g-3 mb-4">
                                                                                <div class="col-12">
                                                                                    <label class="form-label fw-bold small text-muted">Full Name <span class="text-danger">*</span></label>
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                                                                        <input type="text" name="name" class="form-control" value="{{ $employee->name }}" readonly disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label class="form-label fw-bold small text-muted">Phone Number</label>
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                                                                        <input type="text" name="phone" class="form-control" value="{{ $employee->phone ?? '' }}" readonly disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label class="form-label fw-bold small text-muted">Email</label>
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                                                                        <input type="email" class="form-control bg-light" value="{{ $employee->user->email }}" readonly disabled>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label fw-bold small text-muted">Joined Date</label>
                                                                                    <input type="date" class="form-control bg-light"
                                                                                           value="{{ $employee->created_at ? $employee->created_at->format('Y-m-d') : '' }}" readonly disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            {{-- FOOTER --}}
                                                            <div class="modal-footer bg-light justify-content-between p-3">
    {{--                                                            <button type="button" class="btn btn-outline-danger btn-sm border-0 d-flex align-items-center"--}}
    {{--                                                                    onclick="confirmDelete('emp-delete-form-{{ $employee->id }}')">--}}
    {{--                                                                <i class="bi bi-trash3 me-2"></i> Delete Staff--}}
    {{--                                                            </button>--}}
                                                                <div class="d-flex gap-2 ms-auto">
                                                                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </form>

                                                        {{-- Form Delete Ẩn --}}
                                                        <form id="emp-delete-form-{{ $employee->id }}" action="#" method="POST" class="d-none">
                                                            @csrf @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 opacity-50"></i>
                                    <p>No employees assigned to this manager yet.</p>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning text-center">
                No managers found. Please create a manager first.
            </div>
        @endforelse

    </div>

@endsection

@push('css')
    <style>
        /* Hiệu ứng xoay mũi tên khi mở accordion */
        .btn-link[aria-expanded="true"] .transition-icon {
            transform: rotate(180deg);
        }
        .transition-icon {
            transition: transform 0.3s ease;
        }
        /* Loại bỏ gạch chân mặc định của btn-link */
        .btn-link {
            text-decoration: none !important;
        }
        /* Hover hiệu ứng cho dòng manager */
        .card-header:hover {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush
@push('js')
    <script>
        function confirmDelete(formId) {
            if (confirm('Are you sure you want to delete this record?')) {
                document.getElementById(formId).submit();
            }
        }
    </script>
@endpush
