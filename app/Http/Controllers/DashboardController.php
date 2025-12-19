<?php

namespace App\Http\Controllers;

use App\Models\FocusSession;
use App\Models\Todo;
use App\Models\CalendarEvent;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();
        
        // Focus Statistics
        $focusSessions = FocusSession::where('user_id', $userId)->get();
        $totalFocusSessions = $focusSessions->count();
        $totalFocusTime = $focusSessions->sum('duration'); // in seconds
        $todayFocusTime = FocusSession::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->sum('duration');
        
        // Todo Statistics
        $todos = Todo::where('user_id', $userId);
        $totalTodos = $todos->count();
        $todoStats = [
            'todo' => Todo::where('user_id', $userId)->where('status', 'todo')->count(),
            'doing' => Todo::where('user_id', $userId)->where('status', 'doing')->count(),
            'done' => Todo::where('user_id', $userId)->where('status', 'done')->count(),
        ];
        $overdueTodos = Todo::where('user_id', $userId)
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->whereNull('completed_at')
            ->count();
        
        // Calendar Events
        $upcomingEvents = CalendarEvent::where('user_id', $userId)
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();
        $todayEvents = CalendarEvent::where('user_id', $userId)
            ->whereDate('start_time', today())
            ->count();
        $thisWeekEvents = CalendarEvent::where('user_id', $userId)
            ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        
        // Notes Statistics
        $totalNotes = Note::where('user_id', $userId)->count();
        $recentNotes = Note::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
        
        // Recent Todos
        $recentTodos = Todo::where('user_id', $userId)
            ->whereNull('completed_at')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Focus sessions this week (for chart)
        $weeklyFocusData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $duration = FocusSession::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->sum('duration');
            $weeklyFocusData[] = [
                'date' => $date->format('D'),
                'minutes' => round($duration / 60)
            ];
        }
        
        return view('dashboard', compact(
            'totalFocusSessions',
            'totalFocusTime',
            'todayFocusTime',
            'totalTodos',
            'todoStats',
            'overdueTodos',
            'upcomingEvents',
            'todayEvents',
            'thisWeekEvents',
            'totalNotes',
            'recentNotes',
            'recentTodos',
            'weeklyFocusData'
        ));
    }
}
