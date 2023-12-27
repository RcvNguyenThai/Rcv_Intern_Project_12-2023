<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $label;

    public $name;

    public $type;

    public $placeholder;
    public $value;

    public $error;

    public function __construct(string $label = ''
        , string $name = '', string $type = 'text', string $placeholder = '',  $value = '', string $error = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->type = $type ?? 'text';
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->error = $error;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.input');
    }
}
