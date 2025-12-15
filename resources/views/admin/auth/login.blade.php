@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-lg border-0" style="width: 100%; max-width: 420px;">
            <!-- HEADER -->
            <x-auth.login.header/>
            <!-- BODY -->
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.login') }}" novalidate>
                    @csrf
                    <!-- USERNAME -->
                    <x-auth.login.username-input />
                    <!-- PASSWORD -->
                    <x-auth.login.password-input />
                    <!-- BUTTON -->
                    <x-auth.login.button-login />
                </form>
            </div>
        </div>
    </div>
@endsection
