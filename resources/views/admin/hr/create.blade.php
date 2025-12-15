@extends('layouts.admin')

@section('title', 'Create New User')
@section('page-title', 'Staff Management')

@section('content')

    {{-- TOAST NOTIFICATION --}}
    @if(session('success'))
        <x-admin.hr.create.toast-success/>
    @endif

    {{-- MAIN CARD --}}
    <div class="card border-0 shadow-sm rounded-4">
       <x-admin.hr.create.header/>

        <div class="card-body p-4">
            <x-admin.hr.create.main-form :managers="$managers"/>
        </div>
    </div>

@endsection


