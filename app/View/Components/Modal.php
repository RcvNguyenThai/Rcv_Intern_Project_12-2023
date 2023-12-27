<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     */

    public string $title = "";
    public string $action = "";
    public string $method = "";
    public string $id = "";
    public function __construct(string $title = "", string $action = '', string $method = '', string $id = '')  
    {
        $this->title = $title;
        $this->action = $action;
        $this->method = $method;
        $this->id = $id;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
