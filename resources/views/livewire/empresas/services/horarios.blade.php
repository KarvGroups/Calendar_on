<div>
    <h3>Gerenciar Horários de Trabalho</h3>

    <div>
        <label>Dia da Semana:</label>
        <select wire:model="newSchedule.day_of_week">
            <option value="">Selecione um dia</option>
            @foreach ($daysOfWeek as $day)
                <option value="{{ $day }}">{{ $day }}</option>
            @endforeach
        </select>

        <label>Hora de Início:</label>
        <input type="time" wire:model="newSchedule.start_time">

        <label>Hora de Término:</label>
        <input type="time" wire:model="newSchedule.end_time">

        <button wire:click="addSchedule">Adicionar Horário</button>
    </div>

    <h4>Horários:</h4>
    <ul>
        @foreach ($schedules as $index => $schedule)
            <li>{{ $schedule['day_of_week'] }}: {{ $schedule['start_time'] }} - {{ $schedule['end_time'] }}</li>
        @endforeach
    </ul>

    <button wire:click="saveSchedules">Salvar Horários</button>

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>
