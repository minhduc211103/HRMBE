<?php

namespace App\View\Components\Admin\Hr\Index\ManagerCardComponents\Employee;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmployeeModal extends Component
{
    /**
     * Create a new component instance.
     */
    public $employee;
    public function __construct($employee)
    {
        //
        $this->employee = $employee;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.hr.index.manager-card-components.employee.employee-modal');
    }
}
