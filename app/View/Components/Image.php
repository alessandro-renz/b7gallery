<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Image extends Component
{
    public $id;
    public string $src;
    public string $title;
    public string $link;

    public function __construct($src, $title, $link, $id = null)
    {
        $this->id = $id;
        $this->src = $src;
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image');
    }
}
