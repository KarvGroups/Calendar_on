<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
        <link href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

        <link href="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">

        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <!-- endinject -->
        <!-- Layout styles -->
        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

        <!-- End layout styles -->
        <link href="{{asset('assets/images/favicon.png')}}" rel="shortcut icon">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

  

        <!-- Styles -->
        <style>
            /* Estilos básicos para a navbar */
            body {
                font-family: 'Figtree', sans-serif;
                margin: 0;
                padding: 0;
            }

            .navbar {
                background-color: #333;
                overflow: hidden;
                position: fixed;
                top: 0;
                width: 100%;
                display: flex;
                justify-content: space-between;
                color: white;
                z-index: 1;
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

            .content {
                padding-top: 73px;
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            {{-- <a href="{{ url('/') }}">Home</a> --}}
            <div></div>
            <div class="navbar-right">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
        <div class="content">
            @if(isset($users) && $users->isNotEmpty())
            @livewire('agendamento-form', ['users' => $users, 'company' => $company])
        @else
            <p>Não tem usuário para selecionar!</p>
        @endif



        </div>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="{{asset('assets/vendors/chart.js/chart.umd.js')}}"></script>

        <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="{{asset('assets/js/off-canvas.js')}}"></script>
        <script src="{{asset('assets/js/misc.js')}}"></script>
        <script src="{{asset('assets/js/settings.js')}}"></script>
        <script src="{{asset('assets/js/todolist.js')}}"></script>
        <script src="{{asset('assets/js/jquery.cookie.js')}}"></script>
        <!-- endinject -->
        <!-- Custom js for this page -->
        <script src="{{asset('assets/js/dashboard.js')}}"></script>
    </body>
</html>
