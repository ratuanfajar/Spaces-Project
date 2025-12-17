<?php

namespace App\Http\Controllers;

use App\Models\FocusSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FocusController extends Controller
{
    public function index(): View
    {
        // Ambil data sesi HANYA hari ini (PostgreSQL compatible)
        $sessions = FocusSession::where('user_id', Auth::id())
            ->whereDate('created_at', now()->today()) 
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik sederhana buat dikirim ke View
        $stats = [
            'count' => $sessions->where('mode', 'focus')->count(),
            'total_minutes' => $sessions->where('mode', 'focus')->sum('duration')
        ];

        // Format data agar mudah dibaca Alpine.js
        $history = $sessions->map(function($session) {
            return [
                'task' => $session->task,
                'time' => $session->duration,
                'mode' => $session->mode,
                'timestamp' => $session->created_at->format('H:i') 
            ];
        });

        return view('focus.index', compact('history', 'stats'));
    }

    // Method baru untuk Simpan Data via AJAX
    public function store(Request $request)
    {
        $request->validate([
            'duration' => 'required|integer',
            'mode' => 'required|string',
        ]);

        FocusSession::create([
            'user_id' => Auth::id(),
            'task' => $request->task ?? 'Untitled Session',
            'duration' => $request->duration, 
            'mode' => $request->mode
        ]);

        return response()->json(['status' => 'success']);
    }
}