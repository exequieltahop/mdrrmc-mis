<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SectionCardList extends Component
{
    /**
     * Create a new component instance.
     */
    public $listTitle;

     public function __construct($listTitle)
    {
        $this->listTitle = $listTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.section-card-list');
    }
}
