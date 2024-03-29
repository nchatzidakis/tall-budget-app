<?php

namespace App\View\Components\Theme\Layout;

use Illuminate\View\Component;
use Illuminate\View\View;

class Card extends Component
{
    public function __construct(
        public string $wrapper_css_class = '',
        public string $title = '',
    ) {
        //
    }

    public function render(): View
    {
        return view('components.theme.layout.card');
    }
}
