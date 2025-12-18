<x-app-layout>
    {{-- Load CSS & JS EasyMDE --}}
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div x-data="notesApp()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- KOLOM INPUT --}}
            <div class="lg:col-span-12">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xl font-bold text-indigo-400 pl-1" x-text="isEditing ? 'Edit Note' : 'Add a Note'"></h3>
                    </div>
                    <button x-show="isEditing" @click="cancelEdit()" class="text-sm text-red-400 hover:text-red-300 underline transition" style="display: none;">
                        Cancel Editing
                    </button>
                </div>

                <div class="relative z-10 group">
                    <form :action="isEditing ? '{{ url('notes') }}/' + form.id : '{{ route('notes.store') }}'" 
                          method="POST" 
                          enctype="multipart/form-data"
                          id="noteForm"
                          class="relative z-10 bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
                        
                        @csrf
                        <input type="hidden" name="_method" :value="isEditing ? 'PUT' : 'POST'">

                        <div class="p-4">
                            {{-- Input Title --}}
                            <div class="mb-4">
                                <input type="text" 
                                       name="title" 
                                       x-model="form.title" 
                                       placeholder="Title..." 
                                       class="w-full bg-transparent border-none text-3xl font-bold text-white placeholder-slate-600 px-2 pt-2 focus:ring-0 transition-colors">
                            </div>

                            {{-- Editor Area --}}
                            <textarea id="my-editor" name="content"></textarea>
                        </div>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between px-6 py-4 bg-slate-950/50 border-t border-slate-800/50">
                            <div class="flex items-center gap-2">
                                <button type="button" @click="$refs.fileInput.click()" class="text-slate-400 hover:text-indigo-400 flex items-center gap-2 text-sm font-medium transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Add Cover Image</span>
                                </button>
                                <input type="file" name="image" x-ref="fileInput" class="hidden" @change="fileChosen">
                                <span x-show="imagePreview" class="text-xs text-emerald-400 ml-2" x-text="'Image selected'"></span>
                            </div>

                            <button type="submit" 
                                    class="px-8 py-2.5 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40"
                                    :class="isEditing ? 'bg-emerald-600 hover:bg-emerald-500' : 'bg-indigo-600 hover:bg-indigo-500'">
                                <span x-text="isEditing ? 'Update Note' : 'Save Note'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- LIST NOTES --}}
            <div class="lg:col-span-12 mt-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-1 h-6 bg-indigo-500 rounded-full"></div>
                    <h3 class="text-xl font-semibold text-white">My Notes</h3>
                </div>

                @if(isset($notes) && $notes->count() > 0)
                    {{-- PERUBAHAN: Gunakan 'grid' bukan 'columns' agar rapi sejajar --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($notes as $note)
                            {{-- Tambahkan 'h-full' agar tinggi kartu sama rata dalam satu baris --}}
                            <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-slate-600 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative flex flex-col h-full">
                                
                                @if($note->image)
                                    <div class="w-full h-32 overflow-hidden border-b border-slate-800 relative flex-shrink-0">
                                        <img src="{{ asset('storage/' . $note->image) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                    </div>
                                @endif

                                <div class="p-6 flex flex-col flex-grow">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="font-bold text-lg text-slate-200 leading-tight pr-2 line-clamp-1">
                                            {{ $note->title ?: 'Untitled' }}
                                        </h4>
                                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex-shrink-0">
                                            <button @click="editNote({{ json_encode($note) }})" class="text-slate-400 hover:text-indigo-400 transition" title="Edit">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </button>
                                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Delete this note?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-red-400 transition" title="Delete">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Konten Note dengan Line Clamp (Agar tidak terlalu panjang) --}}
                                    <div class="text-slate-400 text-sm leading-relaxed mb-4 line-clamp-4 markdown-preview flex-grow">
                                        {!! Str::markdown($note->content ?? '') !!}
                                    </div>

                                    <div class="mt-auto pt-3 border-t border-slate-800/50">
                                        <span class="text-xs text-slate-500 font-medium">{{ $note->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-20 text-center opacity-50 border-2 border-dashed border-slate-800 rounded-3xl bg-slate-900/50">
                        <p class="text-slate-400 text-lg font-medium">No notes created yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const easyMDE = new EasyMDE({
            element: document.getElementById('my-editor'),
            spellChecker: false,
            status: false,
            placeholder: "Type here...",
            toolbar: [
                "bold", "italic", "strikethrough", "|",
                {
                    name: "heading-1",
                    action: EasyMDE.toggleHeading1,
                    className: "fa custom-icon h1", 
                    title: "Heading 1",
                },
                {
                    name: "heading-2",
                    action: EasyMDE.toggleHeading2,
                    className: "fa custom-icon h2", 
                    title: "Heading 2",
                },
                {
                    name: "heading-3",
                    action: EasyMDE.toggleHeading3,
                    className: "fa custom-icon h3", 
                    title: "Heading 3",
                },
                "|", "quote", "unordered-list", "ordered-list", "|", "link", "code", "table",
            ],
            minHeight: "500px", 
        });

        function notesApp() {
            return {
                isEditing: false,
                form: {
                    id: null,
                    title: '',
                },
                imagePreview: null,

                editNote(note) {
                    this.isEditing = true;
                    this.form.id = note.id;
                    this.form.title = note.title;
                    this.imagePreview = null;
                    easyMDE.value(note.content || '');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                cancelEdit() {
                    this.isEditing = false;
                    this.form.id = null;
                    this.form.title = '';
                    this.imagePreview = null;
                    if(this.$refs.fileInput) this.$refs.fileInput.value = '';
                    easyMDE.value('');
                },

                fileChosen(event) {
                    const file = event.target.files[0];
                    if (file) this.imagePreview = true; 
                }
            }
        }
    </script>

    <style>
        /* === PERBAIKAN DARK MODE EASYMDE === */
        
        /* 1. Paksa Editor jadi Gelap */
        .CodeMirror {
            background-color: #0f172a !important; /* Slate-900 */
            color: #e2e8f0 !important; /* Slate-200 */
            border-color: #334155 !important;
            border-radius: 0 0 0.5rem 0.5rem !important;
            padding: 1rem !important;
            font-size: 1rem;
            line-height: 1.6;
            height: 500px !important;
        }
        
        /* 2. Scrollbar Dark Mode */
        .CodeMirror-scroll {
            min-height: 500px !important;
            max-height: 500px !important;
            overflow-y: auto !important;
        }
        .CodeMirror-scroll::-webkit-scrollbar { width: 8px; }
        .CodeMirror-scroll::-webkit-scrollbar-track { background: #0f172a; }
        .CodeMirror-scroll::-webkit-scrollbar-thumb { background-color: #334155; border-radius: 4px; }

        /* 3. Toolbar Dark Mode */
        .EasyMDEContainer { background-color: transparent; }
        .editor-toolbar {
            background-color: #1e293b !important; /* Slate-800 */
            border-color: #334155 !important;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        .editor-toolbar i { color: #cbd5e1 !important; }
        .editor-toolbar button:hover { background-color: #334155 !important; }
        .editor-toolbar button.active { background-color: #475569 !important; }
        
        /* 4. Cursor Color */
        .CodeMirror-cursor { border-left: 1px solid #6366f1 !important; }

        /* === PERBAIKAN ICON H1 H2 H3 === */
        .editor-toolbar i.custom-icon {
            font-family: inherit !important;
            font-style: normal !important;
            font-weight: 800 !important;
            font-size: 13px !important;
            width: auto !important;
            display: inline-block;
            line-height: 1;
        }
        .editor-toolbar i.h1::before { content: "H1"; }
        .editor-toolbar i.h2::before { content: "H2"; }
        .editor-toolbar i.h3::before { content: "H3"; }
        
        /* Separator Line */
        .editor-toolbar i.separator {
            border-right-color: #475569 !important;
            border-left-color: transparent !important;
            margin: 0 6px !important;
        }

        /* === PREVIEW CARD === */
        .markdown-preview h1 { font-size: 1.25rem; font-weight: 700; color: #fff; margin: 0.5rem 0; border-bottom: 1px solid #334155; padding-bottom: 0.2rem;}
        .markdown-preview h2 { font-size: 1.1rem; font-weight: 600; color: #e2e8f0; margin: 0.5rem 0; }
        .markdown-preview ul { list-style-type: disc; padding-left: 1.2rem; }
        .markdown-preview code { background: #1e293b; padding: 2px 4px; border-radius: 4px; font-family: monospace; color: #f472b6; }
    </style>
</x-app-layout>