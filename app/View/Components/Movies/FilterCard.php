<?php

namespace App\View\Components\Movies;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    /**
     * Create a new component instance.
     */

     public array $listGenres;

     public function __construct(
     
        
         public string $filterAction,
         public string $resetUrl,
         public array $genres,
         public ?string $title = null,
         public ?string $genre = null,
     )
     {
         $this->listGenres=array_merge([null=>'Any Genre'], $genres);
     }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movies.filter-card');
    }
}
