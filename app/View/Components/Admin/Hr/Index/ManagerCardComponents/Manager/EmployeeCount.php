<?php

namespace App\View\Components\Admin\Hr\Index\ManagerCardComponents\Manager;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmployeeCount extends Component
{
    /**
     * Create a new component instance.
     */
    public $employeeCount ;
    public function __construct($employeeCount)
    {
        //
        $this->employeeCount = $employeeCount;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.hr.index.manager-card-components.manager.employee-count');
    }
}
