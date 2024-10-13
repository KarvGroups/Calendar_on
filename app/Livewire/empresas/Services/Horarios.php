<?php

namespace App\Livewire\empresas\services;

use App\Models\WorkSchedule;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Horarios extends Component
{
    public $daysOfWeek = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'];
    public $schedules = [];
    public $newSchedule = [
        'day_of_week' => '',
        'start_time' => '',
        'end_time' => ''
    ];

    public function mount()
    {
        $this->schedules = WorkSchedule::where('user_id', Auth::id())->get()->toArray();
    }

    public function addSchedule()
    {
        $this->validate([
            'newSchedule.day_of_week' => 'required',
            'newSchedule.start_time' => 'required|date_format:H:i',
            'newSchedule.end_time' => 'required|date_format:H:i|after:newSchedule.start_time',
        ]);

        $this->schedules[] = $this->newSchedule;

        // Limpar o formulário
        $this->newSchedule = [
            'day_of_week' => '',
            'start_time' => '',
            'end_time' => ''
        ];
    }

    public function saveSchedules()
    {
        foreach ($this->schedules as $schedule) {
            WorkSchedule::create([
                'user_id' => Auth::id(),
                'day_of_week' => $schedule['day_of_week'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
            ]);
        }

        session()->flash('message', 'Horários salvos com sucesso!');
    }

    public function render()
    {
        return view('livewire.empresas.services.horarios');
    }
}
