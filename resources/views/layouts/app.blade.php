<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AUSHVERA — Wellness, Refined by Nature')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    @stack('styles')
</head>
<body>
    @include('partials.nav')
    
    @yield('content')
    
    @include('partials.footer')
    
    <script src="{{ asset('api.js') }}"></script>
    @stack('scripts')
</body>
</html>
