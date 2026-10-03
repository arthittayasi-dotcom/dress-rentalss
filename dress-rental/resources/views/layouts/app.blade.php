<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="{{ asset('wanwan-logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WANWAN') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased text-slate-800 bg-[#F8F7FC]"
    style="font-family: 'Prompt', sans-serif;"
>
    <div class="min-h-screen">

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white/80 backdrop-blur border-b border-purple-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="relative">

            <div class="absolute top-0 left-0 w-72 h-72 bg-[#DCEBFA] rounded-full blur-3xl opacity-40 -z-10"></div>

            <div class="absolute top-20 right-0 w-80 h-80 bg-[#DDD5F3] rounded-full blur-3xl opacity-40 -z-10"></div>

            <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-[#F6DCE7] rounded-full blur-3xl opacity-40 -z-10"></div>

            {{ $slot }}

        </main>

    </div>
</body>
</html>