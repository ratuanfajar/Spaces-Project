<x-app-layout>
    <div x-data="calendarApp()" class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-white">Calendar</h2>
                <p class="text-slate-400 mt-1">Manage your schedule effectively</p>
            </div>
            <div class="flex gap-3">
                <button @click="showImportModal = true" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Import from To-Do
                </button>
                <button @click="openAddModal()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Event
                </button>
            </div>
        </div>

        <!-- Calendar Container -->
        <div class="bg-slate-900 rounded-2xl shadow-xl border border-slate-800 p-6">
            <div id="calendar"></div>
        </div>

        <!-- Add/Edit Event Modal -->
        <x-calendar.modal-event />

        <!-- Import from Todo Modal -->
        <x-calendar.modal-import-todo :todos="$todos" />
    </div>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <script>
        function calendarApp() {
            return {
                showModal: false,
                showImportModal: false,
                calendar: null,
                editingEvent: {
                    id: null,
                    title: '',
                    description: '',
                    type: 'event',
                    start_time: '',
                    end_time: '',
                    location: '',
                    color: '#3B82F6',
                    guests: []
                },

                init() {
                    this.$nextTick(() => {
                        this.initCalendar();
                    });
                },

                initCalendar() {
                    const calendarEl = document.getElementById('calendar');
                    
                    this.calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridDay'
                        },
                        themeSystem: 'standard',
                        height: 'auto',
                        timeZone: 'Asia/Jakarta',
                        locale: 'id',
                        events: '/calendar/events',
                        eventClick: (info) => {
                            this.openEditModal(info.event);
                        },
                        dateClick: (info) => {
                            this.openAddModal(info.dateStr);
                        },
                        slotLabelFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        },
                        eventTimeFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        },
                        slotMinTime: '06:00:00',
                        slotMaxTime: '22:00:00',
                        allDaySlot: false
                    });
                    
                    this.calendar.render();
                },

                openAddModal(date = null) {
                    const now = new Date();
                    const startTime = date ? `${date}T09:00` : now.toISOString().slice(0, 16);
                    const endTime = date ? `${date}T10:00` : new Date(now.getTime() + 3600000).toISOString().slice(0, 16);

                    this.editingEvent = {
                        id: null,
                        title: '',
                        description: '',
                        type: 'event',
                        start_time: startTime,
                        end_time: endTime,
                        location: '',
                        color: '#3B82F6',
                        guests: []
                    };
                    this.showModal = true;
                },

                openEditModal(event) {
                    this.editingEvent = {
                        id: event.id,
                        title: event.title,
                        description: event.extendedProps.description || '',
                        type: event.extendedProps.type,
                        start_time: event.extendedProps.start_time,
                        end_time: event.extendedProps.end_time,
                        location: event.extendedProps.location || '',
                        color: event.backgroundColor,
                        guests: event.extendedProps.guests || []
                    };
                    this.showModal = true;

                    this.$nextTick(() => {
                        this.$refs.eventForm.action = `/calendar/${event.id}`;
                    });
                },

                deleteEvent() {
                    if (confirm('Are you sure you want to delete this event?')) {
                        const form = this.$refs.deleteForm;
                        form.action = `/calendar/${this.editingEvent.id}`;
                        form.submit();
                    }
                },

                addGuest() {
                    this.editingEvent.guests.push('');
                },

                removeGuest(index) {
                    this.editingEvent.guests.splice(index, 1);
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }

        /* FullCalendar Dark Theme */
        #calendar {
            --fc-border-color: #1e293b;
            --fc-button-bg-color: #4f46e5;
            --fc-button-border-color: #4f46e5;
            --fc-button-hover-bg-color: #4338ca;
            --fc-button-hover-border-color: #4338ca;
            --fc-button-active-bg-color: #3730a3;
            --fc-button-active-border-color: #3730a3;
            --fc-today-bg-color: rgba(79, 70, 229, 0.1);
        }

        .fc {
            color: #cbd5e1;
        }

        .fc .fc-button {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }

        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            color: #fff;
            font-weight: 700;
        }

        .fc .fc-col-header-cell {
            background: #1e293b;
            color: #94a3b8;
            font-weight: 600;
            padding: 0.75rem 0;
        }

        .fc .fc-daygrid-day {
            background: #0f172a;
        }

        .fc .fc-daygrid-day:hover {
            background: #1e293b;
            cursor: pointer;
        }

        .fc .fc-daygrid-day-number {
            color: #cbd5e1;
            padding: 0.5rem;
        }

        .fc .fc-event {
            border: none;
            padding: 2px 4px;
            margin: 1px 2px;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .fc .fc-event:hover {
            opacity: 0.8;
        }
    </style>
</x-app-layout>