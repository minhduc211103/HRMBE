@extends('layouts.admin')

@section('title', 'Project Management')
@section('page-title', 'Projects & Tasks')

@section('content')

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

                {{-- 1. PROJECT HEADER (PARENT ROW) --}}
                <div class="card-header bg-white p-0" id="heading-{{ $project->id }}">
                    <button class="btn btn-link w-100 text-decoration-none text-dark d-block p-3 text-start collapsed position-relative project-btn"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $project->id }}"
                            aria-expanded="false">

                        <div class="row align-items-center">
                            {{-- Cột 1: Tên Dự án & Icon --}}
                            <div class="col-md-4 d-flex align-items-center gap-3">
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

                            {{-- Cột 2: Manager Info --}}
                            <div class="col-md-3">
                                <small class="text-uppercase text-muted d-block" style="font-size: 0.65rem; font-weight: 700;">Project Manager</small>
                                <div class="d-flex align-items-center mt-1">
                                    @if($project->manager)
                                        <div class="bg-warning bg-opacity-25 text-warning rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 24px; height: 24px; font-size: 0.7rem;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <span class="fw-medium text-dark small">{{ $project->manager->name }}</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border">Unassigned</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Cột 3: Progress & Status --}}
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small fw-bold">Progress</span>
                                    <span class="small fw-bold">{{ $project->progress ?? 0 }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success rounded-pill" role="progressbar"
                                         style="width: {{ $project->progress ?? 0 }}%"></div>
                                </div>
                            </div>

                            {{-- Cột 4: Mũi tên --}}
                            <div class="col-md-1 text-end">
                                <i class="bi bi-chevron-down transition-icon text-muted"></i>
                            </div>
                        </div>
                    </button>
                </div>

                {{-- 2. TASKS LIST (CHILD ROW) --}}
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
{{--            Trường hợp chưa có project nào --}}
        @empty
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty" style="width: 80px; opacity: 0.5;" class="mb-3">
                <h5 class="text-muted">No Projects Found</h5>
                <p class="text-muted small">Start by creating a new project to track tasks.</p>
                <a href="#" class="btn btn-primary btn-sm">Create Project</a>
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
