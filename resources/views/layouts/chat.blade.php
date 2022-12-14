<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'codiweb-chat') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
        @stack('css')
        <!-- Scripts -->
        {{-- <script>
            window.PUSHER_APP_KEY='{{ config('broadcasting.connections.pusher.key') }}';
            window.APP_ENV={{ config('app.env') == 'production' ? 'true' : 'false' }};
        </script> --}}
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-sky-100">
        <div class="h-32 bg-sky-600">
        </div>
        <div class="absolute left-0 top-0 w-screen">
            <div class="mx-auto px-4 sm:px-6 lg:px-8 py-12 ">
                {{ $slot }}
            </div>
        </div>  

        @stack('modals')
        @livewireScripts
        
        @stack('js')
    </body>
</html>
