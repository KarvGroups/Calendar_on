<?php

namespace App\Livewire\empresas\services;

use App\Models\Category;
use App\Models\User;
use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CategoryServices extends Component
{

    public $services;
    public $categorys;
    public $usuarios;
    public $userSelect;
    public $categoriasSelect;



    public function mount()
    {
        if(Auth::user()->nivel == 0){
            $this->usuarios = User::where('id_prestadores',Auth::user()->id_prestadores)->get();
        }else{
            $this->usuarios = collect([Auth::user()]);
        }
        $this->userSelect = Auth::user()->id;
        $this->loadItens();
    }
    public function selectThisUser($id)
    {
       $this->userSelect = $id;
       $this->loadItens();
    }
    public function updateOrder($order)
    {
        foreach ($order as $index => $serviceId) {
            Service::where('id', $serviceId)->update(['order' => $index + 1]);
        }
        $this->loadItens();
    }

    public function loadItens()
    {
        $this->categorys = Category::where('id_user', $this->userSelect)->orderBy('order')->get();
        $this->services = Service::where('id_user', $this->userSelect)->orderBy('order')->get();
    }

    public function render()
    {
        return view('livewire.empresas.services.category', [
            'categorys' => $this->categorys,
            'services' => $this->services,
            'usuarios' => $this->usuarios,
            'userSelect' => $this->userSelect,
        ]);
    }
}
