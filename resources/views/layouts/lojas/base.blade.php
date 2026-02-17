<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="" />
    <meta name="author" content="Alex" />
    <meta name="robots" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('page_description')" />
    <meta property="og:title" content="{{ config('themes.lojas.base.HeaderTitle') }}" />
    <meta property="og:description" content="{{ config('themes.lojas.base.HeaderDescription') }}  @yield('title')" />
    <meta property="og:image" content="['nada aqui']" />
    <meta name="format-detection" content="telephone=no">
    <title>{{ config('themes.lojas.base.HeaderTitle') }} @yield('title')</title>
    <link rel="icon" type="image/svg" sizes="16x16" href="['nada aqui']">

    <!-- CSS -->
    @yield('css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @stack('css')
</head>

<body class="vh-100">

    @yield('body')

    @yield('scripts')

    @stack('scripts')
</body>

</html>
