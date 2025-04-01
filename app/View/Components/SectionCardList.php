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
    public $listTitle, $cardBodyClass, $extra, $extraElement;

     public function __construct($listTitle,
                                 $cardBodyClass = "")
    {
        $this->listTitle = $listTitle;
        $this->cardBodyClass = $cardBodyClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.section-card-list');
    }
}
