<x-app-layout>
    
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-white">Dashboard</h2>
            <p class="text-slate-400 mt-1">Welcome back, {{ Auth::user()->name }}</p>
        </div>
        
        <div class="hidden sm:block text-right">
            <p class="text-2xl font-light text-indigo-400">{{ now()->format('H:i') }}</p>
            <p class="text-sm text-slate-500">{{ now()->format('l, d M Y') }}</p>
        </div>
    </div>

    <div class="bg-slate-900 overflow-hidden shadow-sm rounded-xl border border-slate-800 p-10 text-center">
        <div class="text-slate-300">
            You are logged in! <br>
            <span class="text-sm text-slate-500 mt-2 block">Select a tool from the sidebar to start focusing.</span>
        </div>
    </div>

</x-app-layout>