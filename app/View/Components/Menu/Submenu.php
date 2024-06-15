<?php

namespace App\View\Components\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Submenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $content = 'Submenu',
    ) {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.submenu');
    }
}