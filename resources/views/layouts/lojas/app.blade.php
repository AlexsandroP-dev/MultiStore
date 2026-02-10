<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="" />
    <meta name="author" content="Alex" />
    <meta name="robots" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('page_description')" />
    <meta property="og:title" content="['nada aqui']" />
    <meta property="og:description" content="['nada aqui']  @yield('title')" />
    <meta property="og:image" content="['nada aqui']" />
    <meta name="format-detection" content="telephone=no">
    <title>['nada aqui'] @yield('title')</title>
    <link rel="icon" type="image/svg" sizes="16x16" href="['nada aqui']">

    @yield('css')

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased vh-100">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.lojas.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @yield('scripts')
</body>

</html>
