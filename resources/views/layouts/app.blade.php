<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'SeaBiz — Platform Bisnis Perikanan')</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@yield('styles')
</head>
<body>

@include('partials.nav')

@yield('content')

<div id="sb-toast"></div>

@yield('scripts')
</body>
</html>
