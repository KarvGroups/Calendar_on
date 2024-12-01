<div class="container">
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
            <div class="navbar">
                <strong style="margin: auto">Selecione</strong>
            </div>
        @endif
    {{-- <div class="container-imagem">
        <img src="{{ asset('storage/imagens/banner.jpeg') }}" alt="Example Image">
    </div> --}}

    <div class="row container-users">
        @foreach($users as $user)
        <div class="col-12 mb-2">
            <div class="card h-100 d-flex flex-row align-items-center p-3 shadow">

                <img src="{{ asset('storage/imagens/naruto.jpeg') }}" alt="foto user" style="width: 70px; height: 70px; object-fit: cover;border-radius: 10px">

                <div class="ms-3 flex-grow-1">
                    <h6 class="">{{ $user->name }}</h6>
                    <p class="">{{ $user->function }}</p>
                </div>

                <a href="#" class="btn btn-primary btn-sm">
                    Appointment
                </a>
            </div>
        </div>
    @endforeach
    </div>

    @if($selectedUser)
        <div class="alert alert-info mt-4">
            Utilizador selecionado: {{ $users->find($selectedUser)->name }}
        </div>
    @endif

</div>
