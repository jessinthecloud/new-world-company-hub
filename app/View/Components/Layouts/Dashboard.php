<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view( 'layouts.dashboard' );
    }
}