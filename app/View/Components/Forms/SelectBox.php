<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectBox extends Component
{
    public $options;
    public $selected;

    public $title;

    public $name;

    public $isForm;

    public string $defaultValue;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($options = [], $selected = null, $title = '', $name = '', $isForm = false, $defaultValue = '')
    {
        $this->options = $options;
        $this->selected = $selected;
        $this->title = $title;
        $this->name = $name;
        $this->isForm = $isForm;
        $this->defaultValue = $defaultValue;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.select-box');
    }
}
