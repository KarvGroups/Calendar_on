<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Prestadores;
use App\Models\User;
use App\Models\Category;
use App\Models\Service;
use App\Models\NonWorkingHours;
use App\Models\WorkSchedule;
use Carbon\Carbon;

class AgendamentoForm extends Component
{
    public $users;
    public $categorys;
    public $services;
    public $company;
    public $check = 0;

    public $startDayOfMonth;
    public $currentMonth;
    public $currentYear;
    public $daysInMonth;
    public $workDays = [];


    public $selectedServices = [];

    public $selectedUser = null;

    public function mount($users, $company)
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadMonthData();

        if($company == null){
            $this->users = User::where("id_prestadores",$users->id_prestadores)->get();
            $this->company = Prestadores::where("id",$users->id_prestadores)->get();
        }else{
            $this->users = $users;
            $this->company = $company;
        }
    }
    public function loadMonthData()
    {
        $this->daysInMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->daysInMonth;
        $this->startDayOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->dayOfWeek;
    }
    public function previousMonth()
    {
        $this->currentMonth--;
        if ($this->currentMonth < 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        }
        $this->loadMonthData();
    }

    public function nextMonth()
    {
        $this->currentMonth++;
        if ($this->currentMonth > 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        }
        $this->loadMonthData();
    }
    public function goback()
    {
        $this->selectedUser = null;
        $this->categorys = null;
        $this->services = null;
    }

    public function selectUser($userId)
    {
        $this->selectedUser = $userId;
        $this->categorys = Category::where('id_user', $this->selectedUser)->orderBy('order')->whereHas('services')->get();
        $this->services = Service::where('id_user', $this->selectedUser)->orderBy('order')->get();
    }

    public function toggleServiceSelection($serviceId)
    {
        if (in_array($serviceId, $this->selectedServices)) {
            $this->selectedServices = array_diff($this->selectedServices, [$serviceId]);
        } else {
            $this->selectedServices[] = $serviceId;
        }
    }

    public function checkSelects()
    {
        $this->check = 1;
    }

    public function gobackCalendar()
    {
        $this->check = 0;
    }

    public function render()
    {
        return view('livewire.agendamento-form', [
            'selectedServices' => $this->selectedServices,
        ]);
    }
}
