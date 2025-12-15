<?php

namespace App\View\Components\Admin\DashBoard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InfoCard extends Component
{
    /**
     * Create a new component instance.
     */
    public string $title;
    public string $icon;
    public string $gradient;
    public $count;

    public function __construct(string $title, $count, string $icon, string $gradient)
    {
        $this->title = $title;
        $this->count = $count;
        $this->icon = $icon;
        $this->gradient = $gradient;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.dash-board.info-card');
    }
}
