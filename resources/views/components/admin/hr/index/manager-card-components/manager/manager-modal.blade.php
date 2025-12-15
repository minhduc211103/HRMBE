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
            {{-- =================== MAIN INFO =================== --}}

            <div class="modal-body p-0">
                <div class="row g-0 h-100">
                    {{-- CỘT TRÁI: AVATAR & INFO CƠ BẢN --}}
                    <div class="col-md-4 bg-light border-end">
                        <div class="p-4 text-center">

                            {{-- Avatar ( FAKE = Chữ cái đầu của tên) --}}
                            <div class="position-relative d-inline-block mb-3">
                                <div class="bg-white border shadow-sm rounded-circle d-flex justify-content-center align-items-center mx-auto"
                                     style="width: 120px; height: 120px;">
                        <span class="display-4 fw-bold text-primary">
                            {{ substr($manager->name, 0, 1) }}
                        </span>
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
                                            <div class="fw-bold fs-5 text-warning">{{ $manager->projects->count() }}</div>
                                            <small class="text-muted" style="font-size: 0.7rem;">PROJECTS</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Read-only Meta Info --}}
                            <div class="text-start mt-4">
                                <h6 class="text-uppercase text-muted small fw-bold mb-2">System Info</h6>
                                <ul class="list-unstyled small text-muted">
                                    <li class="mb-2">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        Joined: {{ $manager->created_at->format('M Y') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-shield-lock me-2"></i>
                                        Role: Manager
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    {{-- CỘT PHẢI: THÔNG TIN CHI TIẾT --}}
                    <div class="col-md-8 bg-white">
                        <div class="p-4">
                            <h6 class="text-uppercase text-primary fw-bold small mb-3 border-bottom pb-2">
                                <i class="bi bi-pencil-square me-1"></i> Personal Information
                            </h6>

                            <div class="row g-3 mb-4">

                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">
                                        Full Name
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $manager->name }}"
                                               readonly disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $manager->phone ?? '' }}"
                                               readonly disabled>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">Email Address (Login)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                        <input type="email"
                                               class="form-control"
                                               value="{{ $manager->user->email }}"
                                               readonly disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Position</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-building"></i></span>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $manager->position ?? '' }}"
                                               readonly disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Cancel button --}}
            <x-admin.hr.index.btn-canel/>
        </div>
    </div>
</div>
