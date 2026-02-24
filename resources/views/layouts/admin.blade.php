<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        @include('partials.admin-sidebar')
        
        <div class="admin-main">
            @include('partials.admin-header')
            
            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script src="{{ asset('api-config.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
