<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class Calendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $events = [];
    public $selectedDay;
    public $dayEvents = [];

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDay = null; // Nenhum dia selecionado inicialmente
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = Event::whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->get()
            ->groupBy(function ($event) {
                return Carbon::parse($event->date)->format('d'); // Agrupa por dia
            })
            ->toArray();
    }

    public function selectDay($day)
    {
        $dayKey = str_pad($day, 2, '0', STR_PAD_LEFT);

        $this->dayEvents = $this->events[$dayKey] ?? [];
        $this->selectedDay = $day;
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
        // Encontra o evento pelo ID e o exclui
        $event = Event::find($eventId);
        if ($event) {
            $event->delete();
            $this->loadEvents(); // Recarrega os eventos após a exclusão
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
