<div id="collapse-{{ $manager->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $manager->id }}">
    <div class="card-body bg-light">

        @if($manager->employees->count() > 0)
            <div class="table-responsive bg-white rounded border">
                <table class="table table-hover align-middle mb-0">
                    <x-admin.hr.index.manager-card-components.employee.table-card-header/>
                    <tbody>
                    @foreach($manager->employees as $employee)
                        <x-admin.hr.index.manager-card-components.employee.table-card-data :employee="$employee"/>

                        {{-- === MODAL CHO EMPLOYEE  === --}}
                        <x-admin.hr.index.manager-card-components.employee.employee-modal :employee="$employee"/>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <i class="bi bi-people fs-1 d-block mb-2 opacity-50"></i>
                <p>No employees assigned to this manager yet.</p>
            </div>
        @endif
    </div>
</div>
