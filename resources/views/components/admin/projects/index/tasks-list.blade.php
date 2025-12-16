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

@push('css')
    <style>
        /* Border nét đứt cho empty state */
        .border-dashed {
            border-style: dashed !important;
        }
    </style>
@endpush
