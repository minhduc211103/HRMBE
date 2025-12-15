<?php

namespace App\View\Components\Admin\Hr\Index\ManagerCardComponents\Manager;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ManagerInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public $name ;
    public $email ;
    public function __construct($name , $email)
    {
        //
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.hr.index.manager-card-components.manager.manager-info');
    }
}
