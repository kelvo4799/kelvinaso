<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminSideBarComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        //public array $values = []
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-side-bar-component');
    }
}
