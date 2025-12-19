<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CalendarController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $events = auth()->user()->calendarEvents()->with('todo')->get();
        $todos = auth()->user()->todos()
            ->whereNotNull('due_date')
            ->whereDoesntHave('calendarEvent')
            ->get();
        
        return view('calendar.index', compact('events', 'todos'));
    }

    public function getEvents(Request $request): JsonResponse
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $events = auth()->user()->calendarEvents()
            ->when($start && $end, function($query) use ($start, $end) {
                return $query->whereBetween('start_time', [$start, $end]);
            })
            ->with('todo')
            ->get()
            ->map(function($event) {
                // Format datetime untuk FullCalendar dengan timezone
                $startDateTime = str_replace(' ', 'T', substr($event->start_time, 0, 19));
                $endDateTime = str_replace(' ', 'T', substr($event->end_time, 0, 19));
                
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $startDateTime,
                    'end' => $endDateTime,
                    'backgroundColor' => $event->color,
                    'borderColor' => $event->color,
                    'allDay' => false,
                    'extendedProps' => [
                        'description' => $event->description,
                        'type' => $event->type,
                        'location' => $event->location,
                        'guests' => $event->guests,
                        'todo_id' => $event->todo_id,
                        'start_time' => str_replace(' ', 'T', substr($event->start_time, 0, 16)),
                        'end_time' => str_replace(' ', 'T', substr($event->end_time, 0, 16)),
                    ]
                ];
            });

        return response()->json($events);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:event,task',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'guests' => 'nullable|array',
            'todo_id' => 'nullable|exists:todos,id',
        ]);

        $validated['user_id'] = auth()->id();
        
        // Store datetime as-is without timezone conversion
        $validated['start_time'] = str_replace('T', ' ', $validated['start_time']);
        $validated['end_time'] = str_replace('T', ' ', $validated['end_time']);

        CalendarEvent::create($validated);

        return redirect()->route('calendar')->with('success', 'Event created successfully!');
    }

    public function update(Request $request, CalendarEvent $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:event,task',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'guests' => 'nullable|array',
            'todo_id' => 'nullable|exists:todos,id',
        ]);
        
        // Store datetime as-is without timezone conversion
        $validated['start_time'] = str_replace('T', ' ', $validated['start_time']);
        $validated['end_time'] = str_replace('T', ' ', $validated['end_time']);

        $event->update($validated);

        return redirect()->route('calendar')->with('success', 'Event updated successfully!');
    }

    public function destroy(CalendarEvent $event): RedirectResponse
    {
        $this->authorize('delete', $event);
        
        $event->delete();

        return redirect()->route('calendar')->with('success', 'Event deleted successfully!');
    }

    public function importFromTodo(Request $request): RedirectResponse
    {
        $request->validate([
            'todo_ids' => 'required|array',
            'todo_ids.*' => 'exists:todos,id'
        ]);

        $todos = Todo::whereIn('id', $request->todo_ids)
            ->where('user_id', auth()->id())
            ->get();

        foreach ($todos as $todo) {
            CalendarEvent::create([
                'user_id' => auth()->id(),
                'title' => $todo->title,
                'description' => $todo->description,
                'type' => 'task',
                'start_time' => $todo->due_date ?? now(),
                'end_time' => ($todo->due_date ?? now())->addHour(),
                'color' => '#F59E0B',
                'todo_id' => $todo->id,
            ]);
        }

        return redirect()->route('calendar')->with('success', 'Tasks imported successfully!');
    }
}
