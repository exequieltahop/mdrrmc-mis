<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Create a new component instance.
     */

    public $ths, $tableId, $tbodyId, $tableClass;

    public function __construct($ths, $tableId = '', $tbodyId = '', $tableClass = '')
    {
        $this->ths = $ths;
        $this->tableId = $tableId;
        $this->tbodyId = $tbodyId;
        $this->tableClass = $tableClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
