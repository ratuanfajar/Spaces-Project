@props(['todo', 'status'])

@php
    $statusConfig = [
        'todo' => [
            'badge' => 'bg-indigo-500/10 border-indigo-500/20 text-indigo-400',
            'border' => 'hover:border-indigo-500/30',
            'button' => 'border-indigo-500 hover:bg-indigo-500/20'
        ],
        'doing' => [
            'badge' => 'bg-amber-500/10 border-amber-500/20 text-amber-400',
            'border' => 'hover:border-amber-500/30',
            'button' => 'border-amber-500 hover:bg-amber-500/20'
        ],
        'done' => [
            'badge' => 'bg-gray-500/10 border-gray-500/20 text-gray-500',
            'border' => 'hover:border-emerald-500/30',
            'button' => 'bg-emerald-500 hover:bg-emerald-600'
        ]
    ];
    
    $config = $statusConfig[$status] ?? $statusConfig['todo'];
@endphp

<div class="bg-gray-700/50 hover:bg-gray-700 p-4 rounded-xl border border-gray-600/30 {{ $config['border'] }} transition-all duration-200 group cursor-pointer" 
     @click="openDetailModal({
         id: {{ $todo->id }},
         title: {{ Js::from($todo->title) }},
         description: {{ Js::from($todo->description) }},
         status: '{{ $todo->status }}',
         due_date: '{{ $todo->due_date ? $todo->due_date->format('Y-m-d') : '' }}',
         created_at: '{{ $todo->created_at->diffForHumans() }}',
         updated_at: '{{ $todo->updated_at->diffForHumans() }}'
     })">
    <div class="flex items-start gap-3">
        <!-- Status Button -->
        @if($status === 'todo')
            <div class="mt-0.5">
                <button @click.stop="updateStatus({{ $todo->id }}, 'doing')" class="w-5 h-5 rounded border-2 {{ $config['button'] }} transition-colors"></button>
            </div>
        @elseif($status === 'doing')
            <div class="mt-0.5 flex gap-1">
                <button @click.stop="updateStatus({{ $todo->id }}, 'todo')" class="w-5 h-5 rounded border-2 {{ $config['button'] }} transition-colors">
                    <svg class="w-3 h-3 text-amber-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>
        @else
            <div class="mt-0.5">
                <button @click.stop="updateStatus({{ $todo->id }}, 'doing')" class="w-5 h-5 rounded {{ $config['button'] }} transition-colors flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </div>
        @endif
        
        <!-- Task Content -->
        <div class="flex-1">
            <p class="{{ $status === 'done' ? 'text-gray-400 line-through' : 'text-gray-200' }} font-medium group-hover:{{ $status === 'done' ? 'text-gray-300' : 'text-white' }} transition-colors">
                {{ $todo->title }}
            </p>
            
            @if($todo->description)
                <p class="text-xs text-gray-500 mt-1 {{ $status === 'done' ? 'line-through' : '' }}">
                    {{ $todo->description }}
                </p>
            @endif
            
            <!-- Due Date Badge -->
            @if($todo->due_date && $status !== 'done')
                <div class="mt-2 inline-flex items-center gap-2 {{ $config['badge'] }} border px-2 py-1 rounded-full text-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">{{ $todo->due_date->format('M d, Y') }}</span>
                </div>
            @endif
            
            <!-- Timestamp Badge -->
            @if($status === 'done')
                <div class="mt-2 inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full text-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">{{ $todo->completed_at ? $todo->completed_at->format('M d, Y') : $todo->updated_at->format('M d, Y') }}</span>
                </div>
            @else
                <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $status === 'todo' ? $todo->created_at->diffForHumans() : $todo->updated_at->diffForHumans() }}</span>
                </div>
            @endif
        </div>
    </div>
</div>
