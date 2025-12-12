@extends('layouts.admin')

@section('title', 'Project Management')
@section('page-title', 'Projects & Tasks')

@section('content')
    {{-- TOAST NOTIFICATION --}}
    @if(session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1060;">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fs-6">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    {{-- HEADER & BUTTON --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark">Project Overview</h4>
            <p class="text-muted mb-0">Track projects, managers, and detailed tasks.</p>
        </div>
        <a href="{{route('admin.projects.create')}}" class="btn btn-primary shadow-sm rounded-pill px-3">
            <i class="bi bi-folder-plus me-1"></i> New Project
        </a>
    </div>

    {{-- MAIN ACCORDION --}}
    <div class="accordion" id="projectAccordion">
        @forelse($projects as $project)
            <div class="card border-0 shadow-sm mb-3 overflow-hidden rounded-3">

                {{-- 1. HEADER (Đã tách nút Setting ra khỏi nút Accordion) --}}
                <div class="card-header bg-white p-0 d-flex align-items-stretch" id="heading-{{ $project->id }}">

                    {{-- A. Button kích hoạt Accordion (Chiếm phần lớn diện tích) --}}
                    <button class="btn btn-link text-decoration-none text-dark text-start p-3 flex-grow-1 project-btn collapsed position-relative"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $project->id }}"
                            aria-expanded="false">

                        <div class="row align-items-center">
                            {{-- Cột 1: Tên & Icon --}}
                            <div class="col-md-5 d-flex align-items-center gap-3">
                                <div class="project-icon bg-primary bg-opacity-10 text-primary rounded-3 d-flex justify-content-center align-items-center flex-shrink-0">
                                    <i class="bi bi-briefcase-fill fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-truncate" style="max-width: 250px;">{{ $project->name }}</h6>
                                    <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                        {{ $project->description ?? 'No description' }}
                                    </small>
                                </div>
                            </div>

                            {{-- Cột 2: Progress --}}
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small fw-bold">Progress</span>
                                    <span class="small fw-bold">{{ $project->progress ?? 0 }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success rounded-pill" style="width: {{ $project->progress ?? 0 }}%"></div>
                                </div>
                            </div>

                            {{-- Cột 3: Mũi tên --}}
                            <div class="col-md-3 text-end pe-3">
                                <i class="bi bi-chevron-down transition-icon text-muted"></i>
                            </div>
                        </div>
                    </button>

                    {{-- B. Button Settings (Răng cưa) - Độc lập --}}
                    <div class="d-flex align-items-center border-start px-3 bg-light">
                        <button type="button"
                                class="btn btn-outline-secondary btn-sm border-0 rounded-circle"
                                data-bs-toggle="modal"
                                data-bs-target="#projectSettingsModal-{{ $project->id }}"
                                title="Project Settings">
                            <i class="bi bi-gear-fill fs-5"></i>
                        </button>
                    </div>
                </div>

                {{-- 2. TASKS LIST (Giữ nguyên như cũ) --}}
                <div id="collapse-{{ $project->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $project->id }}">
                    <div class="card-body bg-light border-top">

                        <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                            <h6 class="fw-bold text-primary mb-0">
                                <i class="bi bi-list-check me-2"></i>Task List ({{ $project->tasks->count() }})
                            </h6>
                        </div>

                        @if($project->tasks->count() > 0)
                            <div class="table-responsive bg-white rounded shadow-sm border">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-uppercase small text-muted">
                                    <tr>
                                        <th class="ps-4">Task Name</th>
                                        <th>Status</th>
                                        <th>Deadline</th>
                                        <th>Assigned To</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($project->tasks as $task)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="fw-medium text-dark">{{ $task->name }}</span>
                                            </td>
                                            <td>
                                                {{-- Badge màu sắc theo status --}}
                                                @php
                                                    $statusClass = match($task->status) {
                                                        'done' => 'success',
                                                        'doing' => 'primary',
                                                        'todo' => 'secondary',
                                                        default => 'light text-dark border'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }} rounded-pill text-uppercase" style="font-size: 0.7rem;">
                                                    {{ $task->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($task->end_date)
                                                    <small class="{{ \Carbon\Carbon::parse($task->end_date)->isPast() && $task->status != 'done' ? 'text-danger fw-bold' : 'text-muted' }}">
                                                        <i class="bi bi-calendar-event me-1"></i>
                                                        {{ \Carbon\Carbon::parse($task->end_date)->format('d M, Y') }}
                                                    </small>
                                                @else
                                                    <span class="text-muted small">--</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->employee)
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-light border text-secondary rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 24px; height: 24px; font-size: 0.65rem;">
                                                            {{ substr($task->employee->name, 0, 1) }}
                                                        </div>
                                                        <small>{{ $task->employee->name }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted small fst-italic">Unassigned</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            {{-- Empty State --}}
                            <div class="text-center py-4 text-muted border rounded bg-white border-dashed">
                                <i class="bi bi-clipboard-x fs-3 d-block mb-2 opacity-50"></i>
                                <span class="small">No tasks created for this project yet.</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- 3. MODAL EDIT/DELETE PROJECT (MỚI)         --}}
            {{-- ========================================== --}}
            <div class="modal fade" id="projectSettingsModal-{{ $project->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered"> {{-- Dùng modal-lg để rộng rãi hơn --}}
                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                        {{-- 1. Modal Header --}}
                        <div class="modal-header bg-primary text-white py-3">
                            <h5 class="modal-title fw-bold d-flex align-items-center">
                                <i class="bi bi-sliders2 me-2"></i>Project Details & Settings
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        {{-- 2. Modal Body --}}
                        <form action="{{route('admin.projects.update',$project->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-body p-4 bg-light bg-opacity-10">

                                {{-- SECTION A: READ-ONLY INFO (Thông tin định danh) --}}
                                <div class="p-3 bg-white rounded-3 shadow-sm border mb-4">
                                    <h6 class="text-uppercase text-primary fw-bold small mb-3 border-bottom pb-2">
                                        <i class="bi bi-shield-lock me-1"></i> Core Information (Read-only)
                                    </h6>
                                    <div class="row g-3">
                                        {{-- Project Name --}}
                                        <div class="col-md-7">
                                            <label class="form-label fw-bold small text-muted">Project Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-fonts"></i></span>
                                                <input type="text" class="form-control bg-light text-dark fw-bold border-start-0"
                                                       value="{{ $project->name }}" disabled readonly>
                                            </div>
                                        </div>

                                        {{-- Manager --}}
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

                                {{-- SECTION B: EDITABLE INFO (Thông tin được sửa) --}}
                                <div class="p-3 bg-white rounded-3 shadow-sm border">
                                    <h6 class="text-uppercase text-success fw-bold small mb-3 border-bottom pb-2">
                                        <i class="bi bi-pencil-square me-1"></i> Update Details
                                    </h6>

                                    {{-- Description --}}
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-muted">Description & Scope</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-muted"><i class="bi bi-card-text"></i></span>
                                            <textarea name="description" class="form-control" rows="4"
                                                      placeholder="Enter project description...">{{ $project->description }}</textarea>
                                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        {{-- Start Date --}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">Start Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white text-muted"><i class="bi bi-calendar-check"></i></span>
                                                <input type="date" name="start_date" class="form-control" id="start_date"
                                                       value="{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '' }}">
                                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        {{-- End Date --}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">End Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white text-muted"><i class="bi bi-calendar-x"></i></span>
                                                <input type="date" name="end_date" class="form-control" id="end_date"
                                                       value="{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : '' }}">
                                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- 3. Modal Footer --}}
                            <div class="modal-footer bg-light justify-content-between p-3">
                                {{-- Delete Button --}}
                                <form id="delete-project-form-{{ $project->id }}"
                                      action="{{route('admin.projects.destroy',$project->id)}}"
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger border-0 d-flex align-items-center gap-2">
                                        <i class="bi bi-trash3"></i>
                                        <span class="d-none d-sm-inline">Delete Project</span>
                                    </button>
                                </form>

                                {{-- Action Buttons --}}
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                        <i class="bi bi-check-lg me-1"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Hidden Delete Form --}}


                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="text-center py-5">
                <h5 class="text-muted">No Projects Found</h5>
            </div>
        @endforelse
    </div>

@endsection

@push('css')
    <style>
        .project-icon {
            width: 50px;
            height: 50px;
        }
        /* Hiệu ứng xoay mũi tên khi mở accordion */
        .btn-link[aria-expanded="true"] .transition-icon {
            transform: rotate(180deg);
        }
        .transition-icon {
            transition: transform 0.3s ease;
            display: inline-block;
        }
        /* Hiệu ứng hover cho header dự án */
        .project-btn:hover {
            background-color: #f8f9fa;
        }
        /* Border nét đứt cho empty state */
        .border-dashed {
            border-style: dashed !important;
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
