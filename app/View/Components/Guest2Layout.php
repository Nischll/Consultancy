<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Guest2Layout extends Component
{
    public $profile;

    public function __construct($profile = null)
    {
        $this->profile = $profile;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.guest2', ['profile' => $this->profile]);
    }
}
