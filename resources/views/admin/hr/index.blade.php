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

                {{-- 1. MANAGER ROW (HEADER) --}}
                <div class="card-header bg-white py-3" id="heading-{{ $manager->id }}">
                    <h2 class="mb-0">
                        <button class="btn btn-link w-100 text-decoration-none text-dark d-flex justify-content-between align-items-center p-0 collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $manager->id }}"
                                aria-expanded="false"
                                aria-controls="collapse-{{ $manager->id }}">

                            {{-- Bên trái: Thông tin Manager --}}
                            <div class="d-flex align-items-center gap-3">
                                {{-- Avatar giả --}}
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-person-fill-gear fs-5"></i>
                                </div>

                                <div class="text-start">
                                    <div class="fw-bold fs-5">
                                        {{ $manager->name }}
                                        <span class="badge bg-primary ms-2" style="font-size: 0.65rem;">MANAGER</span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-envelope me-1"></i> {{ $manager->email }}
                                    </small>
                                </div>
                            </div>

                            {{-- Bên phải: Số lượng nhân viên & Icon mũi tên --}}
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-light text-dark border">
                                    {{ $manager->employees->count() }} Employees
                                </span>
                                <i class="bi bi-chevron-down transition-icon"></i>
                            </div>
                        </button>
                    </h2>
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
                                        <th class="text-end pe-4">Actions</th>
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
                                                <div class="small"><i class="bi bi-envelope me-1"></i> {{ $employee->email }}</div>
                                                <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $employee->phone ?? 'N/A' }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success bg-opacity-10 text-success">Employee</span>
                                            </td>
                                            <td>
                                                {{ $employee->created_at ? $employee->created_at->format('d M, Y') : 'N/A' }}
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="#" class="btn btn-sm btn-light text-primary" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-light text-danger ms-1" title="Remove">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            {{-- Trạng thái trống nếu không có nhân viên --}}
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
