<?php

namespace App\Livewire;

use App\Models\Option;
use Livewire\Component;

class Email extends Component
{
    public $component;

    private function logo()
    {
        $option = Option::first();
        return view('livewire.logo', compact('option'));
    }

    private function thumb()
    {
        return view('livewire.email-thumb');
    }

    public function render()
    {
        if ($this->component == 'logo') {

            return $this->logo();

        } elseif ($this->component == 'thumb') {

            return $this->thumb();

        } else {

            return $this->logo();
        }
    }
}
