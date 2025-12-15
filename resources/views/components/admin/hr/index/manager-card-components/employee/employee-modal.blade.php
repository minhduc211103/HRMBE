<div class="modal fade" id="employeeSettingsModal-{{ $employee->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            {{-- 1. HEADER  --}}
            <div class="modal-header bg-success text-white py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                        <i class="bi bi-person-badge fs-4 text-white"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold">Employee Profile</h5>
                        <small class="opacity-75">ID: #{{ $employee->id }} | Team: {{ $employee->manager->name }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
                <div class="modal-body p-0">
                    <div class="row g-0 h-100">
                        {{-- CỘT TRÁI: AVATAR & thông tin cơ bản --}}
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
                                            <div class="fw-bold small">{{ $employee->manager->name }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">Manager</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- CỘT PHẢI: thông tin đầy đủ --}}
                        <div class="col-md-8 bg-white">
                            <div class="p-4">
                                {{-- Section 1: Thông tin cá nhân --}}
                                <h6 class="text-uppercase text-secondary fw-bold small mb-3 border-bottom pb-2">
                                    <i class="bi bi-person-lines-fill me-1"></i> Contact Information
                                </h6>

                                <div class="row g-3 mb-4">
                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted">Full Name </label>
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
               <x-admin.hr.index.btn-canel/>
        </div>
    </div>
</div>
