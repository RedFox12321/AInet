<?php

namespace App\View\Components\Seats;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    /**
     * Create a new component instance.
     */

    public function __construct(
        public string $filterAction,
        public string $resetUrl,
        public array $theaters,
        public ?string $theater = null,
    )
    {
        //

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.seats.filter-card');
    }
}
