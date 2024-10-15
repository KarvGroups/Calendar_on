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
        padding: 20px 0;
        display: flex;
        justify-content: space-between;
    }
    .calendar-header button{
        width: 40px;
    }
    .calendar-header button i{
        font-size: 30px;
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
        font-size: 14px;
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

    .selected-day {
        /* border: 2px solid #7b057b8f; */
        background-color: #b66dff !important;
        color: #ffffff !important;
    }
    .delete-button {
        background-color: red;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
        margin-top: 10px;
    }

    .delete-button:hover {
        background-color: darkred;
    }
    .days-selected {
        display: flex;
        justify-content: center;
        flex-wrap: wrap; /* Permite que os itens quebrem em múltiplas linhas */
    }

    .days-selected div {
        font-size: 12px;
        padding: 7px 11px;
        background-color: #b66dff;
        border-radius: 37px;
        color: white;
        margin: 5px;
        white-space: nowrap; /* Evita que o texto quebre */
    }

    /* Responsividade para telas menores */
    @media (max-width: 768px) {
        .days-selected {
            justify-content: flex-start; /* Ajusta a distribuição para alinhar à esquerda em telas menores */
        }

        .days-selected div {
            font-size: 10px; /* Diminui a fonte em telas menores */
            padding: 5px 8px; /* Reduz o padding */
        }
    }

    @media (max-width: 480px) {
        .days-selected div {
            font-size: 9px; /* Diminui ainda mais o tamanho da fonte para telas pequenas */
            padding: 4px 6px; /* Ajusta o padding para manter legibilidade */
            margin: 3px; /* Reduz o espaçamento entre os itens */
        }
    }


    </style>

    <div class="calendar-container">
        <div class="calendar-header">
            <button wire:click="previousMonth"><i class="fa fa-angle-left"></i></button>
            <h2>{{ \Carbon\Carbon::create($currentYear, $currentMonth)->translatedFormat('F Y') }}</h2>
            <button wire:click="nextMonth"><i class="fa fa-angle-right"></i></button>
        </div>

        <div class="weekdays">
            @foreach (['D', 'S', 'T', 'Q', 'Q', 'S', 'S'] as $day)
                <div>{{ $day }}</div>
            @endforeach
        </div>

        <div class="days grid grid-cols-7 gap-2 mt-4">
            @for ($i = 0; $i < $startDayOfMonth; $i++)
                <div class="empty"></div>
            @endfor

            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $date = Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
                    $schedule = $schedules[$date] ?? null;
                @endphp
                <div class="day @if(in_array(Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d'), $selectedDays)) selected-day @endif" wire:click="selectDay({{ $day }})">
                    <span>{{ $day }}</span>
                    @if(isset($schedules[$date]))
                        @foreach((array)$schedules[$date] as $schedule) <!-- Forçando como array -->
                            @if($schedule['is_working'])
                                <div>{{ $schedule['start_time'] }} - {{ $schedule['end_time'] }}</div>
                            @else
                                <div>Não trabalha</div>
                            @endif
                        @endforeach
                    @endif


                </div>
            @endfor
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="days-selected">
                        @foreach($selectedDays as $selectedDay)
                            <div>{{ $selectedDay }}</div>
                        @endforeach
                    </div>
                </div>


                <div class="col-12">


                <div class="form-group">
                    <label>Trabalhar nesses dias?</label>

                    <div class="form-check">

                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-primary" wire:model="isWorking" checked> Sim/Não
                        </label>
                    </div>
                </div>

                @foreach($workBlocks as $index => $block)

                    <div class="row">
                        <dic class="col-2" style="align-items: center;justify-content: center;display: flex;">
                            <button wire:click="addWorkBlock" class="btn btn-sm btn-gradient-primary" ><i class="fa fa-plus"></i></button>
                        </dic>
                        <div class="col-10 " >
                            <div class="d-flex justify-content-end">
                                <label style="align-items: center;justify-content: center;display: flex;">Hora de Início : </label>
                                <input class="ms-2" type="time" wire:model="workBlocks.{{ $index }}.start_time" @if(!$isWorking) disabled @endif>
                            </div>
                            <div class="d-flex justify-content-end">
                                <label style="align-items: center;justify-content: center;display: flex;">Hora de Término : </label>
                                <input class="ms-2" type="time" wire:model="workBlocks.{{ $index }}.end_time" @if(!$isWorking) disabled @endif>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        <br>
        <div class="d-flex justify-content-end">
            <button wire:click="saveScheduleForDay" class="btn btn-gradient-primary mb-2 " >Salvar</button>
            <button wire:click="deleteSelectedDays" class="btn btn-secondary mb-2 ms-1" @if(empty($selectedDays)) disabled @endif>Deletar</button>
        </div>

    </div>

    </div>
</div>

</div>


    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>
