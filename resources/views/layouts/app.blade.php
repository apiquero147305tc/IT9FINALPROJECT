<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CraveCart')</title>
    
    {{-- If using Vite (Laravel 9.19+) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- OR if using plain CSS file in public/css/ --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
</head>
<body>
    {{-- Navbar --}}
    @include('partials.navbar')
    
    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>
    
    {{-- Footer (optional) --}}
    @include('partials.footer')
</body>
</html>