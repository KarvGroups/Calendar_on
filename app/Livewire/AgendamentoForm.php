<?php

namespace App\Livewire;

use Livewire\Component;

class AgendamentoForm extends Component
{
    public $users;     // Lista de usuários
    public $company;   // Empresa atual
    public $selectedUser = null;

    // O método mount recebe os usuários e a empresa quando o componente é carregado
    public function mount($users, $company)
    {
        $this->users = $users;
        $this->company = $company;
    }

    public function selectUser($userId)
    {
        // Definir o usuário selecionado
        $this->selectedUser = $userId;
    }

    public function render()
    {
        return view('livewire.agendamento-form');
    }
}
