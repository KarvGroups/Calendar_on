<div class="container mt-4">
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
            gap: 1.5px !important;
            margin-bottom: 13px;
        }

        .day {
            color: #b66dff;
            border-radius: 11px;
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
            color: grey;
            opacity: 40%;
        }

        .selected-day {
            background-color: #b66dffcf !important;
            color: white !important;
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
            flex-wrap: wrap;
        }

        .days-selected div {
            font-size: 12px;
            padding: 7px 11px;
            background-color: #b66dff;
            border-radius: 37px;
            color: white;
            margin: 5px;
            white-space: nowrap;
        }


        @media (max-width: 768px) {
            .days-selected {
                justify-content: flex-start;
            }

            .days-selected div {
                font-size: 10px;
                padding: 5px 8px;
            }
        }

        @media (max-width: 480px) {
            .days-selected div {
                font-size: 9px;
                padding: 4px 6px;
                margin: 3px;
            }
        }
        .nav-link{
            color: gray;
        }
        .nav-link:hover{
            color: gray;
        }
        .nav-link:active{
            color: gray;
        }
        .time-in-day{
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5px !important;
            margin-bottom: 13px;
        }
        .time-in-day .time{
            color: #b66dff;
            border-radius: 11px;
            font-size: 14px;
            background-color: #f5f5f5;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            position: relative;
            border: 1px solid #ccc;
        }
        .non-working-hour {
            color: gray !important;
            opacity: 40%;
        }
        .fully-non-working-day {
            color: #b66dff !important;
            background-color: #f5f5f5 !important;
            border: 1px solid #ccc !important;
            opacity: 100%;
        }
        .work-day {
            background-color: #b66dff38;
            color: #8702f5;
            border: 1px solid #b66dff;
        }
        .buttons-selct-all{
            display: flex;
            justify-content: flex-end;
            margin: 0 0 20px;
        }
        </style>
    <h2 class="mb-4">Gerenciar Horários</h2>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $calendarPage }}" wire:click="switchTab('calendar')" id="calendar-tab" data-bs-toggle="tab" href="#calendarPage" aria-controls="calendarPage" aria-selected="true">Calendário</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $horaActivePage }}" wire:click="switchTab('hora')" id="hora-tab" data-bs-toggle="tab" href="#horaActivePage" aria-controls="horaActivePage" aria-selected="false">Horário Ativo</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade {{$calendarPage}}" id="calendarPage" role="tabpanel" aria-labelledby="calendar-tab">

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

                <div class="days grid grid-cols-7 mt-4">
                    @for ($i = 0; $i < $startDayOfMonth; $i++)
                        <div class="empty"></div>
                    @endfor

                    @for ($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $date = Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
                        $dayOfWeek = ucfirst(Carbon\Carbon::create($currentYear, $currentMonth, $day)->locale('pt_BR')->dayName);
                        $hasSchedule = isset($schedulesByDayOfWeek[$dayOfWeek]);
                        $isFullyNonWorking = in_array($date, $fullyNonWorkingDays);
                        $isWorkDay = in_array($dayOfWeek, $workDays); // Verifica se o dia é um dia de trabalho
                    @endphp
                    <div class="day
                        @if($date === $selectedDay) selected-day @endif
                        @if($isWorkDay) work-day @endif
                        @if($isFullyNonWorking) fully-non-working-day @endif"
                        wire:click="selectDay({{ $day }})">
                        <span>{{ $day }}</span>
                    </div>
                    @endfor
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-between">
                    <h4>Horários do Dia Selecionado</h4>


                </div>

                @if($selectedDay)

                    <p><strong>Data:</strong> {{ \Carbon\Carbon::create($selectedDay)->translatedFormat('d \d\e F \d\e Y') }}</p>
                    @if(count($daySchedules) > 0)
                    <div class="buttons-selct-all">
                        @if($selectedDay)
                            <button class="btn btn-sm btn-danger" wire:click="markFullDay">Desativar Todos</button>
                        @endif
                        @if($selectedDay)
                            <button class="btn btn-sm btn-success" wire:click="unmarkFullDay">Ativar Todos</button>
                        @endif
                    </div>
                    <div class="time-in-day">
                        @foreach($daySchedules as $time)

                            <div class="time
                                @if(in_array($time, $nonWorkingHours)) non-working-hour @endif"
                                wire:click="markAsNonWorkingHour('{{ $time }}')">
                                <span>{{ $time }}</span>
                            </div>

                        @endforeach

                    </div>

                    @else
                        <p>Não há horários configurados para este dia.</p>
                    @endif
                @else
                    <p>Nenhum dia selecionado.</p>
                @endif
            </div>
        </div>

        <!-- Aba do horário ativo -->
        <div class="tab-pane fade {{$horaActivePage}}" id="horaActivePage" role="tabpanel" aria-labelledby="hora-tab">
            <form wire:submit.prevent="saveSchedules" class="card p-4 mb-4">
                <div class="row align-items-center mb-3">
                    <div class="col-12 d-flex justify-content-between">
                        <div>
                            Dia da Semana
                        </div>
                        <div class="d-flex justify-content-between" style="width: 400px;padding: 0 37px;">
                            <div>
                                Inicio
                            </div>
                            <div>
                                Pausa (opcional)
                            </div>
                            <div>
                               Fim
                            </div>
                        </div>

                    </div>

                </div>
                @foreach ($daysOfWeek as $day)
                <div class="row align-items-center mb-3">
                    <div class="col-12 d-flex justify-content-between">
                        <div>
                            <input
                                type="checkbox"
                                wire:model="scheduleInputs.{{ $day }}.enabled"
                                id="enable-{{ $day }}"
                            >
                            <label for="enable-{{ $day }}">{{ $day }}</label>
                        </div>
                        <div class="d-flex">
                            <div>
                                <input
                                    type="time"
                                    class="form-control"
                                    wire:model.lazy="scheduleInputs.{{ $day }}.start_time"
                                    @if(!isset($scheduleInputs[$day]['enabled']) || !$scheduleInputs[$day]['enabled']) disabled @endif
                                >
                                @error("scheduleInputs.$day.start_time") <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <input
                                    type="time"
                                    class="form-control"
                                    wire:model.lazy="scheduleInputs.{{ $day }}.pause_start"
                                    placeholder="Início Pausa (opcional)"
                                    @if(!isset($scheduleInputs[$day]['enabled']) || !$scheduleInputs[$day]['enabled']) disabled @endif
                                >
                                @error("scheduleInputs.$day.pause_start") <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <input
                                    type="time"
                                    class="form-control"
                                    wire:model.lazy="scheduleInputs.{{ $day }}.pause_end"
                                    placeholder="Fim Pausa (opcional)"
                                    @if(!isset($scheduleInputs[$day]['enabled']) || !$scheduleInputs[$day]['enabled']) disabled @endif
                                >
                                @error("scheduleInputs.$day.pause_end") <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <input
                                    type="time"
                                    class="form-control"
                                    wire:model.lazy="scheduleInputs.{{ $day }}.end_time"
                                    @if(!isset($scheduleInputs[$day]['enabled']) || !$scheduleInputs[$day]['enabled']) disabled @endif
                                >
                                @error("scheduleInputs.$day.end_time") <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                    </div>

                </div>
                @endforeach
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
    <script>
        Livewire.on('calendarUpdated', () => {
            console.log('O calendário foi atualizado!');
            // Adicione lógica adicional, se necessário
        });
    </script>
</div>
