<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Prestadores;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Models\Service;
use App\Models\Customers;
use App\Models\NonWorkingHours;
use App\Models\WorkSchedule;
use Carbon\Carbon;

class AgendamentoForm extends Component
{
    public $name;
    public $email;
    public $mobile;
    public $message;
    public $terms;

    public $users;
    public $categorys;
    public $services;
    public $company;
    public $check = 0;

    public $startDayOfMonth;
    public $currentMonth;
    public $currentYear;
    public $daysInMonth;
    public $selectedDay = null;
    public $hourMark = null;
    public $daySchedules = [];

    public $workDays = [];
    public $nonWorkingHours = [];

    public $scheduleInputs = [];
    public $selectedServicesSee = [];

    public $workSchedules = [];
    public $daysOfWeek = [
        'Segunda-feira',
        'Terça-feira',
        'Quarta-feira',
        'Quinta-feira',
        'Sexta-feira',
        'Sábado',
        'Domingo',
    ];
    public $fullyNonWorkingDays = [];

    public $selectedServices = [];

    public $selectedUser = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'mobile' => 'required|string|max:15',
        'message' => 'nullable|string|max:500',
        'terms' => 'accepted',
    ];

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

    public function submitForm()
    {
        $validatedData = $this->validate();

        $user = User::where("id",$this->selectedUser)->first();;

        $totalMinutes = 0;

        foreach ($this->selectedServicesSee as $selectedService) {
            $totalMinutes += $selectedService['time'];
        }

        $formattedTime = $this->hourMark . ':00';

        $hourMarkTime = Carbon::createFromFormat('H:i:s', $formattedTime);

        $hourMarkTime->addMinutes($totalMinutes);

        $finalTime = $hourMarkTime->format('H:i:s');

        $Customers = Customers::create([
            'name' => $validatedData["name"],
            'email' => $validatedData["email"],
            'mobile' => $validatedData["mobile"],
            'id_prestadores' => $this->company->id,
        ]);

        $event = Event::create([
            'title' =>"Agedamento online",
            'date' => $this->selectedDay,
            'start_time' => $formattedTime,
            'end_time' => $finalTime,
            'id_services' => json_encode($this->selectedServices),
            'user' => $user->apelido,
            'id_prestadores' => $this->company->id,
            'id_user' => $user->id,
        ]);

        session()->flash('message', 'Appointment scheduled successfully!');
        $this->reset(['name', 'email', 'mobile', 'message', 'terms']);
    }

    public function markHour($hour)
    {
        $this->hourMark = $hour;
        $this->selectedServicesSee = [];

        foreach( $this->selectedServices as $idServices){
            $services = Service::where('id_user', $this->selectedUser)->where('id', $idServices)->orderBy('order')->get()->toArray();;
            $this->selectedServicesSee = array_merge($this->selectedServicesSee, $services);

        }
    }
    public function gobackFomulario()
    {
        $this->hourMark = null;
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

            $schedules = WorkSchedule::where('user_id', $this->selectedUser)
                ->where('day_of_week', ucfirst($dayOfWeek))
                ->get();

            $this->daySchedules = [];
            foreach ($schedules as $schedule) {
                // Gera intervalos completos
                $intervals = $this->generateIntervals($schedule->start_time, $schedule->end_time);

                // Remove intervalos que estão dentro da pausa, se existir
                if ($schedule->pause_start && $schedule->pause_end) {
                    $pauseIntervals = $this->generateIntervals($schedule->pause_start, $schedule->pause_end);
                    $intervals = array_diff($intervals, $pauseIntervals);
                }

                $this->daySchedules = array_merge($this->daySchedules, $intervals);
            }

            // Obtém horas não trabalhadas da tabela NonWorkingHours
            $this->nonWorkingHours = NonWorkingHours::where('user_id', $this->selectedUser)
                ->where('date', $this->selectedDay)
                ->get()
                ->pluck('time')
                ->map(function ($time) {
                    return Carbon::createFromFormat('H:i:s', $time)->format('H:i');
                })
                ->toArray();
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
        $this->workSchedules = WorkSchedule::where('user_id', $this->selectedUser)->get()->toArray();

        foreach ($this->daysOfWeek as $day) {
            $existingSchedule = WorkSchedule::where('user_id', $this->selectedUser)
                ->where('day_of_week', $day)
                ->first();

            $this->scheduleInputs[$day] = [
                'start_time' => $existingSchedule ? Carbon::createFromFormat('H:i:s', $existingSchedule->start_time)->format('H:i') : '',
                'pause_start' => $existingSchedule && $existingSchedule->pause_start ? Carbon::createFromFormat('H:i:s', $existingSchedule->pause_start)->format('H:i') : '',
                'pause_end' => $existingSchedule && $existingSchedule->pause_end ? Carbon::createFromFormat('H:i:s', $existingSchedule->pause_end)->format('H:i') : '',
                'end_time' => $existingSchedule ? Carbon::createFromFormat('H:i:s', $existingSchedule->end_time)->format('H:i') : '',
                'enabled' => (bool) $existingSchedule,
            ];

            if ($existingSchedule) {
                $this->workDays[] = $day;
            }
        }
        $this->loadFullyNonWorkingDays();
    }
    public function loadFullyNonWorkingDays()
    {
        $this->fullyNonWorkingDays = NonWorkingHours::where('user_id', $this->selectedUser)
            ->whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->get()
            ->groupBy('date')
            ->filter(function ($hours, $date) {
                $dayOfWeek = Carbon::createFromFormat('Y-m-d', $date)->locale('pt_BR')->dayName;

                $workSchedules = WorkSchedule::where('user_id', $this->selectedUser)
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
