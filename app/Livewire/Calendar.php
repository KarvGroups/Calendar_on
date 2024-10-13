<?php
namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $events = [];
    public $services = [];
    public $selectedService;
    public $selectedServices = [];
    public $selectedDay;
    public $dayEvents = [];
    public $isAddEventOpen = true;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDay = null;
        $this->loadEvents();
        $this->loadServices();
    }

    public function loadServices()
    {
        $this->services = Service::where('id_empresa', Auth::user()->id_prestadores)
            ->where('id_user', Auth::user()->id)->get();
    }

    public function loadEvents()
    {
        $this->events = Event::whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->get()
            ->groupBy(function ($event) {
                return Carbon::parse($event->date)->format('d');
            })
            ->toArray();
    }

    public function selectDay($day)
    {
        $dayKey = str_pad($day, 2, '0', STR_PAD_LEFT);

        $this->dayEvents = $this->events[$dayKey] ?? [];
        $this->selectedDay = $day;
    }

    public function addSelectedService()
    {
        if ($this->selectedService && !in_array($this->selectedService, $this->selectedServices)) {
            $this->selectedServices[] = $this->selectedService;
        }
        $this->isAddEventOpen = true;
        $this->selectedService = null;
    }

    public function toggleAddEvent()
    {
        $this->isAddEventOpen = !$this->isAddEventOpen;
    }

    public function previousMonth()
    {
        $this->currentMonth--;
        if ($this->currentMonth < 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        }
        $this->loadEvents();
        $this->selectedDay = null;
        $this->dayEvents = [];
    }

    public function nextMonth()
    {
        $this->currentMonth++;
        if ($this->currentMonth > 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        }
        $this->loadEvents();
        $this->selectedDay = null;
        $this->dayEvents = [];
    }

    public function today()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDay = now()->day;

        $this->selectDay($this->selectedDay);
        $this->loadEvents();
    }

    public function deleteEvent($eventId)
    {
        $event = Event::find($eventId);
        if ($event) {
            $event->delete();
            $this->loadEvents();
            $this->dayEvents = $this->events[str_pad($this->selectedDay, 2, '0', STR_PAD_LEFT)] ?? [];
        }
    }

    public function render()
    {
        $daysInMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->daysInMonth;
        $startDayOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->dayOfWeek;

        return view('livewire.calendar', compact('daysInMonth', 'startDayOfMonth'));
    }
}
