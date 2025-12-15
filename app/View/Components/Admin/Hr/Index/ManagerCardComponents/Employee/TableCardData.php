<?php

namespace App\View\Components\Admin\Hr\Index\ManagerCardComponents\Employee;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableCardData extends Component
{
    /**
     * Create a new component instance.
     */
    public $id;
    public $name;
    public $email;
    public $phone;
    public $created_at;
    public function __construct($employee)
    {
        //
        $this->id = $employee->id;
        $this->name = $employee->name;
        $this->email = $employee->user->email;
        $this->phone = $employee->phone;
        $this->created_at = $employee->created_at;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.hr.index.manager-card-components.employee.table-card-data');
    }
}
