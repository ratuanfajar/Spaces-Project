<x-app-layout>
    <div x-data="todoApp()" class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-white">To Do List</h2>
                <p class="text-slate-400 mt-1">Organize and manage your tasks efficiently</p>
            </div>
        </div>

        <!-- Kanban Board -->
        <div class="grid grid-cols-3 gap-6 w-full">
            
            <!-- To Do Column -->
            <x-todo.kanban-column 
                title="To Do" 
                status="todo" 
                :items="$todoItems" 
                color="indigo">
                <x-slot:icon>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </x-slot:icon>
                
                @forelse($todoItems as $todo)
                    <x-todo.task-card :todo="$todo" status="todo" />
                @empty
                    <p class="text-gray-500 text-center py-8 text-sm">No tasks yet</p>
                @endforelse
            </x-todo.kanban-column>

            <!-- In Progress Column -->
            <x-todo.kanban-column 
                title="In Progress" 
                status="doing" 
                :items="$doingItems" 
                color="amber">
                <x-slot:icon>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </x-slot:icon>
                
                @forelse($doingItems as $todo)
                    <x-todo.task-card :todo="$todo" status="doing" />
                @empty
                    <p class="text-gray-500 text-center py-8 text-sm">No tasks in progress</p>
                @endforelse
            </x-todo.kanban-column>

            <!-- Completed Column -->
            <x-todo.kanban-column 
                title="Completed" 
                status="done" 
                :items="$doneItems" 
                color="emerald">
                <x-slot:icon>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </x-slot:icon>
                
                @forelse($doneItems as $todo)
                    <x-todo.task-card :todo="$todo" status="done" />
                @empty
                    <p class="text-gray-500 text-center py-8 text-sm">No completed tasks</p>
                @endforelse
            </x-todo.kanban-column>

        </div>

        <!-- Modals -->
        <x-todo.modal-edit />
        <x-todo.modal-add />

        <!-- Hidden Forms for Status Update and Delete -->
        <form x-ref="updateForm" method="POST" class="hidden">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" x-model="updateStatusValue">
        </form>

        <form x-ref="deleteForm" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        function todoApp() {
            return {
                showModal: false,
                showDetailModal: false,
                newTaskStatus: 'todo',
                updateStatusValue: '',
                editingTask: {
                    id: null,
                    title: '',
                    description: '',
                    status: 'todo',
                    due_date: '',
                    created_at: '',
                    updated_at: ''
                },

                openAddModal(status) {
                    this.newTaskStatus = status;
                    this.showModal = true;
                },

                openDetailModal(task) {
                    this.editingTask = {
                        id: task.id,
                        title: task.title,
                        description: task.description || '',
                        status: task.status,
                        due_date: task.due_date || '',
                        created_at: task.created_at,
                        updated_at: task.updated_at
                    };
                    this.showDetailModal = true;
                    
                    // Set form action after modal opens
                    this.$nextTick(() => {
                        this.$refs.editForm.action = `/todo/${task.id}`;
                    });
                },

                updateStatus(todoId, status) {
                    this.updateStatusValue = status;
                    const form = this.$refs.updateForm;
                    form.action = `/todo/${todoId}`;
                    form.submit();
                },

                deleteTaskFromModal() {
                    if (confirm('Are you sure you want to delete this task?')) {
                        const form = this.$refs.deleteForm;
                        form.action = `/todo/${this.editingTask.id}`;
                        form.submit();
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>
