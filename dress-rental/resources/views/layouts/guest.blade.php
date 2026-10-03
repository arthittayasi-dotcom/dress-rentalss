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

    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap"
          rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-slate-800"
      style="font-family: 'Prompt', sans-serif;">

    <div class="min-h-screen relative overflow-hidden bg-[#F9F8FC]">

        <div class="absolute -top-32 -left-24
                    w-[420px] h-[420px]
                    rounded-full bg-[#DDECF8]
                    blur-3xl opacity-70"></div>

        <div class="absolute top-10 -right-24
                    w-[420px] h-[420px]
                    rounded-full bg-[#E5DDF3]
                    blur-3xl opacity-70"></div>

        <div class="absolute -bottom-36 left-1/3
                    w-[420px] h-[420px]
                    rounded-full bg-[#F4DFE8]
                    blur-3xl opacity-70"></div>

        <div class="relative z-10">
            {{ $slot }}
        </div>

    </div>

</body>
</html>