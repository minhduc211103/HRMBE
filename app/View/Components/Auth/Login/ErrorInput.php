<?php

namespace App\View\Components\Auth\Login;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ErrorInput extends Component
{
    /**
     * Create a new component instance.
     */
    public string $message;

    public function __construct($message = '')
    {
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.auth.login.error-input');
    }
}
