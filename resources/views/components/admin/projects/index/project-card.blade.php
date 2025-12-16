<div class="card border-0 shadow-sm mb-3 overflow-hidden rounded-3">
    {{-- 1. HEADER  --}}
    <div class="card-header bg-white p-0 d-flex align-items-stretch" id="heading-{{ $project->id }}">
        {{-- Button kích hoạt Accordion  --}}
        <button class="btn btn-link text-decoration-none text-dark text-start p-3 flex-grow-1 project-btn collapsed position-relative"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapse-{{ $project->id }}"
                aria-expanded="false">
            <div class="row align-items-center">
                {{-- Tên & Icon --}}
                <div class="col-md-5 d-flex align-items-center gap-3">
                    <div class="project-icon bg-primary bg-opacity-10 text-primary rounded-3 d-flex justify-content-center align-items-center flex-shrink-0">
                        <i class="bi bi-briefcase-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-truncate" style="max-width: 250px;">{{ $project->name }}</h6>
                        <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                            {{ $project->manager?->name ?? 'Unassigned' }}
                        </small>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="col-md-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Progress</span>
                        <span class="small fw-bold">{{ $project->progress ?? 0 }}%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success rounded-pill" style="width: {{ $project->progress ?? 0 }}%"></div>
                    </div>
                </div>

                <div class="col-md-3 text-end pe-3">
                    <i class="bi bi-chevron-down transition-icon text-muted"></i>
                </div>
            </div>
        </button>

        {{-- B. Button Settings --}}
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

    {{-- 2. TASKS LIST --}}
    <div id="collapse-{{ $project->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $project->id }}">
        <div class="card-body bg-light border-top">

            <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                <h6 class="fw-bold text-primary mb-0">
                    <i class="bi bi-list-check me-2"></i>Task List ({{ $project->tasks->count() }})
                </h6>
            </div>
            <x-admin.projects.index.tasks-list :project="$project"/>
        </div>
    </div>
</div>

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

    </style>
@endpush
