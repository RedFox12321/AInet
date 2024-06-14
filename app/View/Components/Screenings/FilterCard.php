<?php

namespace App\View\Components\Screenings;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class FilterCard extends Component
{
    /**
     * Create a new component instance.
     */

    public array $listTheaters;
    public array $listGenres;
    public array $listDates;

    public function __construct(

        public string $filterAction,
        public string $resetUrl,
        public array $theaters,
        public array $genres,
        public ?string $title = null,
        public ?string $theater = null,
        public ?string $genre = null,
        public ?string $date = null,
    ) {
        $this->listTheaters = array_merge([null => 'Any Theater'], $theaters);
        $this->listGenres = array_merge([null => 'Any Genre'], $genres);
        $this->listDates = [
            null => 'Any Date',
            1 => 'Today',
            2 => 'Tomorrow',
            3 => 'This week'
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.screenings.filter-card');
    }
}
