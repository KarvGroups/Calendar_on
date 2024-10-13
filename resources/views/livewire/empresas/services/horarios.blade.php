<div>
    <style>
        .calendar-container {
    width: 100%;
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    font-family: "Poppins", sans-serif;
    color: #878895;
}

.calendar-header {
    text-align: center;
}

.weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    font-weight: bold;
    color: #878895;
}

.days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1.4px;
    margin-bottom: 13px;
}

.day {
    background-color: #f5f5f5;
    text-align: center;
    padding: 10px;
    cursor: pointer;
    position: relative;
    border: 1px solid #ccc;
}

.work-day {
    background-color: #b66dff;
    color: white;
}

.no-work-day {
    background-color: #f0f0f0;
    color: gray;
}

.selected-day-form {
    margin-top: 20px;
}

.selected-day-form input[type="time"] {
    margin: 5px 0;
}

    </style>
    <h3>Gerenciar Horários de Trabalho</h3>

    <!-- Calendário -->
    <div class="calendar-container">
        <div class="calendar-header">
            <button wire:click="previousMonth">Anterior</button>
            <h2>{{ \Carbon\Carbon::create($currentYear, $currentMonth)->translatedFormat('F Y') }}</h2>
            <button wire:click="nextMonth">Próximo</button>
        </div>

        <!-- Cabeçalho dos dias da semana -->
        <div class="weekdays">
            @foreach (['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'] as $day)
                <div>{{ $day }}</div>
            @endforeach
        </div>

        <!-- Grade dos dias do mês -->
        <div class="days grid grid-cols-7 gap-2 mt-4">
            @for ($i = 0; $i < $startDayOfMonth; $i++)
                <div class="empty"></div>
            @endfor

            <!-- Loop para exibir os dias do mês -->
            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $date = Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
                    $schedule = $schedules[$date] ?? null;
                @endphp
                <div class="day @if($schedule && $schedule['is_working']) work-day @elseif($schedule && !$schedule['is_working']) no-work-day @endif" wire:click="selectDay({{ $day }})">
                    <span>{{ $day }}</span>
                    @if($schedule)
                        @if($schedule['is_working'])
                            <div>{{ $schedule['start_time'] }} - {{ $schedule['end_time'] }}</div>
                        @else
                            <div>Não trabalha</div>
                        @endif
                    @endif
                </div>
            @endfor
        </div>
    </div>

    <!-- Detalhes do Dia Selecionado -->
    @if ($selectedDay)
    <div class="selected-day-form">
        <h4>Horários para o dia: {{ $selectedDay }}</h4>

        <label>Trabalhar neste dia?</label>
        <input type="checkbox" wire:model="isWorking"> Sim/Não

        <div>
            <label>Hora de Início:</label>
            <input type="time" wire:model="start_time" @if(!$isWorking) disabled @endif>

            <label>Hora de Término:</label>
            <input type="time" wire:model="end_time" @if(!$isWorking) disabled @endif>

            <button wire:click="saveScheduleForDay">Salvar</button>
        </div>
    </div>
    @endif

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>
