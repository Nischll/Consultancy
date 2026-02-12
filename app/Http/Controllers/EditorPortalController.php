<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Application;
use App\Models\Inquiry;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EditorPortalController extends Controller
{
    // Editors can view all inquiries, applications, and tasks assigned to them
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics
        $stats = [
            'total_students' => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'pending_applications' => Application::whereIn('status', ['draft', 'submitted', 'under_review'])->count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
            'pending_tasks' => Task::where('status', 'pending')->count(),
        ];

        // Get recent activities
        $recentApplications = Application::with(['student', 'university'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentInquiries = Inquiry::with(['student', 'counselor'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pendingTasks = Task::with(['student', 'assignedTo'])
            ->where('status', 'pending')
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        return view('editor.dashboard', compact('stats', 'recentApplications', 'recentInquiries', 'pendingTasks'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('editor.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('editor.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function inquiries(Request $request)
    {
        $query = Inquiry::with(['student', 'counselor.user']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $inquiries = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('editor.inquiries', compact('inquiries'));
    }

    public function showInquiry(Inquiry $inquiry)
    {
        $inquiry->load(['student', 'counselor.user']);
        return view('editor.inquiries-show', compact('inquiry'));
    }

    public function applications(Request $request)
    {
        $query = Application::with(['student', 'university']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $applications = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('editor.applications', compact('applications'));
    }

    public function showApplication(Application $application)
    {
        $application->load(['student', 'university']);
        return view('editor.applications-show', compact('application'));
    }

    public function tasks(Request $request)
    {
        $query = Task::with(['student', 'assignedTo'])
            ->where('assigned_to', Auth::id());
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $tasks = $query->orderBy('due_date', 'asc')->paginate(20);
        return view('editor.tasks', compact('tasks'));
    }

    public function completeTask(Task $task)
    {
        if ($task->assigned_to !== Auth::id()) {
            abort(403, 'You can only complete tasks assigned to you.');
        }
        $task->update(['status' => 'completed', 'completed_at' => now()]);
        return redirect()->route('editor.tasks')->with('success', 'Task marked as completed.');
    }
}
