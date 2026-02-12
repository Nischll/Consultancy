<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Application;
use App\Models\VisaApplication;
use App\Models\Payment;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('consultancy.reports.index');
    }

    public function students(Request $request)
    {
        $query = Student::query();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('intake')) {
            $query->where('target_intake', $request->intake);
        }

        $students = $query->with(['counselor.user', 'targetUniversity'])->get();

        // Summary
        $summary = [
            'total' => $students->count(),
            'by_status' => $students->groupBy('status')->map->count(),
            'by_intake' => $students->groupBy('target_intake')->map->count(),
            'by_source' => $students->groupBy('source')->map->count(),
        ];

        return view('consultancy.reports.students', compact('students', 'summary', 'request'));
    }

    public function applications(Request $request)
    {
        $query = Application::with(['student', 'university', 'counselor.user']);

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('intake')) {
            $query->where('intake', $request->intake);
        }
        if ($request->filled('university_id')) {
            $query->where('university_id', $request->university_id);
        }

        $applications = $query->get();

        $summary = [
            'total' => $applications->count(),
            'by_status' => $applications->groupBy('status')->map->count(),
            'by_university' => $applications->groupBy('university.name')->map->count(),
            'acceptance_rate' => $applications->count() > 0 
                ? round($applications->where('status', 'accepted')->count() / $applications->count() * 100, 1) 
                : 0,
        ];

        $universities = University::orderBy('name')->get();

        return view('consultancy.reports.applications', compact('applications', 'summary', 'universities', 'request'));
    }

    public function financial(Request $request)
    {
        $query = Payment::with(['student', 'application']);

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        $payments = $query->get();

        $summary = [
            'total_amount' => $payments->sum('amount'),
            'collected' => $payments->sum('paid_amount'),
            'pending' => $payments->sum('due_amount'),
            'by_type' => $payments->groupBy('payment_type')->map(function($group) {
                return [
                    'count' => $group->count(),
                    'total' => $group->sum('amount'),
                    'collected' => $group->sum('paid_amount'),
                ];
            }),
            'by_status' => $payments->groupBy('status')->map->count(),
        ];

        return view('consultancy.reports.financial', compact('payments', 'summary', 'request'));
    }

    public function visa(Request $request)
    {
        $query = VisaApplication::with(['student', 'application.university', 'counselor.user']);

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $visaApplications = $query->get();

        $summary = [
            'total' => $visaApplications->count(),
            'approved' => $visaApplications->where('status', 'approved')->count(),
            'rejected' => $visaApplications->where('status', 'rejected')->count(),
            'processing' => $visaApplications->whereIn('status', ['submitted', 'processing', 'interview_scheduled'])->count(),
            'approval_rate' => $visaApplications->count() > 0 
                ? round($visaApplications->where('status', 'approved')->count() / $visaApplications->count() * 100, 1) 
                : 0,
            'by_status' => $visaApplications->groupBy('status')->map->count(),
        ];

        return view('consultancy.reports.visa', compact('visaApplications', 'summary', 'request'));
    }
}
