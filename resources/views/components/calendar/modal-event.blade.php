<!-- Add/Edit Event Modal -->
<div x-show="showModal" x-cloak @click.self="showModal = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
    <div @click.away="showModal = false" class="bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl p-6 border border-gray-700 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">
                <span x-text="editingEvent.id ? 'Edit Event' : 'Add New Event'"></span>
            </h3>
            <button @click="showModal = false" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form x-ref="eventForm" :action="editingEvent.id ? `/calendar/${editingEvent.id}` : '/calendar'" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" x-bind:value="editingEvent.id ? 'PATCH' : 'POST'">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Event Title *</label>
                    <input type="text" name="title" x-model="editingEvent.title" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="Enter event title...">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Type *</label>
                    <select name="type" x-model="editingEvent.type" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        <option value="event">Event</option>
                        <option value="task">Task</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Start Time *</label>
                    <input type="datetime-local" name="start_time" x-model="editingEvent.start_time" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all [&::-webkit-calendar-picker-indicator]:invert">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">End Time *</label>
                    <input type="datetime-local" name="end_time" x-model="editingEvent.end_time" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all [&::-webkit-calendar-picker-indicator]:invert">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea name="description" x-model="editingEvent.description" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none" placeholder="Enter event description..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Location</label>
                    <input type="text" name="location" x-model="editingEvent.location" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="e.g., Meeting Room A">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Color</label>
                    <input type="color" name="color" x-model="editingEvent.color" class="w-full h-10 bg-gray-700 border border-gray-600 rounded-lg cursor-pointer">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Guests (Optional)</label>
                    <div class="space-y-2">
                        <template x-for="(guest, index) in editingEvent.guests" :key="index">
                            <div class="flex gap-2">
                                <input type="text" :name="`guests[${index}]`" x-model="editingEvent.guests[index]" class="flex-1 bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-indigo-500" placeholder="Email or name">
                                <button type="button" @click="removeGuest(index)" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="addGuest()" class="w-full px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-300 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Guest
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-700">
                <button type="button" @click="showModal = false" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2.5 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="button" x-show="editingEvent.id" @click="deleteEvent()" class="bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors">
                    Delete
                </button>
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
                    <span x-text="editingEvent.id ? 'Update Event' : 'Create Event'"></span>
                </button>
            </div>
        </form>

        <!-- Hidden Delete Form -->
        <form x-ref="deleteForm" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
