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

    public $selectedServiceData = [
        'id' => null,
        'title' => '',
        'price' => '',
        'time' => '',
        'status' => '',
        'id_categorias' => '',
    ];

    public $selectedCategoryData = [
        'id' => null,
        'title' => '',
        'status' => '',
    ];

    public $newCategory = [
        'title' => '',
        'status' => 'active',
    ];
    public $newService = [
        'title' => '',
        'price' => '',
        'time' => '',
        'status' => 'active',
        'id_categorias' => 0,
        'id_user' => '',
    ];


    public $categories;

    public function mount()
    {
        $this->categories = Category::where('id_user', Auth::id())->get();

        if(Auth::user()->nivel == 0){
            $this->usuarios = User::where('id_prestadores',Auth::user()->id_prestadores)->get();
        }else{
            $this->usuarios = collect([Auth::user()]);
        }
        $this->userSelect = Auth::user()->id;
        $this->loadItens();
    }

    public function updateService()
    {
        $this->validate([
            'selectedServiceData.title' => 'required|string|max:255',
            'selectedServiceData.price' => 'required|numeric|min:0',
            'selectedServiceData.time' => 'required|numeric|min:1',
            'selectedServiceData.status' => 'required|in:active,inactive',
            'selectedServiceData.id_categorias' => 'required|exists:categories,id',
        ]);

        $service = Service::find($this->selectedServiceData['id']);

        if ($service) {
            $service->update([
                'title' => $this->selectedServiceData['title'],
                'price' => $this->selectedServiceData['price'],
                'time' => $this->selectedServiceData['time'],
                'status' => $this->selectedServiceData['status'],
                'id_categorias' => $this->selectedServiceData['id_categorias'],
            ]);

            $this->dispatch('closeModal', ['modalId' => 'ModalEditService']);
            $this->loadItens();
            session()->flash('message', 'Serviço atualizado com sucesso!');
        }
    }

        public function editService($serviceId)
    {
        $service = Service::find($serviceId);

        if ($service) {
            $this->selectedServiceData = [
                'id' => $service->id,
                'title' => $service->title,
                'price' => $service->price,
                'time' => $service->time,
                'status' => $service->status,
                'id_categorias' => $service->id_categorias,
            ];
        }

        $this->dispatch('openModal', ['modalId' => 'ModalEditService']);
    }


    public function addCategory()
    {
        $this->validate([
            'newCategory.title' => 'required|string|max:255',
            'newCategory.status' => 'required|in:active,inactive',
        ]);

        $user = User::where("id",$this->userSelect)->get();

        $maxOrder = Category::where('id_user', $user[0]->id)
            ->max('order');

        $newOrder = $maxOrder !== null ? $maxOrder + 1 : 1;

        Category::create([
            'title' => $this->newCategory['title'],
            'status' => $this->newCategory['status'],
            'id_empresa' => $user[0]->id_prestadores,
            'id_user' => $user[0]->id,
            'order' => $newOrder,

        ]);

        $this->loadItens();

        $this->reset('newCategory');
        $this->dispatch('closeModal', ['modalId' => 'ModalAddCategory']);
    }

    public function addService()
    {

        $this->validate([
            'newService.title' => 'required|string|max:255',
            'newService.price' => 'required|numeric|min:0',
            'newService.time' => 'required|numeric|min:1',
            'newService.status' => 'required|in:active,inactive',
            'newService.order' => 'required|numeric|min:0',
        ]);
        $user = User::where("id",$this->userSelect)->get();

        $maxOrder = Service::where('id_categorias', $this->newService['id_categorias'])
            ->where('id_user', $user[0]->id)
            ->max('order');
        $newOrder = $maxOrder !== null ? $maxOrder + 1 : 1;



        Service::create([
            'title' => $this->newService['title'],
            'price' => $this->newService['price'],
            'time' => $this->newService['time'],
            'status' => $this->newService['status'],
            'order' => $newOrder,
            'id_categorias' => $this->newService['id_categorias'],
            'id_empresa' => $user[0]->id_prestadores,
            'id_user' => $user[0]->id,
        ]);


        $this->reset('newService');
        $this->dispatchBrowserEvent('closeModal', ['modalId' => 'ModalAddService']);
        session()->flash('message', 'Serviço adicionado com sucesso!');
    }


    public function editCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if ($category) {
            $this->selectedCategoryData = [
                'id' => $category->id,
                'title' => $category->title,
                'status' => $category->status,
            ];
        }
        $this->loadItens();

        $this->dispatch('openModalEditServices');
    }

    public function updateCategory()
    {
        $this->validate([
            'selectedCategoryData.title' => 'required|string|max:255',
            'selectedCategoryData.status' => 'required|in:active,inactive',
        ]);

        $category = Category::find($this->selectedCategoryData['id']);

        if ($category) {
            $category->update([
                'title' => $this->selectedCategoryData['title'],
                'status' => $this->selectedCategoryData['status'],
            ]);
            $this->dispatch('closeModalEditServices');
            $this->loadItens();
            session()->flash('message', 'Categoria atualizada com sucesso!');
        }
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
            'selectedCategoryData' => $this->selectedCategoryData,
        ]);
    }
}
