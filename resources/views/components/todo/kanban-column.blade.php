@props(['title', 'status', 'items', 'color' => 'indigo', 'icon'])

@php
    $colorClasses = [
        'indigo' => [
            'border' => 'hover:border-indigo-500/50',
            'gradient' => 'from-indigo-500 to-purple-600',
            'hover' => 'hover:text-indigo-400',
            'button' => 'hover:border-indigo-500/30'
        ],
        'amber' => [
            'border' => 'hover:border-amber-500/50',
            'gradient' => 'from-amber-500 to-orange-600',
            'hover' => 'hover:text-amber-400',
            'button' => 'hover:border-amber-500/30'
        ],
        'emerald' => [
            'border' => 'hover:border-emerald-500/50',
            'gradient' => 'from-emerald-500 to-green-600',
            'hover' => 'hover:text-emerald-400',
            'button' => 'hover:border-emerald-500/30'
        ]
    ];
    
    $colors = $colorClasses[$color] ?? $colorClasses['indigo'];
@endphp

<div class="bg-gray-800/50 backdrop-blur rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[calc(100vh-200px)] border border-gray-700/50 {{ $colors['border'] }} transition-all duration-300">
    <!-- Header -->
    <div class="bg-gradient-to-br {{ $colors['gradient'] }} p-6">
        <h3 class="text-2xl font-bold text-white flex items-center gap-3">
            <span>{{ $title }}</span>
        </h3>
    </div>
    
    <!-- Card Info -->
    <div class="px-4 py-3 border-b border-gray-700/50 bg-gray-800/30">
        <div class="flex items-center justify-between text-gray-400">
            <div class="flex items-center gap-2">
                {!! $icon !!}
                <span class="text-xs font-medium text-gray-500">{{ $items->count() }} tasks</span>
            </div>
        </div>
    </div>
    
    <!-- Tasks Area -->
    <div class="flex-1 overflow-y-auto p-4 space-y-2 scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-transparent">
        {{ $slot }}
    </div>
    
    <!-- Add Card Button -->
    <div class="p-4 border-t border-gray-700/50 bg-gray-800/30">
        <button @click="openAddModal('{{ $status }}')" class="w-full flex items-center justify-center gap-2 text-gray-400 {{ $colors['hover'] }} hover:bg-gray-700/50 rounded-lg py-2.5 transition-all duration-200 group">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="font-medium">Add Task</span>
        </button>
    </div>
</div>
