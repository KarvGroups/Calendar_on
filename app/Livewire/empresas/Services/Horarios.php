<?php

namespace App\Livewire\empresas\services;

use App\Models\WorkSchedule;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Horarios extends Component
{
    public $workSchedules = [];
    public $newSchedule = [
        'day_of_week' => '',
        'start_time' => '',
        'end_time' => '',
    ];

    public function mount()
    {
        // Carrega os horários do usuário autenticado
        $this->workSchedules = WorkSchedule::where('user_id', Auth::id())->get()->toArray();
    }

    public function addSchedule()
    {
        // Validação simples
        $this->validate([
            'newSchedule.day_of_week' => 'required|string',
            'newSchedule.start_time' => 'required|date_format:H:i',
            'newSchedule.end_time' => 'required|date_format:H:i|after:newSchedule.start_time',
        ]);

        // Cria o horário e salva no banco
        $schedule = WorkSchedule::create([
            'user_id' => Auth::id(),
            'day_of_week' => $this->newSchedule['day_of_week'],
            'start_time' => $this->newSchedule['start_time'],
            'end_time' => $this->newSchedule['end_time'],
        ]);

        // Atualiza a lista de horários
        $this->workSchedules[] = $schedule->toArray();

        // Limpa o formulário
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
            // Atualiza a lista de horários
            $this->workSchedules = array_filter($this->workSchedules, function ($schedule) use ($id) {
                return $schedule['id'] != $id;
            });
        }
    }

    public function render()
    {
        return view('livewire.empresas.services.horarios');
    }
}
