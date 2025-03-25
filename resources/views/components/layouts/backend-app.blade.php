<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script defer src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <title>{{ $title ?? 'Page Title' }}</title>
        @vite('resources/css/app.css')
    </head>
    <body class="min-h-screen antialiased bg-gray-100 font-inter">
        <livewire:components.layouts.sidebar />
        <div class="pt-8 pl-80">
            <main class="px-5 mx-auto md:px-10 max-w-8xl">
                <livewire:components.layouts.navbar />
                <div class="mt-5 mb-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
        @livewireScripts
    </body>
</html>
