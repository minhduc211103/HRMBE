@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="d-flex min-vh-100 bg-light">
        <div class="col-md-10 p-4" style="overflow-y: auto; height: 100vh;">
            <div class="row g-4">
                <x-admin.dash-board.info-card
                    title="Managers"
                    :count="$managers"
                    icon="bi bi-person-badge"
                    gradient="linear-gradient(45deg, #4e73df, #224abe)"
                />
                <x-admin.dash-board.info-card
                    title="Employees"
                    :count="$employees"
                    icon="bi bi-people-fill"
                    gradient="linear-gradient(45deg, #1cc88a, #13855c)"
                />
                <x-admin.dash-board.info-card
                    title="Active Projects"
                    :count="$projects"
                    icon="bi bi-folder-fill"
                    gradient="linear-gradient(45deg, #e74a3b, #be2617)"
                />

            </div>

            <x-admin.dash-board.empty-block/>
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
