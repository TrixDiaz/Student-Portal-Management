<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <div class="flex flex-wrap">
        <div class="flex w-full flex-col md:w-1/2">
            {{ $slot }}
        </div>
        <div class="pointer-events-none relative hidden h-screen select-none bg-lime-900 md:block md:w-1/2">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                <div class="flex flex-col justify-center items-center text-center">
                    <p class="uppercase font-bold font-sans text-3xl text-white">welcome to</p>
                    <p class="uppercase font-bold font-sans text-3xl -me-8 my-4 text-white">student portal <span class="text-yellow-600">{{ config('app.name') }}</span></p>
                    <img src="/images/auth-logo.png" alt="logo" class="block h-64 w-auto">
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>