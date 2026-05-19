<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Login' }} | {{ config('app.name', 'StoreDP') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Admin-specific base styles -->
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc; /* Slate 50 */
            color: #0f172a; /* Slate 900 */
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-4">
    {{ $slot }}
</body>
</html>
