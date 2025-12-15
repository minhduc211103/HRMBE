<form method="POST" action="{{ route('admin.hr.store') }}">
    @csrf

    <div class="row g-4">
        {{-- CỘT TRÁI: THÔNG TIN CƠ BẢN --}}
        <div class="col-md-6 border-end-md">
            <h6 class="text-uppercase text-muted fw-bold small mb-3">
                <i class="bi bi-person-vcard me-1"></i> Personal & Account
            </h6>
            <x-admin.hr.create.base-input
                name="name"
                label="Full Name"
                icon="bi bi-person"
                placeholder="Please enter full name !"
            />

            <x-admin.hr.create.base-input
                name="phone"
                label="Phone Number"
                icon="bi bi-telephone"
                placeholder="Please enter phone number !"
            />

            <x-admin.hr.create.base-input
                name="email"
                label="Email Address"
                icon="bi bi-envelope"
                placeholder="Please enter email !"
            />

            <x-admin.hr.create.base-input
                name="password"
                label="Password"
                icon="bi bi-key"
                type="password"
                placeholder="Please enter password"
            />
        </div>

        {{-- CỘT PHẢI: VAI TRÒ & PHÂN QUYỀN --}}
        <div class="col-md-6 ps-md-4">
            <h6 class="text-uppercase text-muted fw-bold small mb-3">
                <i class="bi bi-sliders me-1"></i> Role & Assignment
            </h6>
            <x-admin.hr.create.form-radio-buttons-group/>
            <hr class="border-light">
            <div class="role-content">
                <x-admin.hr.create.manager-box :managers="$managers" />
                <x-admin.hr.create.position-box/>
            </div>
        </div>
    </div>
{{--    Button create + button reset--}}
    <x-admin.hr.create.form-buttons/>

</form>

@push('css')
    <style>
        /* Đường kẻ dọc giữa 2 cột trên desktop */
        @media (min-width: 768px) {
            .border-end-md {
                border-right: 1px solid #dee2e6;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
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
