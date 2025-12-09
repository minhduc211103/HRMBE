@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="d-flex min-vh-100">

        <!-- SIDEBAR -->
        <div class="col-2 bg-dark text-white p-3">
            <h5>ADMIN</h5>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/admin" class="nav-link text-white">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="/admin/users/create" class="nav-link text-white">➕ Thêm User</a>
                </li>
                <li class="nav-item">
                    <a href="/admin/users" class="nav-link text-white">📋 Danh sách User</a>
                </li>
            </ul>
        </div>

        <!-- CONTENT -->
        <div class="col-10 p-4">
            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard</h2>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm">Đăng xuất</button>
                </form>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5>Tổng User</h5>
                            <p>120</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
