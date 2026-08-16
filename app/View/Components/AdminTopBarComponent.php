<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminTopBarComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $fname = '',
        public ?string $lname = '',
        public ?string $email = '',
    )
    {
        $this->fname = $fname ?? '';
        $this->lname = $lname ?? '';
        $this->email = $email ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-top-bar-component');
    }
}
