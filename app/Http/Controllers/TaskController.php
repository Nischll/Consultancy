<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Student;
use App\Models\Application;
use App\Models\User;
use App\Models\ConsultancyProfile;
use App\Mail\TaskCreatedForStudentMail;
use App\Mail\TaskAssignedMail;
use App\Mail\TaskCreatedConsultancyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['student', 'application', 'assignedTo', 'assignedBy']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by my tasks
        if ($request->filled('my_tasks')) {
            $query->where('assigned_to', auth()->id());
        }

        $tasks = $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')")
            ->orderBy('due_date')
            ->paginate(20);

        // Include all staff roles (Admin, Editor, Employee, Teacher, HR, Counselor) for "Assigned To"
        $users = User::whereIn('role_id', [1, 2, 3, 5, 6, 7, 8])->orderBy('name')->get();
        
        return view('consultancy.tasks.index', compact('tasks', 'users'));
    }

    public function create(Request $request)
    {
        $students = Student::orderBy('first_name')->get();
        $users = User::whereIn('role_id', [1, 2, 3, 5, 6, 7, 8])->orderBy('name')->get();
        $selectedStudent = $request->student_id ? Student::find($request->student_id) : null;
        
        return view('consultancy.tasks.create', compact('students', 'users', 'selectedStudent'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'student_id' => 'nullable|exists:students,id',
            'application_id' => 'nullable|exists:applications,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'reminder_date' => 'nullable|datetime',
            'notes' => 'nullable|string',
        ]);

        $validated['assigned_by'] = auth()->id();
        $validated['status'] = 'pending';

        $task = Task::create($validated);
        $task->load(['student', 'assignedTo', 'assignedBy']);

        if ($task->student && $task->student->email) {
            try {
                Mail::to($task->student->email)->send(new TaskCreatedForStudentMail($task));
            } catch (\Exception $e) {
            }
        }

        if ($task->assigned_to && $task->assignedTo && $task->assignedTo->email) {
            try {
                Mail::to($task->assignedTo->email)->send(new TaskAssignedMail($task));
            } catch (\Exception $e) {
            }
        }

        $profile = ConsultancyProfile::where('is_active', true)->first();
        if ($profile && $profile->email) {
            try {
                Mail::to($profile->email)->send(new TaskCreatedConsultancyMail($task));
            } catch (\Exception $e) {
            }
        }

        return redirect()->route('consultancy.tasks.show', $task)
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $task->load(['student', 'application', 'assignedTo', 'assignedBy']);
        return view('consultancy.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $students = Student::orderBy('first_name')->get();
        $users = User::whereIn('role_id', [1, 2, 3, 5, 6, 7, 8])->orderBy('name')->get();
        
        return view('consultancy.tasks.edit', compact('task', 'students', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled,overdue',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'reminder_date' => 'nullable|datetime',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'completed' && $task->status !== 'completed') {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return redirect()->route('consultancy.tasks.show', $task)
            ->with('success', 'Task updated successfully!');
    }

    public function complete(Task $task)
    {
        $task->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Task marked as completed!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('consultancy.tasks.index')
            ->with('success', 'Task deleted successfully!');
    }
}
