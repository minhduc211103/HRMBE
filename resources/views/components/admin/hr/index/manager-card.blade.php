<div class="card border-0 shadow-sm mb-3">
    {{-- 1. MANAGER HEADER --}}
    <div class="card-header bg-white p-0 d-flex align-items-stretch" id="heading-{{ $manager->id }}">
        {{--  Thẻ MANAGER chính  --}}
        <button class="btn btn-link w-100 text-decoration-none text-dark d-flex justify-content-between align-items-center p-3 text-start collapsed flex-grow-1"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapse-{{ $manager->id }}"
                aria-expanded="false">
            {{-- Thông tin Manager --}}
            <x-admin.hr.index.manager-card-components.manager.manager-info :name="$manager->name" :email="$manager->user->email"/>
            {{-- Số lượng nhân viên & Mũi tên --}}
            <x-admin.hr.index.manager-card-components.manager.employee-count :employeeCount="$manager->employees->count()"/>
        </button>
        {{-- Nút Settings cho MANAGER --}}
        <x-admin.hr.index.manager-card-components.manager.btn-manager-setting :id="$manager->id" />
    </div>

    {{-- === MODAL cho MANAGER === --}}
    <x-admin.hr.index.manager-modal :manager="$manager"/>

    {{-- 2. EMPLOYEES LIST --}}
    <x-admin.hr.index.manager-card-components.employee.employees-list :manager="$manager"/>
</div>
@push('css')
    <style>
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
