<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\Student;
use App\Models\Application;
use App\Models\Counselor;
use App\Mail\VisaCreatedMail;
use App\Mail\VisaUpdatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VisaApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = VisaApplication::with(['student', 'application.university', 'counselor.user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('visa_application_id', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $visaApplications = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('consultancy.visa.index', compact('visaApplications'));
    }

    public function create(Request $request)
    {
        $students = Student::whereIn('status', ['accepted', 'document_collection', 'visa_processing'])->orderBy('first_name')->get();
        $counselors = Counselor::with('user')->where('is_active', true)->get();
        $selectedStudent = $request->student_id ? Student::find($request->student_id) : null;
        $applications = $selectedStudent
            ? $selectedStudent->applications()->whereIn('status', ['accepted', 'enrolled'])->with('university')->orderBy('created_at', 'desc')->get()
            : collect();
        
        return view('consultancy.visa.create', compact('students', 'counselors', 'selectedStudent', 'applications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'application_id' => 'nullable|exists:applications,id',
            'counselor_id' => 'nullable|exists:counselors,id',
            'visa_type' => 'required|string|max:255',
            'embassy_location' => 'nullable|string|max:255',
            'planned_departure_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $visaApplication = VisaApplication::create($validated);

        // Update student status
        $student = Student::find($validated['student_id']);
        $student->update(['status' => 'visa_processing']);

        if ($student && $student->email) {
            try {
                Mail::to($student->email)->send(new VisaCreatedMail($visaApplication));
            } catch (\Exception $e) {
            }
        }

        return redirect()->route('consultancy.visa.show', $visaApplication)
            ->with('success', 'Visa application created successfully! ID: ' . $visaApplication->visa_application_id);
    }

    public function show(VisaApplication $visa)
    {
        $visa->load(['student', 'application.university', 'counselor.user']);
        return view('consultancy.visa.show', compact('visa'));
    }

    public function edit(VisaApplication $visa)
    {
        $counselors = Counselor::with('user')->where('is_active', true)->get();
        return view('consultancy.visa.edit', compact('visa', 'counselors'));
    }

    public function update(Request $request, VisaApplication $visa)
    {
        $validated = $request->validate([
            'counselor_id' => 'nullable|exists:counselors,id',
            'visa_type' => 'required|string|max:255',
            'embassy_location' => 'nullable|string|max:255',
            'status' => 'required|string',
            'submission_date' => 'nullable|date',
            'interview_date' => 'nullable|datetime',
            'interview_notes' => 'nullable|string',
            'expected_result_date' => 'nullable|date',
            'result_date' => 'nullable|date',
            'visa_issue_date' => 'nullable|date',
            'visa_expiry_date' => 'nullable|date',
            'visa_number' => 'nullable|string|max:255',
            'rejection_reason' => 'nullable|string',
            'planned_departure_date' => 'nullable|date',
            'actual_departure_date' => 'nullable|date',
            'flight_details' => 'nullable|string|max:500',
            'arrival_airport' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $visa->update($validated);

        // Update student status based on visa status
        $student = $visa->student;
        if ($validated['status'] === 'approved') {
            $student->update(['status' => 'visa_approved']);
        } elseif ($validated['status'] === 'rejected') {
            $student->update(['status' => 'visa_rejected']);
        } elseif ($visa->actual_departure_date) {
            $student->update(['status' => 'departed']);
        }

        if ($student && $student->email) {
            try {
                Mail::to($student->email)->send(new VisaUpdatedMail($visa));
            } catch (\Exception $e) {
            }
        }

        return redirect()->route('consultancy.visa.show', $visa)
            ->with('success', 'Visa application updated successfully!');
    }

    public function destroy(VisaApplication $visa)
    {
        $visa->delete();
        return redirect()->route('consultancy.visa.index')
            ->with('success', 'Visa application deleted successfully!');
    }
}
