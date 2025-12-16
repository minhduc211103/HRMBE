<div class="modal fade" id="projectSettingsModal-{{ $project->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- Modal Header --}}
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold d-flex align-items-center">
                    <i class="bi bi-sliders2 me-2"></i>Project Details & Settings
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{--  Modal Body --}}
            <form id="update-project-form-{{ $project->id }}"
                  action="{{ route('admin.projects.update', $project->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4 bg-light bg-opacity-10">
                    {{-- Thông tin cơ bản --}}
                    <div class="p-3 bg-white rounded-3 shadow-sm border mb-4">
                        <h6 class="text-uppercase text-primary fw-bold small mb-3 border-bottom pb-2">
                            <i class="bi bi-shield-lock me-1"></i> Base Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label fw-bold small text-muted">Project Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-fonts"></i></span>
                                    <input type="text" class="form-control bg-light text-dark fw-bold border-start-0"
                                           value="{{ $project->name }}" disabled readonly>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-muted">Project Manager</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" class="form-control bg-light text-dark border-start-0"
                                           value="{{ $project->manager ? $project->manager->name : 'Unassigned' }}" disabled readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Thông tin có thể thay đổi --}}
                    <div class="p-3 bg-white rounded-3 shadow-sm border">
                        <h6 class="text-uppercase text-success fw-bold small mb-3 border-bottom pb-2">
                            <i class="bi bi-pencil-square me-1"></i> Update Details
                        </h6>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Description & Scope</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-card-text"></i></span>
                                <textarea name="description" class="form-control" rows="4"
                                          placeholder="Enter project description...">{{ $project->description }}</textarea>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Start Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" name="start_date" class="form-control"
                                           value="{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">End Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-calendar-x"></i></span>
                                    <input type="date" name="end_date" class="form-control"
                                           value="{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {{--  MODAL FOOTER --}}
            <div class="modal-footer bg-light justify-content-between p-3">
                {{-- DELETE FORM  --}}
                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger border-0 d-flex align-items-center gap-2">
                        <i class="bi bi-trash3"></i>
                        <span class="d-none d-sm-inline">Delete Project</span>
                    </button>
                </form>
                {{-- ACTION BUTTONS --}}
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
{{--                        Button Cập nhật form ở trên --}}
                    <button type="submit"
                            form="update-project-form-{{ $project->id }}"
                            class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Logic Date Validation (UX Improvement)
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
