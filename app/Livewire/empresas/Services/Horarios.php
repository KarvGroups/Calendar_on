<?php

namespace App\Livewire\empresas\services;

use App\Models\NonWorkingHours;
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
    public $selectedDay = null;
    public $daySchedules = [];
    public $nonWorkingHours = [];

    public $workSchedules = [];
    public $newSchedule = [
        'day_of_week' => '',
        'start_time' => '',
        'end_time' => '',
    ];
    public $schedulesByDayOfWeek = [];
    public $fullyNonWorkingDays = [];
    

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadMonthData();

        $this->workSchedules = WorkSchedule::where('user_id', Auth::id())->get()->toArray();

        $this->schedulesByDayOfWeek = WorkSchedule::where('user_id', Auth::id())
            ->get()
            ->groupBy('day_of_week')
            ->toArray();

        $this->loadFullyNonWorkingDays();
    }
    public function loadFullyNonWorkingDays()
    {
        $this->fullyNonWorkingDays = NonWorkingHours::where('user_id', Auth::id())
            ->whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->get()
            ->groupBy('date')
            ->filter(function ($hours, $date) {
                $dayOfWeek = Carbon::createFromFormat('Y-m-d', $date)->locale('pt_BR')->dayName;

                $workSchedules = WorkSchedule::where('user_id', Auth::id())
                    ->where('day_of_week', ucfirst($dayOfWeek))
                    ->get();

                $daySchedules = [];
                foreach ($workSchedules as $schedule) {
                    $daySchedules = array_merge(
                        $daySchedules,
                        $this->generateIntervals($schedule->start_time, $schedule->end_time)
                    );
                }

                return count($daySchedules) > 0 && count($daySchedules) === $hours->count();
            })
            ->keys()
            ->toArray();
    }

    public function markAsNonWorkingHour($time)
    {
        if (!$this->selectedDay) {
            return;
        }

        if (in_array($time, $this->nonWorkingHours)) {
            NonWorkingHours::where('user_id', Auth::id())
                ->where('date', $this->selectedDay)
                ->where('time', Carbon::createFromFormat('H:i', $time)->format('H:i:s'))
                ->delete();

            $this->nonWorkingHours = array_filter($this->nonWorkingHours, function ($t) use ($time) {
                return $t !== $time;
            });
        } else {
            NonWorkingHours::create([
                'user_id' => Auth::id(),
                'date' => $this->selectedDay,
                'time' => Carbon::createFromFormat('H:i', $time)->format('H:i:s'),
            ]);

            $this->nonWorkingHours[] = $time;
        }
        $this->loadFullyNonWorkingDays();

    }
    public function markFullDay()
    {
        if (!$this->selectedDay || empty($this->daySchedules)) {
            return;
        }

        foreach ($this->daySchedules as $time) {
            if (!in_array($time, $this->nonWorkingHours)) {
                NonWorkingHours::create([
                    'user_id' => Auth::id(),
                    'date' => $this->selectedDay,
                    'time' => Carbon::createFromFormat('H:i', $time)->format('H:i:s'),
                ]);

                $this->nonWorkingHours[] = $time;
            }
        }

        $this->loadFullyNonWorkingDays();
    }

    public function unmarkFullDay()
    {
        if (!$this->selectedDay || empty($this->nonWorkingHours)) {
            return;
        }

        NonWorkingHours::where('user_id', Auth::id())
            ->where('date', $this->selectedDay)
            ->delete();

        $this->nonWorkingHours = [];

        $this->loadFullyNonWorkingDays();
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
    public function addSchedule()
    {
        $this->validate([
            'newSchedule.day_of_week' => 'required|string',
            'newSchedule.start_time' => 'required|date_format:H:i',
            'newSchedule.end_time' => 'required|date_format:H:i|after:newSchedule.start_time',
        ]);

        $schedule = WorkSchedule::create([
            'user_id' => Auth::id(),
            'day_of_week' => $this->newSchedule['day_of_week'],
            'start_time' => $this->newSchedule['start_time'],
            'end_time' => $this->newSchedule['end_time'],
        ]);

        $this->workSchedules[] = $schedule->toArray();

        $this->newSchedule = [
            'day_of_week' => '',
            'start_time' => '',
            'end_time' => '',
        ];
    }

    public function deleteSchedule($id)
    {
        $schedule = WorkSchedule::find($id);

        if ($schedule && $schedule->user_id == Auth::id()) {
            $schedule->delete();

            $this->workSchedules = array_filter($this->workSchedules, function ($schedule) use ($id) {
                return $schedule['id'] != $id;
            });
        }
    }

    public function selectDay($day)
    {
        $selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $day)->format('Y-m-d');

        if ($this->selectedDay === $selectedDate) {
            $this->selectedDay = null;
            $this->daySchedules = [];
            $this->nonWorkingHours = [];
        } else {
            $this->selectedDay = $selectedDate;

            $dayOfWeek = Carbon::create($this->currentYear, $this->currentMonth, $day)->locale('pt_BR')->dayName;

            $schedules = WorkSchedule::where('user_id', Auth::id())
                ->where('day_of_week', ucfirst($dayOfWeek))
                ->get();

            $this->daySchedules = [];
            foreach ($schedules as $schedule) {
                $intervals = $this->generateIntervals($schedule->start_time, $schedule->end_time);
                $this->daySchedules = array_merge($this->daySchedules, $intervals);
            }

            $this->nonWorkingHours = NonWorkingHours::where('user_id', Auth::id())
            ->where('date', $this->selectedDay)
            ->get()
            ->pluck('time')
            ->map(function ($time) {
                return \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('H:i');
            })
            ->toArray();

        }
    }

    private function generateIntervals($startTime, $endTime)
    {
        try {
            $start = Carbon::createFromFormat('H:i:s', $startTime);
            $end = Carbon::createFromFormat('H:i:s', $endTime);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao processar horários: {$startTime} ou {$endTime}. Detalhes: " . $e->getMessage());
        }

        $intervals = [];
        while ($start->lessThan($end)) {
            $intervals[] = $start->format('H:i'); // Certifique-se de retornar no formato correto
            $start->addMinutes(10);
        }

        return $intervals;
    }







    public function render()
    {
        return view('livewire.empresas.services.horarios');
    }
}
