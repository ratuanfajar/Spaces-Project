<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-gray-400">Here's what's happening with your productivity today</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Focus Stats -->
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <a href="{{ route('focus') }}" class="text-white/80 hover:text-white text-sm transition-colors">View →</a>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Today's Focus Time</h3>
                    <p class="text-3xl font-bold text-white mb-1">{{ gmdate('H:i', $todayFocusTime) }}</p>
                    <p class="text-white/70 text-xs">{{ $totalFocusSessions }} total sessions</p>
                </div>

                <!-- Todo Stats -->
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <a href="{{ route('todo') }}" class="text-white/80 hover:text-white text-sm transition-colors">View →</a>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Active Tasks</h3>
                    <p class="text-3xl font-bold text-white mb-1">{{ $todoStats['todo'] + $todoStats['doing'] }}</p>
                    <p class="text-white/70 text-xs">{{ $todoStats['done'] }} completed tasks</p>
                </div>

                <!-- Calendar Stats -->
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <a href="{{ route('calendar') }}" class="text-white/80 hover:text-white text-sm transition-colors">View →</a>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Events This Week</h3>
                    <p class="text-3xl font-bold text-white mb-1">{{ $thisWeekEvents }}</p>
                    <p class="text-white/70 text-xs">{{ $todayEvents }} events today</p>
                </div>

                <!-- Notes Stats -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <a href="{{ route('notes') }}" class="text-white/80 hover:text-white text-sm transition-colors">View →</a>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Total Notes</h3>
                    <p class="text-3xl font-bold text-white mb-1">{{ $totalNotes }}</p>
                    <p class="text-white/70 text-xs">Keep your ideas organized</p>
                </div>
            </div>



            <!-- Content Grid with Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Charts -->
                <div class="space-y-6">
                    <!-- Weekly Focus Chart -->
                    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-xl">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Weekly Focus Activity
                        </h3>
                        <div class="flex items-end justify-between h-48 gap-2">
                            @foreach($weeklyFocusData as $day)
                                <div class="flex-1 flex flex-col items-center gap-2">
                                    <div class="w-full bg-gray-700 rounded-lg overflow-hidden relative" style="height: 160px;">
                                        <div class="absolute bottom-0 w-full bg-gradient-to-t from-indigo-500 to-indigo-400 rounded-lg transition-all duration-500 hover:from-indigo-400 hover:to-indigo-300" 
                                             style="height: {{ $day['minutes'] > 0 ? min(($day['minutes'] / 120) * 100, 100) : 0 }}%"
                                             title="{{ $day['minutes'] }} minutes">
                                        </div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-xs font-bold text-white/90">{{ $day['minutes'] }}m</span>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400 font-medium">{{ $day['date'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Task Distribution Chart -->
                    @if($totalTodos > 0)
                        <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-xl">
                            <h3 class="text-lg font-semibold text-white mb-6">Task Distribution</h3>
                            <div class="flex items-center justify-center mb-6">
                                <div class="relative w-48 h-48">
                                    <div class="w-full h-full rounded-full" style="background: conic-gradient(
                                        from 0deg,
                                        #6366f1 0deg {{ ($todoStats['todo'] / $totalTodos * 360) }}deg,
                                        #f59e0b {{ ($todoStats['todo'] / $totalTodos * 360) }}deg {{ (($todoStats['todo'] + $todoStats['doing']) / $totalTodos * 360) }}deg,
                                        #10b981 {{ (($todoStats['todo'] + $todoStats['doing']) / $totalTodos * 360) }}deg 360deg
                                    );">
                                    </div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-28 h-28 bg-gray-800 rounded-full flex flex-col items-center justify-center">
                                            <span class="text-3xl font-bold text-white">{{ $totalTodos }}</span>
                                            <span class="text-xs text-gray-400">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-indigo-500"></div>
                                        <span class="text-sm text-gray-300">Todo</span>
                                    </div>
                                    <span class="text-sm font-medium text-white">{{ $todoStats['todo'] }} ({{ $totalTodos > 0 ? round($todoStats['todo'] / $totalTodos * 100) : 0 }}%)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                        <span class="text-sm text-gray-300">Doing</span>
                                    </div>
                                    <span class="text-sm font-medium text-white">{{ $todoStats['doing'] }} ({{ $totalTodos > 0 ? round($todoStats['doing'] / $totalTodos * 100) : 0 }}%)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                        <span class="text-sm text-gray-300">Done</span>
                                    </div>
                                    <span class="text-sm font-medium text-white">{{ $todoStats['done'] }} ({{ $totalTodos > 0 ? round($todoStats['done'] / $totalTodos * 100) : 0 }}%)</span>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Middle Column: Events & Metrics -->
                <div class="space-y-6">
                    <!-- Upcoming Events -->
                    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Upcoming Events
                            </h3>
                            <a href="{{ route('calendar') }}" class="text-emerald-400 hover:text-emerald-300 text-sm">View All</a>
                        </div>
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse($upcomingEvents as $event)
                                <div class="flex items-start gap-3 p-3 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-colors">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center text-white font-bold text-sm" style="background-color: {{ $event->color }};">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('d') }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-white font-medium truncate">{{ $event->title }}</h4>
                                        <p class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y  H:i') }}</p>
                                        @if($event->location)
                                            <p class="text-gray-500 text-xs mt-1"> {{ $event->location }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-400">No upcoming events</p>
                                    <a href="{{ route('calendar') }}" class="text-emerald-400 text-sm mt-2 inline-block">Create one </a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Productivity Metrics -->
                    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-xl">
                        <h3 class="text-lg font-semibold text-white mb-4">Productivity Metrics</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-300">Total Focus Time</span>
                                    <span class="text-indigo-400 font-medium">{{ gmdate('H:i', $totalFocusTime) }}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-400 h-2 rounded-full" style="width: {{ min(($totalFocusTime / 3600) * 10, 100) }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-300">Completion Rate</span>
                                    <span class="text-emerald-400 font-medium">{{ $totalTodos > 0 ? round($todoStats['done'] / $totalTodos * 100) : 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-2 rounded-full" style="width: {{ $totalTodos > 0 ? ($todoStats['done'] / $totalTodos * 100) : 0 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-300">Active Tasks</span>
                                    <span class="text-amber-400 font-medium">{{ $todoStats['todo'] + $todoStats['doing'] }}/{{ $totalTodos }}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-amber-500 to-amber-400 h-2 rounded-full" style="width: {{ $totalTodos > 0 ? (($todoStats['todo'] + $todoStats['doing']) / $totalTodos * 100) : 0 }}%"></div>
                                </div>
                            </div>
                            @if($overdueTodos > 0)
                                <div class="mt-4 p-3 bg-red-500/10 border border-red-500/20 rounded-xl">
                                    <p class="text-red-400 text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $overdueTodos }} overdue {{ Str::plural('task', $overdueTodos) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Recent Activities -->
                <div class="space-y-6">
                    <!-- Recent Tasks -->
                    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Recent Tasks
                            </h3>
                            <a href="{{ route('todo') }}" class="text-amber-400 hover:text-amber-300 text-sm">View All</a>
                        </div>
                        <div class="space-y-2 max-h-80 overflow-y-auto">
                            @forelse($recentTodos as $todo)
                                <div class="flex items-start gap-3 p-3 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-colors">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-5 h-5 rounded border-2 {{ $todo->status === 'done' ? 'bg-emerald-500 border-emerald-500' : 'border-gray-500' }}"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-white font-medium truncate">{{ $todo->title }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                @if($todo->status === 'todo') bg-indigo-500/20 text-indigo-400
                                                @elseif($todo->status === 'doing') bg-amber-500/20 text-amber-400
                                                @else bg-emerald-500/20 text-emerald-400
                                                @endif">
                                                {{ ucfirst($todo->status) }}
                                            </span>
                                            @if($todo->due_date)
                                                <span class="text-gray-500 text-xs"> {{ \Carbon\Carbon::parse($todo->due_date)->format('M d') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-gray-400">No tasks yet</p>
                                    <a href="{{ route('todo') }}" class="text-amber-400 text-sm mt-2 inline-block">Create one </a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Notes -->
                    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Recent Notes
                            </h3>
                            <a href="{{ route('notes') }}" class="text-purple-400 hover:text-purple-300 text-sm">View All</a>
                        </div>
                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @forelse($recentNotes as $note)
                                <div class="p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-colors">
                                    <h4 class="text-white font-medium mb-1 truncate">{{ $note->title }}</h4>
                                    @if($note->content)
                                        <p class="text-gray-400 text-sm line-clamp-2">{{ Str::limit(strip_tags($note->content), 100) }}</p>
                                    @endif
                                    <p class="text-gray-500 text-xs mt-2">{{ $note->updated_at->diffForHumans() }}</p>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <p class="text-gray-400">No notes yet</p>
                                    <a href="{{ route('notes') }}" class="text-purple-400 text-sm mt-2 inline-block">Create one </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
