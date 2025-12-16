@extends('layouts.admin')

@section('title', 'Project Management')
@section('page-title', 'Projects & Tasks')

@section('content')
    {{-- TOAST NOTIFICATION --}}
    @if(session('success'))
        <x-admin.hr.create.toast-success/>
    @endif
    {{-- HEADER  --}}
   <x-admin.projects.index.header/>

    {{-- MAIN ACCORDION --}}
    <div class="accordion" id="projectAccordion">
        @forelse($projects as $project)
            <x-admin.projects.index.project-card :project="$project"/>
            {{-- MODAL PROJECT --}}
            <x-admin.projects.index.project-modal :project="$project"/>
        @empty
            {{-- Empty State --}}
            <div class="text-center py-5">
                <h5 class="text-muted">No Projects Found</h5>
            </div>
        @endforelse
    </div>
@endsection

