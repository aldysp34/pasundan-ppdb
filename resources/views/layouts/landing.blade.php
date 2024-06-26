<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        
        <title>{{ config('app.name', 'SMA Pasundan 3') }}</title>
        <!-- Favicon-->
        <link rel="shortcut icon" href="img/core-img/logo_sma_3_pasundan_bandung.png" type="image/x-icon">
        <!-- All CSS Stylesheet-->
        <link rel="stylesheet" href="{{ asset('assets/css/all-css-libraries.css') }}">
        <!-- Core Stylesheet-->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        @yield('styles')



    </head>
    <body>
        <!-- Include the header component -->
        @include('components.landing.header')
        <main>
            @yield('content')
        </main>

        @include('components.landing.footer')
        <!-- All JavaScript Files-->
        
        @yield('script')
        <script src="{{ asset('assets/js/all-js-libraries.js') }}"></script>
        <script src="{{ asset('assets/js/active.js') }}"></script>
    </body>
</html>
