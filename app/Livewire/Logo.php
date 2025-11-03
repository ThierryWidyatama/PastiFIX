<?php

namespace App\Livewire;

use App\Models\Option;
use Livewire\Component;

class Logo extends Component
{
    public function render()
    {
        $option = Option::first();
        $route_home = $option->is_landing_page == '1' ? 'home' : 'login';
        return view('livewire.logo', compact('option' , 'route_home'));
    }
}
