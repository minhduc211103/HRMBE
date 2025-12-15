<?php

namespace App\View\Components\Admin\Hr\Index\ManagerCardComponents\Employee;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmployeesList extends Component
{
    /**
     * Create a new component instance.
     */
    public $manager;
    public function __construct($manager)
    {
        //
        $this->manager = $manager;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.hr.index.manager-card-components.employee.employees-list');
    }
}
