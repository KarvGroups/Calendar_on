<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
    </head>
    <body class="font-sans antialiased">
        {{-- <x-banner /> --}}

        <div class="min-h-screen flex">

            <div class="container-fluid page-body-wrapper pt-0 proBanner-padding-top">
                <div >
                    @livewire('navigation-sidebar')
                </div>
                <header class="bg-white shadow">
                    @livewire('navigation-navbar')
                </header>

                <!-- Conteúdo dinâmico -->
                <main class="flex-grow p-6 bg-gray-100">
                    @yield('content')
                    @if (isset($slot))
                        {{ $slot }}
                    @endif

                </main>
            </div>
        </div>

        @stack('modals')


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
        {{-- <script src="{{asset('assets/js/dashboard.js')}}"></script> --}}
    </body>
</html>
