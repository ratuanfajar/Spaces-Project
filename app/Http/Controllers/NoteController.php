<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(): View
    {
        $notes = Note::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();
        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if (!$request->title && !$request->content && !$request->hasFile('image')) {
            return redirect()->back()->with('error', 'Note cannot be empty!');
        }

        $data = [
            'user_id' => Auth::id(),
            'title'   => $request->title,
            'content' => $request->content,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('notes_images', 'public');
        }

        Note::create($data);

        return redirect()->route('notes')->with('success', 'Note created successfully!');
    }

    // --- TAMBAHKAN METHOD UPDATE INI ---
    public function update(Request $request, Note $note)
    {
        // 1. Validasi
        $request->validate([
            'title'   => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // 2. Security Check (Pastikan punya user sendiri)
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        // 3. Siapkan Data Update
        $data = [
            'title'   => $request->title,
            'content' => $request->content,
        ];

        // 4. Handle Ganti Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama dulu biar gak nyampah
            if ($note->image) {
                Storage::disk('public')->delete($note->image);
            }
            // Upload baru
            $data['image'] = $request->file('image')->store('notes_images', 'public');
        }

        // 5. Update Database
        $note->update($data);

        return redirect()->route('notes')->with('success', 'Note updated successfully!');
    }

    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        if ($note->image) {
            Storage::disk('public')->delete($note->image);
        }

        $note->delete();

        return redirect()->route('notes')->with('success', 'Note deleted!');
    }
}