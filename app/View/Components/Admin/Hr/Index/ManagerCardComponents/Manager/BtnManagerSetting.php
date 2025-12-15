<?php

namespace App\View\Components\Admin\Hr\Index\ManagerCardComponents\Manager;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BtnManagerSetting extends Component
{
    /**
     * Create a new component instance.
     */
    public $id ;
    public function __construct($id)
    {
        //
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.hr.index.manager-card-components.manager.btn-manager-setting');
    }
}
