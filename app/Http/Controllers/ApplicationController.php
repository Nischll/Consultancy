<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Student;
use App\Models\University;
use App\Models\Counselor;
use App\Models\Task;
use App\Models\ConsultancyProfile;
use App\Mail\ApplicationCreatedMail;
use App\Mail\ApplicationUpdatedMail;
use App\Mail\ApplicationInterviewMail;
use App\Mail\COEAppliedMail;
use App\Mail\TaskCreatedForStudentMail;
use App\Mail\TaskCreatedConsultancyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with(['student', 'university', 'counselor.user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('application_id', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('intake')) {
            $query->where('intake', $request->intake);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('consultancy.applications.index', compact('applications'));
    }

    public function create(Request $request)
    {
        $students = Student::orderBy('first_name')->get();
        $universities = University::orderBy('name')->get();
        $counselors = Counselor::with('user')->where('is_active', true)->get();
        $selectedStudent = $request->student_id ? Student::find($request->student_id) : null;
        
        return view('consultancy.applications.create', compact('students', 'universities', 'counselors', 'selectedStudent'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'university_id' => 'required|exists:universities,id',
            'counselor_id' => 'nullable|exists:counselors,id',
            'intake' => 'required|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'course_type' => 'nullable|string|max:255',
            'course_duration' => 'nullable|string|max:255',
            'application_date' => 'nullable|date',
            'submission_deadline' => 'nullable|date',
            'application_fee' => 'nullable|numeric|min:0',
            'tuition_fee' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $application = Application::create($validated);

        // Automatically set student status to 'applied' when an application is created
        $student = Student::find($validated['student_id']);
        if ($student) {
            $student->update(['status' => 'applied']);
        }

        if ($student && $student->email) {
            try {
                Mail::to($student->email)->send(new ApplicationCreatedMail($application));
            } catch (\Exception $e) {
            }
        }

        return redirect()->route('consultancy.applications.show', $application)
            ->with('success', 'Application created successfully! ID: ' . $application->application_id);
    }

    public function show(Application $application)
    {
        $application->load(['student', 'university', 'counselor.user', 'visaApplication', 'payments', 'tasks']);
        return view('consultancy.applications.show', compact('application'));
    }

    public function edit(Application $application)
    {
        $students = Student::orderBy('first_name')->get();
        $universities = University::orderBy('name')->get();
        $counselors = Counselor::with('user')->where('is_active', true)->get();
        
        return view('consultancy.applications.edit', compact('application', 'students', 'universities', 'counselors'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'university_id' => 'required|exists:universities,id',
            'counselor_id' => 'nullable|exists:counselors,id',
            'intake' => 'required|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'course_type' => 'nullable|string|max:255',
            'course_duration' => 'nullable|string|max:255',
            'status' => 'required|string',
            'application_date' => 'nullable|date',
            'submission_deadline' => 'nullable|date',
            'submitted_at' => 'nullable|date',
            'interview_date' => 'nullable|date',
            'interview_mode' => 'nullable|string|max:255',
            'interview_notes' => 'nullable|string',
            'result_date' => 'nullable|date',
            'coe_status' => 'nullable|string',
            'coe_applied_date' => 'nullable|date',
            'coe_received_date' => 'nullable|date',
            'application_fee' => 'nullable|numeric|min:0',
            'tuition_fee' => 'nullable|numeric|min:0',
            'application_fee_paid' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $application->status;
        $oldCoeStatus = $application->coe_status;
        $oldCoeAppliedDate = $application->coe_applied_date;
        $application->update($validated);
        $application->load(['student', 'university']);

        // When status is set to documents_preparing, move student to document_collection step and create a task (from application section)
        $student = $application->student;
        if ($student && $validated['status'] === 'documents_preparing' && $oldStatus !== 'documents_preparing') {
            $laterStages = ['visa_processing', 'visa_approved', 'visa_rejected', 'departed', 'enrolled', 'completed'];
            if (!in_array($student->status, $laterStages, true)) {
                $student->update(['status' => 'document_collection']);
            }
            $universityName = $application->university->name ?? 'university';
            $task = Task::create([
                'student_id' => $student->id,
                'application_id' => $application->id,
                'title' => 'Prepare documents for ' . $universityName . ' (' . $application->application_id . ')',
                'description' => 'Please prepare and upload the required documents for this application. You can upload documents from your portal under My Documents.',
                'type' => 'documents',
                'priority' => 'medium',
                'status' => 'pending',
                'assigned_by' => auth()->id(),
            ]);
            $task->load(['student', 'assignedTo', 'assignedBy']);
            if ($student->email) {
                try {
                    Mail::to($student->email)->send(new TaskCreatedForStudentMail($task));
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
        }

        // When an application becomes accepted/enrolled, sync student status to 'accepted' so they can proceed (unless already further along)
        if ($student && in_array($validated['status'], ['accepted', 'enrolled'], true)) {
            $laterStages = ['document_collection', 'visa_processing', 'visa_approved', 'visa_rejected', 'departed', 'enrolled', 'completed'];
            if (!in_array($student->status, $laterStages, true)) {
                $student->update(['status' => 'accepted']);
            }
        }

        if ($student && $student->email) {
            try {
                Mail::to($application->student->email)->send(new ApplicationUpdatedMail($application));
            } catch (\Exception $e) {
            }
            // Send interview notification when application is updated for interview (status = interview_scheduled or interview date/details set)
            $isInterviewUpdate = ($validated['status'] ?? '') === 'interview_scheduled'
                || !empty($validated['interview_date'])
                || !empty($validated['interview_mode'])
                || !empty($validated['interview_notes']);
            if ($isInterviewUpdate) {
                try {
                    Mail::to($student->email)->send(new ApplicationInterviewMail($application));
                } catch (\Exception $e) {
                }
            }
            $coeStatusNow = $validated['coe_status'] ?? null;
            $coeAppliedDateNow = isset($validated['coe_applied_date']) ? $validated['coe_applied_date'] : null;
            $coeJustApplied = ($coeStatusNow && in_array(strtolower($coeStatusNow), ['applied', 'processing'], true) && $oldCoeStatus !== $coeStatusNow)
                || ($coeAppliedDateNow && !$oldCoeAppliedDate);
            if ($coeJustApplied) {
                try {
                    Mail::to($application->student->email)->send(new COEAppliedMail($application));
                } catch (\Exception $e) {
                }
            }
        }

        return redirect()->route('consultancy.applications.show', $application)
            ->with('success', 'Application updated successfully!');
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->route('consultancy.applications.index')
            ->with('success', 'Application deleted successfully!');
    }
}
