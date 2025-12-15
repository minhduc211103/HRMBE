<div class="d-flex align-items-center gap-3 pe-3">
    <span class="badge bg-light text-dark border">{{ $employeeCount }} Employees</span>
    <i class="bi bi-chevron-down transition-icon"></i>
</div>
@push('css')
    <style>
        /* Hiệu ứng xoay mũi tên khi mở accordion */
        .btn-link[aria-expanded="true"] .transition-icon {
            transform: rotate(180deg);
        }
        .transition-icon {
            transition: transform 0.3s ease;
        }
    </style>
@endpush
