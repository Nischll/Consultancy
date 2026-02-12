<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use App\Models\Student;
use App\Models\Application;
use App\Models\Inquiry;
use App\Models\Task;
use App\Models\Communication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CounselorPortalController extends Controller
{
    private function getAuthenticatedCounselor()
    {
        $user = Auth::user();
        return Counselor::where('user_id', $user->id)->first();
    }

    public function dashboard()
    {
        $counselor = $this->getAuthenticatedCounselor();
        
        if (!$counselor) {
            return redirect()->route('home')->with('error', 'No counselor profile found.');
        }

        // Get statistics
        $stats = [
            'total_students' => $counselor->students()->count(),
            'active_students' => $counselor->students()->where('status', 'active')->count(),
            'pending_applications' => $counselor->applications()
                ->whereIn('status', ['draft', 'submitted', 'under_review'])
                ->count(),
            'pending_tasks' => Task::where('assigned_to', $counselor->user_id)
                ->where('status', 'pending')
                ->count(),
            'unread_messages' => Communication::whereHas('student', function($q) use ($counselor) {
                    $q->where('counselor_id', $counselor->id);
                })
                ->where('direction', 'incoming')
                ->where('requires_follow_up', true)
                ->where('follow_up_completed', false)
                ->count(),
        ];

        // Get recent students
        $recentStudents = $counselor->students()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get pending applications
        $pendingApplications = $counselor->applications()
            ->with('student')
            ->whereIn('status', ['draft', 'submitted', 'under_review'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get pending tasks
        $pendingTasks = Task::with('student')
            ->where('assigned_to', $counselor->user_id)
            ->where('status', 'pending')
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        // Get recent communications
        $recentCommunications = Communication::whereHas('student', function($q) use ($counselor) {
            $q->where('counselor_id', $counselor->id);
        })
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        return view('counselor.dashboard', compact('counselor', 'stats', 'recentStudents', 'pendingApplications', 'pendingTasks', 'recentCommunications'));
    }

    public function students()
    {
        $counselor = $this->getAuthenticatedCounselor();
        
        if (!$counselor) {
            return redirect()->route('home')->with('error', 'No counselor profile found.');
        }

        $students = $counselor->students()
            ->with(['applications', 'documents'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('counselor.students', compact('counselor', 'students'));
    }

    public function showStudent(Student $student)
    {
        $counselor = $this->getAuthenticatedCounselor();
        if (!$counselor || $student->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized.');
        }
        $student->load(['applications.university', 'documents', 'tasks']);
        return view('counselor.students-show', compact('counselor', 'student'));
    }

    public function applications()
    {
        $counselor = $this->getAuthenticatedCounselor();
        
        if (!$counselor) {
            return redirect()->route('home')->with('error', 'No counselor profile found.');
        }

        $applications = $counselor->applications()
            ->with(['student', 'university'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('counselor.applications', compact('counselor', 'applications'));
    }

    public function showApplication(Application $application)
    {
        $counselor = $this->getAuthenticatedCounselor();
        if (!$counselor || $application->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized.');
        }
        $application->load(['student', 'university']);
        return view('counselor.applications-show', compact('counselor', 'application'));
    }

    public function updateApplicationStatus(Request $request, Application $application)
    {
        $counselor = $this->getAuthenticatedCounselor();
        if (!$counselor || $application->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized.');
        }
        $validated = $request->validate([
            'status' => 'required|in:draft,submitted,under_review,accepted,rejected,enrolled,withdrawn',
        ]);
        $application->update($validated);
        return redirect()->route('counselor.applications.show', $application)
            ->with('success', 'Application status updated.');
    }

    public function tasks()
    {
        $counselor = $this->getAuthenticatedCounselor();
        
        if (!$counselor) {
            return redirect()->route('home')->with('error', 'No counselor profile found.');
        }

        $tasks = Task::with('student')
            ->where('assigned_to', $counselor->user_id)
            ->orderBy('due_date', 'asc')
            ->paginate(20);

        return view('counselor.tasks', compact('counselor', 'tasks'));
    }

    public function completeTask(Task $task)
    {
        $counselor = $this->getAuthenticatedCounselor();
        if (!$counselor || $task->assigned_to !== $counselor->user_id) {
            abort(403, 'Unauthorized.');
        }
        $task->update(['status' => 'completed', 'completed_at' => now()]);
        return redirect()->route('counselor.tasks')->with('success', 'Task marked as completed.');
    }

    public function messages()
    {
        $counselor = $this->getAuthenticatedCounselor();
        
        if (!$counselor) {
            return redirect()->route('home')->with('error', 'No counselor profile found.');
        }

        $communications = Communication::whereHas('student', function($q) use ($counselor) {
            $q->where('counselor_id', $counselor->id);
        })
        ->with('student')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        $students = $counselor->students()->orderBy('first_name')->get();

        return view('counselor.messages', compact('counselor', 'communications', 'students'));
    }

    public function sendMessage(Request $request)
    {
        $counselor = $this->getAuthenticatedCounselor();
        if (!$counselor) {
            return redirect()->route('home')->with('error', 'No counselor profile found.');
        }
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);
        $student = Student::findOrFail($validated['student_id']);
        if ($student->counselor_id !== $counselor->id) {
            abort(403, 'You can only send messages to your assigned students.');
        }
        Communication::create([
            'student_id' => $student->id,
            'user_id' => $counselor->user_id,
            'type' => 'note',
            'direction' => 'outgoing',
            'subject' => $validated['subject'],
            'content' => $validated['content'],
        ]);
        return redirect()->route('counselor.messages')->with('success', 'Message sent successfully.');
    }

    public function profile()
    {
        $counselor = $this->getAuthenticatedCounselor();
        
        if (!$counselor) {
            return redirect()->route('home')->with('error', 'No counselor profile found.');
        }

        return view('counselor.profile', compact('counselor'));
    }

    public function updateProfile(Request $request)
    {
        $counselor = $this->getAuthenticatedCounselor();
        
        if (!$counselor) {
            return redirect()->route('home')->with('error', 'No counselor profile found.');
        }

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'extension' => 'nullable|string|max:10',
            'specialization' => 'nullable|string|max:255',
        ]);

        $counselor->update($validated);

        // Update user email if provided
        if ($request->filled('email')) {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $counselor->user_id,
            ]);
            $counselor->user->update(['email' => $request->email]);
        }

        return redirect()->route('counselor.profile')
            ->with('success', 'Profile updated successfully!');
    }
}
