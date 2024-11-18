<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Prestadores;
use App\Models\User;


class AgendamentoForm extends Component
{
    public $users;
    public $company;
    public $selectedUser = null;

    public function mount($users)
    {
        $this->users = User::where("id_prestadores",$users->id_prestadores)->get();
        $this->company = Prestadores::where("id",$users->id_prestadores)->get();

    }

    public function selectUser($userId)
    {
        $this->selectedUser = $userId;
    }

    public function render()
    {
        return view('livewire.agendamento-form');
    }
}
