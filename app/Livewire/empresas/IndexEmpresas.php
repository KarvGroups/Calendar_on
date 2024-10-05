<?php

namespace App\Livewire\empresas;

use Livewire\Component;
use App\Models\Prestadores;


class IndexEmpresas extends Component
{
    public $prestadores;

    public function render()
    {
        $this->prestadores = Prestadores::all();
        return view('livewire.empresas.index-empresas');
    }
}
