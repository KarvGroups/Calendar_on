<?php

namespace App\Livewire\empresas\services;

use App\Models\Category;
use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CategoryServices extends Component
{
    public $status;
    public $title;
    public $GrupCategory;
    public $serviceTitle;
    public $servicePrice;
    public $serviceTime;
    public $selectedCategoryId;
    public $isEditingCategory = false;
    public $isEditingService = false;
    public $selectedServiceId;

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->GrupCategory = Category::where('id_empresa', Auth::user()->id_prestadores)
            ->where('id_user', Auth::user()->id)
            ->with('services')
            ->orderBy('order')
            ->get();
        // dd($this->GrupCategory);
    }

    public function createCategory()
    {
        $this->validate([
            'title' => 'required|string|max:250',
        ]);

        Category::create([
            'title' => $this->title,
            'id_user' => Auth::user()->id,
            'id_services' => null,
            'id_empresa' => Auth::user()->id_prestadores,
            'status' => 'active',
        ]);

        $this->title = '';
        $this->loadCategories();
    }
    public function createService()
    {
        $this->validate([
            'serviceTitle' => 'required|string|max:250',
            'servicePrice' => 'required|numeric',
            'serviceTime' => 'required',
            'selectedCategoryId' => 'required|exists:categorias,id',
        ]);

        Service::create([
            'title' => $this->serviceTitle,
            'price' => $this->servicePrice,
            'time' => $this->serviceTime,
            'status' => "active",
            'id_categorias' => $this->selectedCategoryId,
            'id_empresa' => Auth::user()->id_prestadores,
            'id_user' => Auth::user()->id,
        ]);

        $this->serviceTitle = '';
        $this->servicePrice = '';
        $this->serviceTime = '';
        $this->loadCategories();
    }

    public function editCategory($categoryId)
    {
        $this->cancelEditService();

        $this->isEditingCategory = true;
        $this->isEditingService = false;
        $this->selectedCategoryId = $categoryId;
        $category = Category::find($categoryId);
        $this->title = $category->title;
        $this->status = $category->status;
    }

    public function updateCategory()
    {
        $this->validate([
            'title' => 'required|string|max:250',
            'status' => 'required|string',
        ]);

        $category = Category::find($this->selectedCategoryId);
        $category->update([
            'title' => $this->title,
            'status' => $this->status,
        ]);

        $this->title = '';
        $this->status = '';
        $this->isEditingCategory = false;
        $this->loadCategories();
    }


    public function editService($serviceId)
    {
        $this->cancelEditCategory();

        $this->isEditingService = true;
        $this->isEditingCategory = false;
        $this->selectedServiceId = $serviceId;
        $service = Service::find($serviceId);
        $this->serviceTitle = $service->title;
        $this->servicePrice = $service->price;
        $this->serviceTime = $service->time;
        $this->status = $service->status;
    }


    public function updateService()
    {
        $this->validate([
            'serviceTitle' => 'required|string|max:250',
            'servicePrice' => 'required|numeric',
            'serviceTime' => 'required',
            'status' => 'required|string',
        ]);

        $service = Service::find($this->selectedServiceId);
        $service->update([
            'title' => $this->serviceTitle,
            'price' => $this->servicePrice,
            'time' => $this->serviceTime,
            'status' => $this->status,
        ]);

        $this->serviceTitle = '';
        $this->servicePrice = '';
        $this->serviceTime = '';
        $this->status = '';
        $this->isEditingService = false;
        $this->loadCategories();
    }

    public function cancelEditService()
    {
        $this->isEditingService = false;
        $this->selectedServiceId = null;
        $this->serviceTitle = '';
        $this->servicePrice = '';
        $this->serviceTime = '';
    }

    public function cancelEditCategory()
    {
        $this->isEditingCategory = false;
        $this->selectedCategoryId = null;
        $this->title = '';
    }

    public function deleteCategory($categoryId)
{
    $category = Category::find($categoryId);

    if ($category) {
        $category->services()->delete();

        $category->delete();

        session()->flash('success', 'Categoria e seus serviços foram deletados com sucesso.');
    } else {
        session()->flash('error', 'Categoria não encontrada.');
    }

    $this->loadCategories();
}
public function deleteService($serviceId)
{
    $service = Service::find($serviceId);

    if ($service) {
        $service->delete();

        session()->flash('success', 'Serviço deletado com sucesso.');
    } else {
        session()->flash('error', 'Serviço não encontrado.');
    }

    $this->loadCategories();
}


    public function render()
    {
        return view('livewire.empresas.services.category');
    }
}
