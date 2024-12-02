<div>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Muli&display=swap');
        * {
            box-sizing: border-box;
        }
        .container {
            text-align: center;
        }
        .container-imagem {
            position: absolute;
            top: 56px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 0;
            width: 85%;
            height: auto;
        }

        .container-imagem img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 0 0 15px 15px;
        }
        .container-users{
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 120px;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            padding: 20px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            color: #555;
        }
        .form-group .checkbox {
            display: flex;
            align-items: center;
        }
        .form-group .checkbox input {
            margin-right: 10px;
        }
        .form-group .checkbox a {
            color: #1bcfb4;
            text-decoration: none;
        }
        .submit-button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #1bcfb4;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 56px;
            display: flex;
            justify-content: space-between;
            color: white;
            z-index: 1;
            padding: 0;
        }

        .navbar a {
            color: white;
            text-align: center;
            padding: 16px 23px;
            text-decoration: none;
            font-size: 17px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar-right {
            display: flex;
        }
        .select-style{
            background: #1bcfb4;
            color: #ffffff;
        }

        .calendar-container {
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 56px;
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
            display: none;
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
        .fully-non-working-day {
            color: #b66dff !important;
            background-color: #f5f5f5 !important;
            border: 1px solid #ccc !important;
            opacity: 100%;
        }
        .selected-day {
            background-color: #b66dffcf !important;
            color: white !important;
        }
        .work-day {
            background-color: #b66dff38;
            color: #8702f5;
            border: 1px solid #b66dff;
        }
    </style>
        @if(auth()->user())
            <div class="navbar">
                {{-- <a href="{{ url('/') }}">Home</a> --}}
                <div></div>
                <div class="navbar-right">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}">Log in</a>
                            {{-- @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif --}}
                        @endauth
                    @endif
                </div>
            </div>
        @else
            @if($hourMark)
                <div class="navbar">

                    <button style="width: 60px;height: 100%;" wire:click='gobackFomulario()'><i class="fa fa-solid fa-arrow-left"></i></button>

                    <strong style="position: absolute;left: 50%;transform: translateX(-50%);">Appointment</strong>

                </div>
            @else
                @if($check == 1)
                    <div class="navbar">

                        <button style="width: 60px;height: 100%;" wire:click='gobackCalendar()'><i class="fa fa-solid fa-arrow-left"></i></button>

                        <strong style="position: absolute;left: 50%;transform: translateX(-50%);">Selecione dia e hora</strong>

                    </div>
                @else
                    <div class="navbar @if(count($selectedServices) > 0) select-style @endif">
                        @if($selectedUser)
                            <button style="width: 60px;height: 100%;" wire:click='goback()'><i class="fa fa-solid fa-arrow-left"></i></button>
                        @endif

                        @if(count($selectedServices) > 0)
                            <button style="width: 60px;height: 100%;margin: 0 20px;" wire:click='checkSelects()'><h3>Pronto</h3></button>
                        @else
                            <strong style="position: absolute;left: 50%;transform: translateX(-50%);">Selecione</strong>
                        @endif
                    </div>
                @endif
            @endif

        @endif
        @if($hourMark)
            <div class="calendar-container">
                @foreach ($selectedServicesSee as $ServicesSee)
                <span style="text-align: left;">
                    <div>
                        <h2>{{ $ServicesSee["title"] }}</h2>
                    </div>
                    <div style="font-size: 12px; opacity: 65%;">{{ $ServicesSee["price"] }}€ - {{ $ServicesSee["time"] }} min</div>
                </span>
                @endforeach

                <div class="form-container">
                    <h2>Appointment Form</h2>
                    <form wire:submit.prevent="submitForm">

                        <div class="form-group">
                            <label for="name">First and Last Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" wire:model="name" required>
                            @error('name') <small style="color: red;">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" wire:model="email" required>
                            @error('email') <small style="color: red;">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <div style="display: flex; gap: 10px;">
                                <select name="country_code" style="width: 112px;" required>
                                    <option value="+351">🇵🇹 +351</option>
                                </select>
                                <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" wire:model="mobile" required>
                            </div>
                            @error('mobile') <small style="color: red;">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="message">Optional Message</label>
                            <textarea id="message" name="message" wire:model="message">{{ old('message') }}</textarea>
                            @error('message') <small style="color: red;">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group checkbox" style="display: flex;">
                            <input type="checkbox" id="terms" name="terms" style="width: auto;margin-right: 5px;" wire:model="terms" required>
                            <label for="terms" style="margin-bottom:0;display: flex;align-items: center;">
                                I've read and agree with <a href="#">ZAPPY's Terms and Privacy Policy</a>.
                            </label>
                            @error('terms') <small style="color: red;">{{ $message }}</small> @enderror
                        </div>
                        <button type="submit" class="submit-button">Schedule</button>
                    </form>
                </div>

            </div>

        @else
            @if($check == 1)
            <div>
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
                            $isWorkDay = in_array($dayOfWeek, $workDays);
                        @endphp
                        <div class="day
                            @if($date === $selectedDay) selected-day @endif
                            @if($isWorkDay) work-day @endif
                            @if($isFullyNonWorking) fully-non-working-day @endif
                            "
                            wire:click="selectDay({{ $day }})">
                            <span>{{ $day }}</span>
                        </div>
                        @endfor
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between">
                            <h4>Horários do Dia Selecionado</h4>


                        </div>

                        @if($selectedDay)

                            <p><strong>Data:</strong> {{ \Carbon\Carbon::create($selectedDay)->translatedFormat('d \d\e F \d\e Y') }}</p>
                            @if(count($daySchedules) > 0)
                            <div class="time-in-day">
                                @foreach($daySchedules as $time)
                                    <div class="time
                                        @if(in_array($time, $nonWorkingHours)) non-working-hour @endif"
                                        wire:click="markHour('{{ $time }}')">
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

            </div>

            @else
                @if($selectedUser)

                    {{-- apresenta o usuario selecionado --}}
                    <div class="row container-users">
                        <div class="col-12 mb-5">
                            <div class="card h-100 d-flex flex-row align-items-center p-3 shadow">

                                <img src="{{ asset('storage/imagens/naruto.jpeg') }}" alt="foto user" style="width: 70px; height: 70px; object-fit: cover;border-radius: 10px">

                                <div class="ms-3 flex-grow-1" style="text-align: left;">
                                    <h6>{{ $users->find($selectedUser)->name }}</h6>
                                    <p>{{ $users->find($selectedUser)->function }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="sortable-categories">
                        @foreach ($categorys as $category)
                            <div class="sortable-category" data-id="{{ $category->id }}">
                                <h2 style="text-align: center; margin: 10px;">
                                    {{ $category->title }}
                                </h2>
                                <ul id="sortable-list-{{ $category->id }}" class="card h-100 p-2 shadow-sm" style="gap: 10px;">
                                    @foreach ($services as $service)
                                        @if($service->id_categorias == $category->id)
                                            <li data-id="{{ $service->id }}" class="d-flex justify-content-between">
                                                <span style="text-align: left;">
                                                    <div>
                                                        <h2>{{ $service->title }}</h2>
                                                    </div>
                                                    <div style="font-size: 12px; opacity: 65%;">{{ $service->price }}€ - {{ $service->time }} min</div>
                                                </span>
                                                <div>
                                                    <a href="#"
                                                    wire:click="toggleServiceSelection({{ $service->id }})"
                                                    class="btn btn-sm {{ in_array($service->id, $selectedServices) ? 'btn-success' : 'btn-primary' }}">
                                                        {{ in_array($service->id, $selectedServices) ? 'Selected' : 'Appointment' }}
                                                    </a>
                                                </div>

                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                        {{-- @if(count($selectedServices) > 0)
                            <h3>Serviços Selecionados:</h3>
                            <ul>
                                @foreach($selectedServices as $serviceId)
                                    <li>{{ $services->find($serviceId)->title ?? 'Serviço não encontrado' }}</li>
                                @endforeach
                            </ul>
                        @endif --}}

                    </div>
                @else
                    {{-- apresenta todos os usuarios --}}
                    <div class="row container-users">
                        @foreach($users as $user)
                        <div class="col-12 mb-2">
                            <div class="card h-100 d-flex flex-row align-items-center p-3 shadow">

                                <img src="{{ asset('storage/imagens/naruto.jpeg') }}" alt="foto user" style="width: 70px; height: 70px; object-fit: cover;border-radius: 10px">

                                <div class="ms-3 flex-grow-1" style="text-align: left;">
                                    <h6 class="">{{ $user->name }}</h6>
                                    <p class="">{{ $user->function }}</p>
                                </div>

                                <a href="#" wire:click='selectUser({{$user->id}})' class="btn btn-primary btn-sm">
                                    Appointment
                                </a>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endif
            @endif
        @endif


</div>
