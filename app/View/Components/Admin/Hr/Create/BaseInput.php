<?php

namespace App\View\Components\Admin\Hr\Create;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $label,
        public string $icon = 'bi bi-person',
        public string $type = 'text',
        public string $placeholder = '',
        public ?string $value = null,
        public string $wrapperClass = 'mb-3',
        public string $inputClass = ''
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.hr.create.base-input');
    }
}
