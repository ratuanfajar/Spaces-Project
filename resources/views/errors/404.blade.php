<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Page Not Found - {{ config('app.name', 'Spacer') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-950 text-slate-300 font-sans h-screen overflow-hidden">
        
        <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center relative z-10">
            
            <h1 class="text-9xl font-extrabold text-slate-800 tracking-widest select-none animate-pulse">
                404
            </h1>

            <div class="mt-8 relative z-20">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Page Not Found.
                </h2>
                
                <p class="text-slate-400 mb-8 max-w-md mx-auto leading-relaxed">
                    Sorry, we can't find the page you're looking for. <br>
                    It might have been removed or the link is broken.
                </p>

                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-8 py-3 bg-slate-100 hover:bg-white text-slate-900 rounded-lg font-bold shadow-lg transition transform hover:scale-105 hover:shadow-xl">
                    Back to Main Page
                </a>

            </div>

        </div>

        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-[20%] left-[20%] w-96 h-96 bg-indigo-900/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[20%] right-[20%] w-96 h-96 bg-slate-800/10 rounded-full blur-3xl"></div>
        </div>

    </body>
</html>