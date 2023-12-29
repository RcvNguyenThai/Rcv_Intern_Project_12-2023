<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{

    public string $rows;
    public string $cols;
    public string $name;
    public string $label;
    public string $placeholder;

    public string $error;
    /**
     * Create a new component instance.
     */
    public function __construct(string $rows, string $cols, string $name, string $label, string $placeholder, string $error = '')
    {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->error = $error;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.textarea');
    }
}
