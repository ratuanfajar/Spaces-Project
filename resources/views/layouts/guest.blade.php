<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Spacer') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
            
            <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-slate-900 to-slate-700 text-white p-10 relative overflow-hidden">
                <div class="z-10 text-center">
                    <div class="mx-auto w-20 h-20 bg-white rounded-full flex items-center justify-center mb-6">
                        <div class="flex gap-2">
                            <div class="w-3 h-3 bg-slate-900"></div>
                            <div class="w-3 h-3 bg-slate-900"></div>
                        </div>
                    </div>
                    
                    <h1 class="text-4xl font-bold mb-4">Welcome to <br> Spacer</h1>
                    
                    <p class="text-slate-300 max-w-sm text-sm leading-relaxed">
                        Calm productivity. Make space for focus.<br>
                        Manage your tasks and schedule without the stress.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-center p-8 bg-white text-black">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>