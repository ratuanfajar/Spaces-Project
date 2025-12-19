@props(['todos'])

<!-- Import from Todo Modal -->
<div x-show="showImportModal" x-cloak @click.self="showImportModal = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
    <div @click.away="showImportModal = false" class="bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg p-6 border border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-white">Import Tasks from To-Do</h3>
            <button @click="showImportModal = false" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('calendar.import-todos') }}" method="POST">
            @csrf
            
            @if($todos->count() > 0)
                <div class="space-y-2 mb-4 max-h-96 overflow-y-auto">
                    @foreach($todos as $todo)
                        <label class="flex items-start gap-3 p-3 bg-gray-700/50 rounded-lg hover:bg-gray-700 transition-colors cursor-pointer">
                            <input type="checkbox" name="todo_ids[]" value="{{ $todo->id }}" class="mt-1 w-4 h-4 rounded border-gray-600 bg-gray-700 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-gray-800">
                            <div class="flex-1">
                                <p class="text-white font-medium">{{ $todo->title }}</p>
                                @if($todo->description)
                                    <p class="text-xs text-gray-400 mt-1">{{ Str::limit($todo->description, 80) }}</p>
                                @endif
                                @if($todo->due_date)
                                    <div class="mt-2 inline-flex items-center gap-1 text-xs text-amber-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $todo->due_date->format('M d, Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-700">
                    <button type="button" @click="showImportModal = false" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2.5 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white font-medium py-2.5 rounded-lg transition-colors">
                        Import Selected
                    </button>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="text-gray-400">No tasks with due dates available to import.</p>
                    <p class="text-sm text-gray-500 mt-2">Add due dates to your tasks in the To-Do list first.</p>
                </div>
            @endif
        </form>
    </div>
</div>
