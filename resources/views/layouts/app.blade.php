<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

    <title>@yield('title')</title>
</head>
<body>

<div class="page-wrapper">

    @if (!request()->routeIs('registration.show', 'login.show'))
        @include('components.nav.nav')
    @endif

    <main class="page-content">
        @yield('content')
    </main>

</div>

<script src="{{ asset('vendor/js/bootstrap.js') }}"></script>
</body>
</html>
