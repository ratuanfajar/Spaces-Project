<!-- Detail/Edit Task Modal -->
<div x-show="showDetailModal" x-cloak @click.self="showDetailModal = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
    <div @click.away="showDetailModal = false" class="bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6 border border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-white">Task Details</h3>
            <button @click="showDetailModal = false" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form x-ref="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Task Title</label>
                <input type="text" name="title" x-model="editingTask.title" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="Enter task title...">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" x-model="editingTask.description" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none" placeholder="Enter task description..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select name="status" x-model="editingTask.status" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    <option value="todo">To Do</option>
                    <option value="doing">In Progress</option>
                    <option value="done">Completed</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Due Date</label>
                <input type="date" name="due_date" x-model="editingTask.due_date" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all [&::-webkit-calendar-picker-indicator]:invert">
            </div>

            <div class="pt-2 border-t border-gray-700">
                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                    <span>Created: <span x-text="editingTask.created_at"></span></span>
                    <span>Updated: <span x-text="editingTask.updated_at"></span></span>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="button" @click="showDetailModal = false" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2.5 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="button" @click="deleteTaskFromModal()" class="bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors">
                    Delete
                </button>
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
