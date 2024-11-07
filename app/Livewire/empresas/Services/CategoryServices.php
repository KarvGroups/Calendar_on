<?php

namespace App\Livewire\empresas\services;

use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CategoryServices extends Component
{
    protected $listeners = ['ServiceOrder'];
    public $serviceTitle;
    public $servicePrice;
    public $serviceTime;
    public $status = 'active';

    public $isEditingService = false;
    public $selectedServiceId = null;
    public $services;
    public $orderedIds;
    public $sublistOrderedIds = [];



    public function mount()
    {
        $this->loadServices();
        $this->orderedIds = implode(',', $this->services->pluck('id')->toArray());
    }

    public function loadServices()
    {
        $this->services = Service::where('id_user', Auth::user()->id)->orderBy('order')->get();
    }
    public function ServiceOrder()
{
    $orderedIds = explode(',', $this->orderedIds);
    foreach ($orderedIds as $index => $id) {
        $service = Service::find($id);
        if ($service && $service->order_int == 0) {
            $service->order = $index + 1;
            $service->save();
        }
    }
    foreach ($this->sublistOrderedIds as $parentId => $orderedIds) {
        $subOrderedIds = explode(',', $orderedIds);
        foreach ($subOrderedIds as $index => $id) {
            $service = Service::find($id);
            if ($service && $service->order_int == $parentId) {
                $service->order = $index + 1;
                $service->save();
            }
        }
    }

    $this->loadServices();
    $this->message = "Ordem salva com sucesso!";
    $this->dispatch('alert', ['type' => 'success', 'message' => $this->message]);
}



    public function updateHierarchy($serviceId, $newParentId)
    {
        $service = Service::find($serviceId);

        if ($service) {
            $service->order_int = ($newParentId == 0) ? 0 : $newParentId;

            if ($newParentId == 0) {
                $maxOrder = Service::where('id_user', Auth::user()->id)->where('order_int', 0)->max('order');
                $service->order = $maxOrder + 1;
            } else {
                $maxOrderInParent = Service::where('id_user', Auth::user()->id)->where('order_int', $newParentId)->max('order');
                $service->order = $maxOrderInParent + 1;
            }

            $service->save();
        }
        $this->ServiceOrder();

        // $this->loadServices();
    }

    public function createService()
    {
        $this->validate([
            'serviceTitle' => 'required|string|max:250',
            'servicePrice' => 'required|numeric',
            'serviceTime' => 'required|integer',
        ]);

        Service::create([
            'title' => $this->serviceTitle,
            'price' => $this->servicePrice,
            'time' => $this->serviceTime,
            'status' => $this->status,
            'id_empresa' => Auth::user()->id_prestadores,
            'id_user' => Auth::user()->id,
            'order' => Service::where('id_user', Auth::user()->id)->max('order') + 1,
        ]);

        $this->resetForm();
        $this->loadServices();
        $this->message = "Serviço criado com sucesso.";
        $this->dispatch('alert', ['type' => 'success', 'message' => $this->message]);
    }

    public function editService($serviceId)
    {
        $this->cancelEditService();

        $this->isEditingService = true;
        $this->selectedServiceId = $serviceId;

        $service = Service::find($serviceId);
        if ($service) {
            $this->serviceTitle = $service->title;
            $this->servicePrice = $service->price;
            $this->serviceTime = $service->time;
            $this->status = $service->status;
        }
    }

    public function updateService()
    {
        $this->validate([
            'serviceTitle' => 'required|string|max:250',
            'servicePrice' => 'required|numeric',
            'serviceTime' => 'required|integer',
            'status' => 'required|string',
        ]);

        $service = Service::find($this->selectedServiceId);
        if ($service) {
            $service->update([
                'title' => $this->serviceTitle,
                'price' => $this->servicePrice,
                'time' => $this->serviceTime,
                'status' => $this->status,
            ]);

            $this->resetForm();
            $this->loadServices();
            session()->flash('success', 'Serviço atualizado com sucesso.');
        }
    }

    public function deleteService($serviceId)
    {
        $service = Service::find($serviceId);
        if ($service) {
            $service->delete();
            session()->flash('success', 'Serviço deletado com sucesso.');
            $this->loadServices();
        } else {
            session()->flash('error', 'Serviço não encontrado.');
        }
    }

    public function cancelEditService()
    {
        $this->resetForm();
        $this->isEditingService = false;
        $this->selectedServiceId = null;
    }

    private function resetForm()
    {
        $this->serviceTitle = '';
        $this->servicePrice = '';
        $this->serviceTime = '';
        $this->status = 'active';
    }

    public function render()
    {
        return view('livewire.empresas.services.category', [
            'services' => $this->services,
        ]);
    }
}
