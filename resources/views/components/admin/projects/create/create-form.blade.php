<form method="POST" action="{{ route('admin.projects.store') }}">
    @csrf

    <div class="row g-4">
        {{-- CỘT TRÁI: THÔNG TIN CƠ BẢN --}}
        <div class="col-md-7 border-end-md">
            <h6 class="text-uppercase text-muted fw-bold small mb-3">
                <i class="bi bi-info-circle me-1"></i> Project Essentials
            </h6>

            <div class="mb-4">
                <label class="form-label fw-bold">Project Name <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-fonts"></i></span>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Project title ...">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-card-text"></i></span>
                    <textarea name="description" rows="5"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Describe the project ...">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI: QUẢN LÝ & THỜI GIAN --}}
        <div class="col-md-5 ps-md-4">
            <h6 class="text-uppercase text-muted fw-bold small mb-3">
                <i class="bi bi-calendar-range me-1"></i> Timeline & Team
            </h6>

            <div class="mb-4">
                <label class="form-label fw-bold">Project Manager</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-primary"><i class="bi bi-person-workspace"></i></span>
                    <select name="manager_id" class="form-select @error('manager_id') is-invalid @enderror">
                        <option value="">-- Unassigned --</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('manager_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-text">Select the person responsible for this project.</div>
            </div>

            <hr class="border-light my-4">

            <div class="mb-3">
                <label class="form-label fw-bold">Start Date</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-calendar-check"></i></span>
                    <input type="date" name="start_date" id="start_date"
                           class="form-control @error('start_date') is-invalid @enderror"
                           value="{{ old('start_date') }}">
                    @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">End Date</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-calendar-x"></i></span>
                    <input type="date" name="end_date" id="end_date"
                           class="form-control @error('end_date') is-invalid @enderror"
                           value="{{ old('end_date') }}">
                    @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <button type="reset" class="btn btn-light px-4">Reset</button>
        <button type="submit" class="btn btn-primary px-4 shadow-sm">
            <i class="bi bi-rocket-takeoff me-1"></i> Launch Project
        </button>
    </div>

</form>

@push('css')
    <style>
        /* Đường kẻ dọc giữa 2 cột trên màn hình lớn */
        @media (min-width: 768px) {
            .border-end-md {
                border-right: 1px solid #dee2e6;
            }
        }
        /* Style input group focus đẹp hơn */
        .input-group-text {
            border-right: 0;
            background-color: #f8f9fa;
        }
        .form-control:focus, .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        }
        .form-control, .form-select {
            border-left: 0;
        }
        /* Fix viền khi input group có lỗi */
        .is-invalid {
            border-left: 1px solid #dc3545 !important;
        }
    </style>
@endpush


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Logic Toast Notification
            var toastEl = document.getElementById('successToast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
            }

            // 2. Logic Date Validation (UX Improvement)
            // Khi chọn ngày bắt đầu, tự động set ngày kết thúc tối thiểu phải bằng ngày bắt đầu
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            startDateInput.addEventListener('change', function() {
                if (this.value) {
                    endDateInput.min = this.value;
                    // Nếu ngày kết thúc hiện tại nhỏ hơn ngày bắt đầu mới chọn -> reset
                    if (endDateInput.value && endDateInput.value < this.value) {
                        endDateInput.value = '';
                    }
                }
            });
        });
    </script>
@endpush
