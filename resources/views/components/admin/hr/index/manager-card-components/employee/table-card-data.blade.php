<tr>
    <td class="ps-4">
        <div class="d-flex align-items-center">
            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 35px; height: 35px;">
                <span class="fw-bold small">{{ substr($name, 0, 1) }}</span>
            </div>
            <div>
                <div class="fw-bold">{{ $name }}</div>
                <small class="text-muted">ID: #{{ $id }}</small>
            </div>
        </div>
    </td>
    <td>
        <div class="small"><i class="bi bi-envelope me-1"></i> {{ $email }}</div>
        <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $phone ?? 'N/A' }}</div>
    </td>
    <td><span class="badge bg-success bg-opacity-10 text-success">Employee</span></td>
    <td>{{ $created_at->format('d M, Y')}}</td>

    {{-- Cột Button Bánh Răng Employee --}}
    <td class="text-end pe-4">
        <button class="btn btn-sm btn-light border rounded-circle text-muted"
                data-bs-toggle="modal"
                data-bs-target="#employeeSettingsModal-{{ $id }}">
            <i class="bi bi-gear-fill"></i>
        </button>
    </td>
</tr>
