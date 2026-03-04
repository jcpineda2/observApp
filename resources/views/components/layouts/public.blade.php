<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">



    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
    {{-- Header público --}}

    {{-- Contenido --}}
    <main class="min-h-[calc(100vh-64px)]">
        {{ $slot }}
    </main>
    <livewire:public-interface.footer />
    @livewireScripts
</body>
</html>
