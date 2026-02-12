<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Student;
use App\Models\ConsultancyProfile;
use App\Mail\CommunicationToStudentMail;
use App\Mail\CommunicationSentConsultancyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommunicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Communication::with(['student', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // Filter follow-ups
        if ($request->filled('follow_up')) {
            $query->where('requires_follow_up', true)
                  ->where('follow_up_completed', false);
        }

        $communications = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('consultancy.communications.index', compact('communications'));
    }

    public function create(Request $request)
    {
        $students = Student::orderBy('first_name')->get();
        $selectedStudent = $request->student_id ? Student::find($request->student_id) : null;
        
        return view('consultancy.communications.create', compact('students', 'selectedStudent'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:email,phone,whatsapp,sms,meeting,note',
            'direction' => 'required|in:incoming,outgoing',
            'subject' => 'nullable|string|max:255',
            'content' => 'required|string',
            'email_to' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'call_duration' => 'nullable|integer|min:0',
            'meeting_date' => 'nullable|datetime',
            'meeting_location' => 'nullable|string|max:255',
            'requires_follow_up' => 'boolean',
            'follow_up_date' => 'nullable|datetime',
        ]);

        $validated['user_id'] = auth()->id();

        $communication = Communication::create($validated);

        if ($validated['type'] === 'email' && $validated['direction'] === 'outgoing') {
            $student = Student::find($validated['student_id']);
            $toEmail = $validated['email_to'] ?? ($student->email ?? null);
            if ($toEmail) {
                try {
                    Mail::to($toEmail)->send(new CommunicationToStudentMail($communication));
                } catch (\Exception $e) {
                }
            }
        }

        $profile = ConsultancyProfile::where('is_active', true)->first();
        if ($profile && $profile->email) {
            try {
                Mail::to($profile->email)->send(new CommunicationSentConsultancyMail($communication));
            } catch (\Exception $e) {
            }
        }

        return redirect()->route('consultancy.students.show', $validated['student_id'])
            ->with('success', 'Communication logged successfully!');
    }

    public function show(Communication $communication)
    {
        $communication->load(['student', 'user']);
        return view('consultancy.communications.show', compact('communication'));
    }

    public function completeFollowUp(Communication $communication)
    {
        $communication->update([
            'follow_up_completed' => true,
        ]);

        return redirect()->back()
            ->with('success', 'Follow-up marked as completed!');
    }

    public function destroy(Communication $communication)
    {
        $communication->delete();
        return redirect()->back()
            ->with('success', 'Communication deleted successfully!');
    }
}
