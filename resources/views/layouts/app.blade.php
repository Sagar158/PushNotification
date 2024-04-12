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

        <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
        @if(Session::has('theme') && (Session::get('theme') == 'dark'))
            <link rel="stylesheet" href="{{ asset('assets/css/demo_2/style.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
        @endif
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('css')

    </head>
    <body class="font-sans antialiased">
        <div class="main-wrapper">
            <x-sidebar></x-sidebar>
            <x-settings-sidebar></x-settings-sidebar>
            <div class="page-wrapper">
                <x-header></x-header>
                <div class="page-content">
                    {{ $slot }}
                </div>
                <x-footer></x-footer>
            </div>
        </div>
    </body>

	<script src="{{ asset('assets/vendors/core/core.js') }}"></script>
	<script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('assets/js/template.js') }}"></script>
    @stack('scripts')
</html>
