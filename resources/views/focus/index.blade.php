<x-app-layout>
    <div x-data="focusTimer()" x-init="initTimer()" class="max-w-7xl mx-auto h-[calc(100vh-5rem)] overflow-hidden">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 h-full">
            
            <div class="lg:col-span-8 flex flex-col h-full">
                <div class="flex-1 bg-slate-900 border border-slate-800 rounded-3xl p-8 flex flex-col items-center justify-center relative overflow-hidden shadow-2xl">
                    
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="bg-slate-950/50 p-1.5 rounded-full inline-flex mb-12 backdrop-blur-sm border border-slate-800/50">
                        <template x-for="mode in modes">
                            <button @click="switchMode(mode.id)"
                                    :class="currentMode === mode.id ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-slate-800'"
                                    class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 capitalize">
                                <span x-text="mode.label"></span>
                            </button>
                        </template>
                    </div>

                    <div class="relative z-10 mb-8">
                        <div class="text-[8rem] md:text-[10rem] leading-none font-bold text-white tracking-tighter tabular-nums select-none font-mono drop-shadow-2xl">
                            <span x-text="formatTime(timeLeft)"></span>
                        </div>
                    </div>

                    <div class="w-full max-w-md mb-12 relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-indigo-500 group-focus-within:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                        <input type="text" 
                               x-model="currentTask"
                               :disabled="isRunning"
                               placeholder="I want to focus on..." 
                               class="w-full bg-transparent border-0 border-b-2 border-slate-700 text-center text-xl text-slate-200 focus:ring-0 focus:border-indigo-500 placeholder:text-slate-600 transition-all py-3 px-10 disabled:opacity-50"
                        >
                    </div>

                    <div class="flex items-center gap-6 z-20">
                        <button x-show="timeLeft !== originalTime" @click="resetTimer()" x-transition class="p-4 rounded-full text-slate-500 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </button>

                        <button @click="toggleTimer()"
                                :class="isRunning ? 'bg-slate-800 border-slate-700 text-red-400 hover:bg-slate-700 hover:text-red-300' : 'bg-indigo-600 text-white hover:bg-indigo-500 hover:scale-105 shadow-indigo-500/30'"
                                class="w-20 h-20 rounded-2xl flex items-center justify-center shadow-2xl border-t border-white/10 transition-all duration-300">
                            <svg x-show="!isRunning" class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <svg x-show="isRunning" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>

                        <button x-show="timeLeft !== originalTime" @click="completeTimer()" x-transition class="p-4 rounded-full text-slate-500 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 flex flex-col gap-6 h-full overflow-hidden">
                
                <div class="grid grid-cols-2 gap-4 flex-none">
                    <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl">
                        <div class="text-slate-400 text-xs uppercase font-bold tracking-wider mb-1">Today</div>
                        <div class="text-3xl font-bold text-white"><span x-text="sessionsCompleted">0</span> <span class="text-sm font-normal text-slate-500">sess</span></div>
                    </div>
                    <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl">
                        <div class="text-slate-400 text-xs uppercase font-bold tracking-wider mb-1">Focus Time</div>
                        <div class="text-3xl font-bold text-white"><span x-text="totalMinutes">0</span> <span class="text-sm font-normal text-slate-500">m</span></div>
                    </div>
                </div>

                <div class="flex-1 bg-slate-900 border border-slate-800 rounded-3xl p-6 overflow-hidden flex flex-col min-h-0">
                    <h3 class="text-white font-semibold mb-6 flex items-center flex-none">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 mr-3 animate-pulse"></div>
                        Recent Activity
                    </h3>

                    <div class="overflow-y-auto pr-2 space-y-4 custom-scrollbar flex-1">
                        <div x-show="history.length === 0" class="h-full flex flex-col items-center justify-center text-slate-600 opacity-50">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm">No sessions yet</p>
                        </div>

                        <template x-for="(session, index) in history" :key="index">
                            <div class="group flex flex-col bg-slate-950/50 hover:bg-slate-800 border border-slate-800/50 hover:border-slate-700 p-4 rounded-xl transition-all duration-200">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-mono text-slate-500" x-text="session.timestamp"></span>
                                    <span class="text-xs font-bold px-2 py-0.5 rounded text-slate-300 bg-slate-800 border border-slate-700 uppercase tracking-wider" x-text="session.time + 'm'"></span>
                                </div>
                                <div class="font-medium text-slate-200" x-text="session.task || 'Untitled Focus Session'"></div>
                                <div class="mt-2 text-xs text-indigo-400 capitalize flex items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-2"></span>
                                    <span x-text="session.mode"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>

        <audio id="bellSound" src="{{ asset('sounds/bell.mp3') }}" preload="auto"></audio>
    </div>

    <script>
        function focusTimer() {
            return {
                modes: [
                    { id: 'focus', label: 'Focus', minutes: 25 },
                    { id: 'short', label: 'Short Break', minutes: 5 },
                    { id: 'long', label: 'Long Break', minutes: 15 },
                ],
                currentMode: 'focus',
                timeLeft: 25 * 60,
                originalTime: 25 * 60,
                isRunning: false,
                interval: null,
                
                // DATA DARI BACKEND (Database)
                // Ambil data yang dikirim controller lewat variabel $stats dan $history
                sessionsCompleted: {{ $stats['count'] }}, 
                totalMinutes: {{ $stats['total_minutes'] }},
                currentTask: '',
                history: {!! json_encode($history) !!},

                initTimer() {
                    if (Notification.permission !== "granted") {
                        Notification.requestPermission();
                    }
                },

                switchMode(modeId) {
                    this.pauseTimer();
                    this.currentMode = modeId;
                    const mode = this.modes.find(m => m.id === modeId);
                    this.timeLeft = mode.minutes * 60;
                    this.originalTime = this.timeLeft;
                },

                toggleTimer() {
                    if (this.isRunning) {
                        this.pauseTimer();
                    } else {
                        this.startTimer();
                    }
                },

                startTimer() {
                    this.isRunning = true;
                    this.interval = setInterval(() => {
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                        } else {
                            this.completeTimer();
                        }
                    }, 1000);
                },

                pauseTimer() {
                    this.isRunning = false;
                    clearInterval(this.interval);
                },

                resetTimer() {
                    this.pauseTimer();
                    const mode = this.modes.find(m => m.id === this.currentMode);
                    this.timeLeft = mode.minutes * 60;
                },

                completeTimer() {
                    this.pauseTimer();
                    const audio = document.getElementById('bellSound');
                    if(audio) audio.play();

                    // Notifikasi Browser
                    if (Notification.permission === "granted") {
                        new Notification("Spacer Timer", {
                            body: this.currentMode === 'focus' ? "Focus session completed!" : "Break over!",
                            icon: "{{ asset('apple-touch-icon.png') }}"
                        });
                    }

                    // --- LOGIKA PENYIMPANAN KE SERVER ---
                    // Hanya simpan jika mode 'focus' (istirahat tidak perlu dicatat database)
                    if (this.currentMode === 'focus') {
                        const durationMin = this.originalTime / 60;
                        const taskName = this.currentTask;

                        // 1. Update Tampilan Frontend Dulu (Optimistic UI)
                        this.sessionsCompleted++;
                        this.totalMinutes += durationMin;
                        this.history.unshift({
                            task: taskName,
                            time: durationMin,
                            mode: this.currentMode,
                            timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                        });

                        // 2. Kirim Data ke Database (Background Process)
                        fetch("{{ route('focus.store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                            },
                            body: JSON.stringify({
                                task: taskName,
                                duration: durationMin,
                                mode: this.currentMode
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                console.error("Gagal menyimpan sesi.");
                            }
                        })
                        .catch(error => console.error("Error:", error));
                    }
                },

                formatTime(seconds) {
                    const m = Math.floor(seconds / 60);
                    const s = seconds % 60;
                    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                }
            }
        }
    </script>
</x-app-layout>