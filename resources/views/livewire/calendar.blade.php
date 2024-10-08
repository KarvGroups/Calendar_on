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
            color: #333;
        }

        .calendar-header h2 {
            font-size: 1.2rem;
            text-transform: capitalize;
        }

        .calendar-header button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            color: #878895;
        }

        .calendar-header button:hover {
            color: #b38add;
        }

        .weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0;
            text-align: center;
            font-weight: bold;
            color: #878895;
            margin-bottom: 10px;
        }
        .bg-purple-500{
            background-color: #b66dff !important;
        }

        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1.4px !important;
            margin-bottom: 13px;
        }

        .day {
            background-color: #f5f5f5;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            position: relative;
        }

        .day:hover {
            background-color: #b66dff;
            color: #fff;
        }

        .day.event-day {
            /* background-color: #d1b3f0;
        /* Borda para destacar */
        }

        .day.event-day .event-indicator {
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            height: 4px;
            background-color: #b66dff;
            border-radius: 2px;
        }
        .bg-purple-500 .event-indicator{
            background-color: #ffffff !important;
        }

        .day.active {
            background-color: #551d8e;
            color: #fff;
        }

        .today-btn {
            background-color: #b66dff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .today-btn:hover {
            background-color: #b66dff;
        }
        .add-event {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #878895;
            border: 2px solid #878895;
            opacity: 0.5;
            border-radius: 50%;
            background-color: transparent;
            cursor: pointer;
        }
        .add-event:hover {
            opacity: 1;
        }
        .add-event i {
            pointer-events: none;
        }
        .add-event-body {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .add-event-body .add-event-input {
            width: 100%;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .add-event-body .add-event-input input {
            width: 100%;
            height: 100%;
            outline: none;
            border: none;
            border-bottom: 1px solid #f5f5f5;
            padding: 0 10px;
            font-size: 1rem;
            font-weight: 400;
            color: #373c4f;
            }
        .add-event-body .add-event-input input::placeholder {
            color: #a5a5a5;
        }
        .line-event{
            background: linear-gradient(to right, #d07bf9, #9a55ff);

            color: #ffffff;
            padding: 12px;
        }
        .line-event-values{
            display: flex;
            position: relative;
        }
        .name-user-event{
            position: absolute;
            top: -14px;
            color: #ffe217
        }

    </style>
    <!-- Formulário para adicionar eventos -->
    <div class="row">
        <div class="col-md-6 px-0 px-md-3" style="margin-bottom: 15px">


            <div class="calendar-container">
                <div class="calendar-header flex justify-between items-center mb-4">
                    <button class="prev" wire:click="previousMonth">
                        <i class="fa fa-angle-left"></i>
                    </button>
                    <h2>{{ \Carbon\Carbon::create($currentYear, $currentMonth)->translatedFormat('F Y') }}</h2>
                    <button class="next" wire:click="nextMonth">
                        <i class="fa fa-angle-right"></i>
                    </button>
                </div>

                <!-- Cabeçalho dos dias da semana -->
                <div class="weekdays">
                    <div>D</div>
                    <div>S</div>
                    <div>T</div>
                    <div>Q</div>
                    <div>Q</div>
                    <div>S</div>
                    <div>S</div>
                </div>

                <!-- Grade dos dias do mês -->
                <div class="days grid grid-cols-7 gap-2 mt-4">
                    <!-- Preenchimento para alinhar o primeiro dia do mês -->
                    @for ($i = 0; $i < $startDayOfMonth; $i++)
                        <div class="day-placeholder"></div>
                    @endfor

                    <!-- Loop através dos dias do mês -->
                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            // Converte o número do dia para string com dois dígitos
                            $dayString = str_pad($day, 2, '0', STR_PAD_LEFT);
                        @endphp
                        <div class="day
                            @if($selectedDay == $day) bg-purple-500 text-white @endif
                            @if(isset($events[$dayString])) event-day @endif"
                            wire:click="selectDay({{ $day }})">
                            <span>{{ $day }}</span>

                            <!-- Indicador de que há eventos para este dia -->
                            @if(isset($events[$dayString]))
                                <div class="event-indicator"></div>
                            @endif
                        </div>
                    @endfor
                </div>

                <button class="today-btn" wire:click="today">Today</button>
            </div>

    </div>

    <div class="col-md-6 overflow-auto" style="height: 412px;">
        <button class="add-event" data-bs-toggle="collapse" href="#addEvent" role="button" aria-expanded="false" aria-controls="addEvent">
            <i class="fa fa-plus"></i>
        </button>
        <div class="collapse" id="addEvent">
            <form class="mt-3 add-event-body" action="{{ route('events.store') }}" method="POST">
                @csrf
                <div class="add-event-input">
                    <input type="text" name="title" placeholder="Descriçao do Evento" required>
                </div>
                <div class="add-event-input">
                    <input type="date" name="date" required>
                </div>
                <div class="add-event-input">
                    <input type="time" name="start_time" required>
                </div>
                <div class="add-event-input">
                    <input type="time" name="end_time" required>
                </div>

                <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                <input type="hidden" name="user" value="{{ Auth::user()->apelido }}">
                <input type="hidden" name="id_prestadores" value="{{ Auth::user()->id_prestadores }}">


                <button class="btn btn-primary" type="submit">Adicionar Evento</button>
            </form>
        </div>

        @if ($selectedDay)
        <div class="event-details mt-4">
            <h3 class="text-lg font-semibold">Eventos de {{ $selectedDay }} {{ \Carbon\Carbon::create($currentYear, $currentMonth)->translatedFormat('F Y') }}</h3>
            <ul class="mt-2">
                @forelse($dayEvents as $event)
                    <li class="line-event mb-2 flex justify-between items-center">
                        <div class="line-event-values">
                            <p class="name-user-event">{{$event['user']}}</p>
                            <strong>{{ $event['title'] }}</strong> -
                            {{ Carbon\Carbon::parse($event['start_time'])->format('H:i') }} - {{ Carbon\Carbon::parse($event['end_time'])->format('H:i') }}
                        </div>
                        <button wire:click="deleteEvent({{ $event['id'] }})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </li>
                @empty
                    <li>Sem eventos neste dia.</li>
                @endforelse
            </ul>
        </div>
        @endif

    </div>
        <div class="col-md-7 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Project Status</h4>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th> # </th>
                      <th> Name </th>
                      <th> Due Date </th>
                      <th> Progress </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td> 1 </td>
                      <td> Herman Beck </td>
                      <td> May 15, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 2 </td>
                      <td> Messsy Adam </td>
                      <td> Jul 01, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 3 </td>
                      <td> John Richards </td>
                      <td> Apr 12, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 4 </td>
                      <td> Peter Meggik </td>
                      <td> May 15, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 5 </td>
                      <td> Edward </td>
                      <td> May 03, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 5 </td>
                      <td> Ronald </td>
                      <td> Jun 05, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-dark">Todo List</h4>
              <div class="add-items d-flex">
                <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?">
                <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
              </div>
              <div class="list-wrapper">
                <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Meeting with Alisa </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li class="completed">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox" checked> Call John </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Create invoice </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Print Statements </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li class="completed">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox" checked> Prepare for presentation </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Pick up kids from school </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                </ul>
              </div>
            </div>
        </div>
      </div>
</div>
