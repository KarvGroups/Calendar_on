<?php
namespace App\Livewire\empresas\services;

use App\Models\WorkSchedule;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Horarios extends Component
{
    public $currentMonth;
    public $currentYear;
    public $daysInMonth;
    public $startDayOfMonth;
    public $schedules = [];
    public $selectedDay;
    public $isWorking = true;
    public $start_time;
    public $end_time;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadMonthData();
        $this->loadSchedules();
    }

    public function loadMonthData()
    {
        $this->daysInMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->daysInMonth;
        $this->startDayOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->dayOfWeek;
    }

    public function loadSchedules()
    {
        // Carrega os horários do usuário autenticado
        $this->schedules = WorkSchedule::where('user_id', Auth::id())
            ->whereMonth('day_of_week', $this->currentMonth)
            ->whereYear('day_of_week', $this->currentYear)
            ->get()
            ->keyBy('day_of_week')
            ->toArray();
    }

    public function previousMonth()
    {
        $this->currentMonth--;
        if ($this->currentMonth < 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        }
        $this->loadMonthData();
        $this->loadSchedules();
    }

    public function nextMonth()
    {
        $this->currentMonth++;
        if ($this->currentMonth > 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        }
        $this->loadMonthData();
        $this->loadSchedules();
    }

    public function selectDay($day)
    {
        $this->selectedDay = Carbon::create($this->currentYear, $this->currentMonth, $day)->format('Y-m-d');

        // Verifica se já existe um horário para esse dia
        $existingSchedule = WorkSchedule::where('user_id', Auth::id())
            ->where('day_of_week', $this->selectedDay)
            ->first();

        if ($existingSchedule) {
            $this->start_time = $existingSchedule->start_time;
            $this->end_time = $existingSchedule->end_time;
            $this->isWorking = $existingSchedule->is_working;
        } else {
            $this->start_time = '';
            $this->end_time = '';
            $this->isWorking = true; // Por padrão, assume que vai trabalhar
        }
    }

    public function saveScheduleForDay()
    {
        $existingSchedule = WorkSchedule::where('user_id', Auth::id())
            ->where('day_of_week', $this->selectedDay)
            ->first();

        if ($existingSchedule) {
            $existingSchedule->update([
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'is_working' => $this->isWorking,
            ]);
        } else {
            WorkSchedule::create([
                'user_id' => Auth::id(),
                'day_of_week' => $this->selectedDay,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'is_working' => $this->isWorking,
            ]);
        }

        $this->loadSchedules();

        session()->flash('message', 'Horário atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.empresas.services.horarios');
    }
}
