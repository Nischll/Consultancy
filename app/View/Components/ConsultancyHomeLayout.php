<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ConsultancyHomeLayout extends Component
{
    public $profile;
    public $theme;

    public function __construct($profile = null, $theme = 'default')
    {
        $this->profile = $profile;
        $this->theme = $theme;
    }

    public function render(): View
    {
        return view('layouts.consultancy-home', [
            'profile' => $this->profile,
            'theme' => $this->theme
        ]);
    }
}
