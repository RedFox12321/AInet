<?php

namespace App\View\Components\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuIcon extends Component
{
    /**
     * Create a new component instance.
     */

    public $href;

    public function __construct($href)
    {
        //
        $this->href=$href;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.menu-icon');
    }
}
