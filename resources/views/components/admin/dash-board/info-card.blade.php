<div class="col-md-4">
    <div class="card border-0 shadow h-100 text-white"
         style="background: {{ $gradient }};">
        <div class="card-body d-flex align-items-center p-4">
            <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3 text-white">
                <i class="{{ $icon }} fs-3"></i>
            </div>
            <div>
                <h6 class="text-uppercase mb-1 small fw-bold opacity-75">{{ $title }}</h6>
                <h3 class="mb-0 fw-bold">{{ is_countable($count) ? count($count) : $count }}</h3>
            </div>
        </div>
    </div>
</div>
