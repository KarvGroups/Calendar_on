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
    public $selectedDays = [];

    public $workBlocks = [
        ['start_time' => '', 'end_time' => ''],
    ];

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
    public function addWorkBlock()
    {
        $this->workBlocks[] = ['start_time' => '', 'end_time' => ''];
    }
    public function loadSchedules()
    {
        $this->schedules = WorkSchedule::where('user_id', Auth::id())
            ->whereMonth('day_of_week', $this->currentMonth)
            ->whereYear('day_of_week', $this->currentYear)
            ->get()
            ->groupBy('day_of_week')
            ->toArray();
    }
    public function deleteSelectedDays()
    {
        foreach ($this->selectedDays as $selectedDay) {
            WorkSchedule::where('user_id', Auth::id())
                ->where('day_of_week', $selectedDay)
                ->delete();
        }
        $this->selectedDays = [];

        $this->loadSchedules();
        session()->flash('message', 'Horários deletados com sucesso para os dias selecionados!');
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
        $selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $day)->format('Y-m-d');

        if (in_array($selectedDate, $this->selectedDays)) {

            $this->selectedDays = array_diff($this->selectedDays, [$selectedDate]);
        } else {
            $this->selectedDays[] = $selectedDate;
        }
    }


    public function saveScheduleForDay()
{
    foreach ($this->selectedDays as $selectedDay) {
        foreach ($this->workBlocks as $index => $block) {
            $existingSchedule = WorkSchedule::where('user_id', Auth::id())
                ->where('day_of_week', $selectedDay)
                ->where('schedule_block', $index + 1)
                ->first();

            if ($existingSchedule) {
                $existingSchedule->update([
                    'start_time' => $block['start_time'],
                    'end_time' => $block['end_time'],
                    'is_working' => $this->isWorking,
                ]);
            } else {
                WorkSchedule::create([
                    'user_id' => Auth::id(),
                    'day_of_week' => $selectedDay,
                    'start_time' => $block['start_time'],
                    'end_time' => $block['end_time'],
                    'is_working' => $this->isWorking,
                    'schedule_block' => $index + 1,
                ]);
            }
        }
    }

    $this->loadSchedules();

    session()->flash('message', 'Horários atualizados com sucesso para os dias selecionados!');
}


    public function render()
    {
        return view('livewire.empresas.services.horarios');
    }
}
