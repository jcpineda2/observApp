<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SEO -->
    {!! seo_data($paginaConfig ?? ($seo ?? null)) !!}
    <!-- Estilos -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/leaf.css') }}">
    <link rel="preload" href="{{ asset('css/fonts/urbanist.css') }}" as="style" onload="this.rel='stylesheet'">
    {{-- <link rel="stylesheet" href="{{ asset('css/chart.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/accordion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mail-button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paleta-colores.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ETJEYJHK8Q"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-ETJEYJHK8Q');
    </script>
    @stack('custom-css')

    @stack('headscripts')
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Contenido -->
    <main class="flex-grow-1">
        @yield('content')
        <x-impersonate::banner />
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Barra de progreso -->
    @include('components.progress_bar')

    <!-- Scripts -->
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/popup.js') }}"></script>
    <script src="{{ asset('js/curdate.js') }}"></script>
    @stack('custom-scripts')
</body>

</html>
