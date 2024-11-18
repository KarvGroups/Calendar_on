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

    protected $listeners = ['updateCategoryOrder', 'updateServiceOrder'];

    public function updateCategoryOrder($orderedIds)
    {
        dd($orderedIds);

        foreach ($orderedIds as $index => $id) {
            Category::where('id', $id)
                ->update(['order' => $index + 1]);
        }

        $this->loadCategories();
    }

    public function updateServiceOrder($categoryId, $orderedIds)
    {
        dd($categoryId, $orderedIds);
        foreach ($orderedIds as $index => $id) {
            Service::where('id', $id)
                ->update(['order' => $index + 1, 'id_categoria' => $categoryId]);
        }

        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->GrupCategory = Category::where('id_empresa', Auth::user()->id_prestadores)
            ->with(['services' => function ($query) {
                $query->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
    }

    public function render()
    {
        return view('livewire.empresas.services.category');
    }
}
