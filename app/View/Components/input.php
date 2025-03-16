<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component
{
    /**
     * Create a new component instance.
     */

    //  SET ATTRIBUTES
    public $name, $inputType, $label, $required;

    // FN CONSTRUCTOR
    public function __construct($name, $inputType, $label, $required)
    {
        $this->name = $name;
        $this->inputType = $inputType;
        $this->label = $label;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
