<?php

namespace App\View\Components\Admin\Hr\Create;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ManagerBox extends Component
{
    /**
     * Create a new component instance.
     */
    public $managers;
    public function __construct($managers)
    {
        //
        $this->managers = $managers;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.hr.create.manager-box');
    }
}
