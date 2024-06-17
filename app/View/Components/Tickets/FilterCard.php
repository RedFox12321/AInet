<?php

namespace App\View\Components\Tickets;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    /**
     * Create a new component instance.
     */
    public array $listTheaters;
    
    public function __construct(
        public string $filterAction,
        public string $resetUrl,
        public array $theaters,
        public ?string $searchField = null,
        public ?string $statusField = null,
        public ?string $theater = null,
        public ?string $placeHolder = '',
    ) {
        //
        $this->listTheaters=array_merge([null=>'Any Theater'], $theaters);

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tickets.filter-card');
    }
}
