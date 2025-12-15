@extends('layouts.admin')
@section('title', 'HR Management')
@section('page-title', 'Human Resources')
@section('content')

    {{-- HEADER & BUTTON --}}
    <x-admin.hr.index.header/>
    {{-- MAIN CONTENT: DANH SÁCH MANAGER --}}
    <div class="accordion" id="hrAccordion">
        @forelse($managers as $manager)
            <x-admin.hr.index.manager-card :manager="$manager"/>
            @empty
                <div class="alert alert-warning text-center">
                    No managers found. Please create a manager first.
                </div>
        @endforelse
    </div>
@endsection



