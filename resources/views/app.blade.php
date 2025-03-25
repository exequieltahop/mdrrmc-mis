<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MDRRM INFORMATION MANAGEMENT SYSTEM</title>

        {{-- LOGO --}}
        <link rel="shortcut icon" href="{{ asset('assets/logos/mdrrmc-logo-removebg-preview.png') }}" type="image/x-icon">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light m-0 p-0">

        {{-- authenticated user page --}}
        @auth
            @include('auth.components.header')
            <main class="d-flex align-items-start p-3 gap-0 overflow-auto">
                @include('auth.components.sidebar')
                @yield('auth')
            </main>
        @endauth

        {{-- guest user page --}}
        @guest
            @yield('guest')
        @endguest

    </body>
</html>
