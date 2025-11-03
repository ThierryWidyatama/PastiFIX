<?php

namespace App\Livewire;

use App\Models\Session;
use Livewire\Component;

class ShowPayload extends Component
{
    public $session_id;
    public $showModal = false;

    public function show($id)
    {
        $this->session_id = $id;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        $data_payload = [];
        if ($this->session_id) {
            $data = Session::find($this->session_id);
            if ($data) {
                $data_payload = unserialize(base64_decode($data->payload));
            }
        }

        return view('livewire.show-payload', [
            'id' => $this->session_id,
            'data_payload' => $data_payload,
            'showModal' => $this->showModal,
        ]);
    }
}
