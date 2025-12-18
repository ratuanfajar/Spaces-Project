<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TodoController extends Controller
{
    use AuthorizesRequests;
    public function index(): View
    {
        $todos = auth()->user()->todos()->orderBy('order')->get()->groupBy('status');
        
        return view('todo.index', [
            'todoItems' => $todos->get('todo', collect()),
            'doingItems' => $todos->get('doing', collect()),
            'doneItems' => $todos->get('done', collect()),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,doing,done',
            'due_date' => 'nullable|date'
        ]);

        auth()->user()->todos()->create($validated);

        return redirect()->route('todo')->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Todo $todo): RedirectResponse
    {
        $this->authorize('update', $todo);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,doing,done',
            'due_date' => 'nullable|date'
        ]);

        // Handle completed_at timestamp
        if ($validated['status'] === 'done' && $todo->status !== 'done') {
            // Moving to completed - set timestamp
            $validated['completed_at'] = now();
        } elseif ($validated['status'] !== 'done' && $todo->status === 'done') {
            // Moving from completed - clear timestamp
            $validated['completed_at'] = null;
        }

        $todo->update($validated);

        return redirect()->route('todo')->with('success', 'Task updated successfully!');
    }

    public function destroy(Todo $todo): RedirectResponse
    {
        $this->authorize('delete', $todo);
        
        $todo->delete();

        return redirect()->route('todo')->with('success', 'Task deleted successfully!');
    }
}