<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */

    public string $icon;
    public string $class;
    public string $type;
    public string $id;

    public string $modalID;

    public function __construct(string $icon = '', string $class = '', string $type = '', string $modalID = '', string $id = '')
    {
        $this->icon = $icon;
        $this->class = $class;
        $this->type = $type;
        $this->modalID = $modalID;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.button');
    }
}
