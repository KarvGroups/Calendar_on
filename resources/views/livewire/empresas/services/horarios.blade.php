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
            background-color: #b66dff;
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
            color: gray ;
            opacity: 40%;
        }
        </style>
    <h2 class="mb-4">Gerenciar Horários</h2>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" id="calendar-tab" data-bs-toggle="tab" href="#calendarPage" aria-controls="calendarPage" aria-selected="true">Calendário</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="hora-tab" data-bs-toggle="tab" href="#horaActivePage" aria-controls="horaActivePage" aria-selected="false">Horário Ativo</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="calendarPage" role="tabpanel" aria-labelledby="calendar-tab">

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
                    @endphp
                    <div class="day
                        @if($date === $selectedDay) selected-day @endif
                        @if(!$hasSchedule) no-work-day @endif
                        @if($isFullyNonWorking) fully-non-working-day @endif"
                        wire:click="selectDay({{ $day }})">
                        <span>{{ $day }}</span>
                    </div>

                    @endfor
                </div>

            </div>
            <div class="mt-4">
                <h4>Horários do Dia Selecionado</h4>
                @if($selectedDay)
                    <p><strong>Data:</strong> {{ \Carbon\Carbon::create($selectedDay)->translatedFormat('d \d\e F \d\e Y') }}</p>
                    @if(count($daySchedules) > 0)
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
                    @if($selectedDay)
                        <button class="btn btn-danger mb-3" wire:click="markFullDay">Marcar Dia Todo como Não Trabalhável</button>
                    @endif
                    @if($selectedDay)
                        <button class="btn btn-success mb-3" wire:click="unmarkFullDay">Tornar Dia Todo Trabalhável</button>
                    @endif

                @else
                    <p>Nenhum dia selecionado.</p>
                @endif

            </div>



        </div>

        <!-- Aba do horário ativo -->
        <div class="tab-pane fade" id="horaActivePage" role="tabpanel" aria-labelledby="hora-tab">
            <form wire:submit.prevent="addSchedule" class="card p-4 mb-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="day_of_week" class="form-label">Dia da Semana:</label>
                        <select wire:model="newSchedule.day_of_week" id="day_of_week" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Segunda-feira">Segunda-feira</option>
                            <option value="Terça-feira">Terça-feira</option>
                            <option value="Quarta-feira">Quarta-feira</option>
                            <option value="Quinta-feira">Quinta-feira</option>
                            <option value="Sexta-feira">Sexta-feira</option>
                            <option value="Sábado">Sábado</option>
                            <option value="Domingo">Domingo</option>
                        </select>
                        @error('newSchedule.day_of_week') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="start_time" class="form-label">Horário de Início:</label>
                        <input type="time" wire:model="newSchedule.start_time" id="start_time" class="form-control">
                        @error('newSchedule.start_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="end_time" class="form-label">Horário de Término:</label>
                        <input type="time" wire:model="newSchedule.end_time" id="end_time" class="form-control">
                        @error('newSchedule.end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Adicionar Horário</button>
            </form>

            <!-- Lista de horários existentes -->
            <div class="card">
                <div class="card-header">
                    <h3>Horários Configurados</h3>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($workSchedules as $schedule)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $schedule['day_of_week'] }}</strong>:
                                {{ $schedule['start_time'] }} - {{ $schedule['end_time'] }}
                            </div>
                            <button wire:click="deleteSchedule({{ $schedule['id'] }})" class="btn btn-danger btn-sm">
                                Remover
                            </button>
                        </li>
                    @empty
                        <li class="list-group-item text-center">Nenhum horário configurado.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <script>
        Livewire.on('calendarUpdated', () => {
            console.log('O calendário foi atualizado!');
            // Adicione lógica adicional, se necessário
        });
    </script>
</div>
