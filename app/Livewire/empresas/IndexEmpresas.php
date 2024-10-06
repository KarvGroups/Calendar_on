<?php

namespace App\Livewire\empresas;

use Livewire\Component;
use App\Models\Prestadores;


class IndexEmpresas extends Component
{
    public $prestadores;

    public function edit($id)
    {
        return redirect()->route('empresas.edit', $id);
    }
    public function render()
    {
        $this->prestadores = Prestadores::all();
        return view('livewire.empresas.index-empresas');
    }
}
