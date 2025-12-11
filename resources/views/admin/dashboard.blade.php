@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="d-flex min-vh-100 bg-light">
        <div class="col-md-10 p-4" style="overflow-y: auto; height: 100vh;">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow h-100 text-white"
                         style="background: linear-gradient(45deg, #4e73df, #224abe);"> <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3 text-white">
                                <i class="bi bi-person-badge fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase mb-1 small fw-bold opacity-75">Managers</h6>
                                <h3 class="mb-0 fw-bold">{{ is_countable($managers) ? count($managers) : $managers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow h-100 text-white"
                         style="background: linear-gradient(45deg, #1cc88a, #13855c);"> <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3 text-white">
                                <i class="bi bi-people-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase mb-1 small fw-bold opacity-75">Employees</h6>
                                <h3 class="mb-0 fw-bold">{{ is_countable($employees) ? count($employees) : $employees }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow h-100 text-white"
                         style="background: linear-gradient(45deg, #e74a3b, #be2617);"> <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3 text-white">
                                <i class="bi bi-folder-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase mb-1 small fw-bold opacity-75">Active Projects</h6>
                                <h3 class="mb-0 fw-bold">{{ is_countable($projects) ? count($projects) : $projects }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom border-2 border-primary">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-clock-history me-2"></i> Recent Activities
                        </h5>
                    </div>
                    <div class="card-body text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                        <p>No recent activities found.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Hiệu ứng hover cho Card thống kê */
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px); /* Nổi lên nhẹ khi di chuột vào */
        }
    </style>
@endsection
