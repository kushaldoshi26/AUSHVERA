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

            <div class="admin-page-header" style="display:flex;align-items:center;justify-content:space-between;padding:16px 24px;border-bottom:1px solid #e5e7eb;background:#fff;">
                <h1 style="font-size:1.25rem;font-weight:600;margin:0;">@yield('page-title', 'Dashboard')</h1>
                <div class="admin-header-actions">
                    @yield('header-actions')
                </div>
            </div>

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
