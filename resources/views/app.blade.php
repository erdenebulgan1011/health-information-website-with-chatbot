<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @vite('resources/js/app.js') <!-- Make sure this is correct for Vite asset compilation -->
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
