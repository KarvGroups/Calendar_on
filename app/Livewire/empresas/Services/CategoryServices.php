<?php

namespace App\Livewire\empresas\services;

use App\Models\Category;
use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CategoryServices extends Component
{

    public $services;
    public $categorys;


    public function mount()
    {
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
        $this->categorys = Category::where('id_user', Auth::user()->id)->orderBy('order')->get();
        $this->services = Service::where('id_user', Auth::user()->id)->orderBy('order')->get();
    }

    public function render()
    {
        return view('livewire.empresas.services.category', [
            'categorys' => $this->categorys,
            'services' => $this->services,
        ]);
    }
}
