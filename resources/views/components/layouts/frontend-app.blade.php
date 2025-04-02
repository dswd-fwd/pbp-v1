<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script defer src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <title>{{ $title ?? 'Pamilya sa Bagong Pilipinas | Family Profiling Tool' }}</title>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>  
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased sm:bg-gray-100 font-inter">
        <div class="flex min-h-screen sm:p-10">
            {{ $slot }}
        </div>
    </body>
</html>
