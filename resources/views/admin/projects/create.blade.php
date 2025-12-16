@extends('layouts.admin')

@section('title', 'Create New Project')
@section('page-title', 'Project Management')

@section('content')
    {{-- TOAST NOTIFICATION --}}
    @if(session('success'))
        <x-admin.hr.create.toast-success/>
    @endif

    {{-- MAIN CARD --}}
    <div class="card border-0 shadow-sm rounded-4">
        <x-admin.projects.create.header/>
        <div class="card-body p-4">
            <x-admin.projects.create.create-form :managers="$managers"/>
        </div>
    </div>

@endsection

