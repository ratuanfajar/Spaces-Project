<!-- Add Task Modal -->
<div x-show="showModal" x-cloak @click.self="showModal = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
    <div @click.away="showModal = false" class="bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6 border border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-white">Add New Task</h3>
            <button @click="showModal = false" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('todo.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="status" x-model="newTaskStatus">
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Task Title</label>
                <input type="text" name="title" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="Enter task title...">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description (Optional)</label>
                <textarea name="description" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none" placeholder="Enter task description..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Due Date (Optional)</label>
                <input type="date" name="due_date" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all [&::-webkit-calendar-picker-indicator]:invert">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" @click="showModal = false" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2.5 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
                    Add Task
                </button>
            </div>
        </form>
    </div>
</div>
