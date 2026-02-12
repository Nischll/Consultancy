<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Application;
use App\Models\VisaApplication;
use App\Models\Payment;
use App\Models\Task;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Overview Statistics
        $stats = [
            'total_students' => Student::count(),
            'active_students' => Student::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'pending_inquiries' => Inquiry::where('status', 'new')->count(),
            'active_applications' => Application::whereNotIn('status', ['enrolled', 'rejected', 'withdrawn'])->count(),
            'visa_processing' => VisaApplication::whereIn('status', ['submitted', 'processing', 'interview_scheduled'])->count(),
            'pending_tasks' => Task::where('status', 'pending')->count(),
            'overdue_tasks' => Task::where('status', 'pending')->where('due_date', '<', now())->count(),
        ];

        // Revenue Statistics
        $currentMonth = now()->format('Y-m');
        $stats['monthly_revenue'] = Payment::where('status', 'completed')
            ->whereRaw("DATE_FORMAT(paid_date, '%Y-%m') = ?", [$currentMonth])
            ->sum('paid_amount');

        // Students by Status
        $studentsByStatus = Student::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Applications by Status
        $applicationsByStatus = Application::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Recent Activities
        $recentStudents = Student::latest()->take(5)->get();
        $recentApplications = Application::with(['student', 'university'])->latest()->take(5)->get();
        $upcomingTasks = Task::with(['student', 'assignedTo'])
            ->where('status', 'pending')
            ->orderBy('due_date')
            ->take(10)
            ->get();

        // Upcoming Interviews
        $upcomingInterviews = Application::with(['student', 'university'])
            ->whereNotNull('interview_date')
            ->where('interview_date', '>=', now())
            ->orderBy('interview_date')
            ->take(5)
            ->get();

        // Monthly Trend (Last 6 months)
        $monthlyTrend = Student::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('consultancy.dashboard', compact(
            'stats', 'studentsByStatus', 'applicationsByStatus',
            'recentStudents', 'recentApplications', 'upcomingTasks',
            'upcomingInterviews', 'monthlyTrend'
        ));
    }
}
