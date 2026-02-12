<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Student;
use App\Models\Counselor;
use App\Mail\InquiryResponseMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Inquiry lifecycle: New → In Progress → Responded → (optional Follow-up) → Converted | Closed
 * - Convert to Student is allowed for any status except 'converted'.
 * - Responding does not block conversion; response is emailed to the client and logged.
 *
 * Role responsibilities:
 * - Admin: Create/edit inquiries, assign counsellor, submit response (emailed to client), convert to student.
 * - Counsellor: Assigned to inquiry for follow-up; can view assigned inquiries in Counselor portal. Response and conversion are done by Admin.
 */
class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::with(['student', 'counselor.user', 'respondedBy']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('inquiry_id', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('consultancy.inquiries.index', compact('inquiries'));
    }

    public function create()
    {
        $counselors = Counselor::with('user')->where('is_active', true)->get();
        return view('consultancy.inquiries.create', compact('counselors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,admission,visa,language,scholarship,accommodation,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'source' => 'nullable|string|max:255',
            'counselor_id' => 'nullable|exists:counselors,id',
        ]);

        $inquiry = Inquiry::create($validated);

        return redirect()->route('consultancy.inquiries.show', $inquiry)
            ->with('success', 'Inquiry created successfully! ID: ' . $inquiry->inquiry_id);
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['student', 'counselor.user', 'respondedBy']);
        return view('consultancy.inquiries.show', compact('inquiry'));
    }

    public function edit(Inquiry $inquiry)
    {
        $counselors = Counselor::with('user')->where('is_active', true)->get();
        return view('consultancy.inquiries.edit', compact('inquiry', 'counselors'));
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,responded,follow_up,converted,closed',
            'response' => 'nullable|string',
            'follow_up_date' => 'nullable|datetime',
            'follow_up_notes' => 'nullable|string',
            'counselor_id' => 'nullable|exists:counselors,id',
        ]);

        $responseText = $request->input('response');
        $isNewResponse = $request->filled('response') && (string) $responseText !== (string) $inquiry->response;

        if ($isNewResponse) {
            $validated['responded_at'] = now();
            $validated['responded_by'] = auth()->id();
            // When admin submits a new response and current status is new/in_progress, set to responded
            if (in_array($request->input('status'), ['new', 'in_progress'], true)) {
                $validated['status'] = 'responded';
            }
        }

        $inquiry->update($validated);

        // Send response email to the inquiry client when a response is submitted and inquiry has email
        if ($isNewResponse && $inquiry->email) {
            try {
                Mail::to($inquiry->email)->send(new InquiryResponseMail($inquiry, $responseText));
            } catch (\Exception $e) {
            }
        }

        $message = 'Inquiry updated successfully.';
        if ($isNewResponse && $inquiry->email) {
            $message .= ' A copy of your response has been sent to the client\'s email.';
        } elseif ($isNewResponse && ! $inquiry->email) {
            $message .= ' No email was sent (inquiry has no email address).';
        }

        return redirect()->route('consultancy.inquiries.show', $inquiry)
            ->with('success', $message);
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('consultancy.inquiries.index')
            ->with('success', 'Inquiry deleted successfully!');
    }

    public function convertToStudent(Inquiry $inquiry)
    {
        // Allow conversion for any non-converted status (new, in_progress, responded, follow_up, closed)
        if ($inquiry->status === 'converted') {
            return redirect()->route('consultancy.inquiries.show', $inquiry)
                ->with('error', 'This inquiry has already been converted to a student.');
        }

        if (empty($inquiry->email) || ! filter_var($inquiry->email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('consultancy.inquiries.show', $inquiry)
                ->with('error', 'Cannot convert: inquiry must have a valid email address. Please add or correct the email in the inquiry contact details.');
        }

        $name = trim($inquiry->name ?? '');
        if ($name === '') {
            return redirect()->route('consultancy.inquiries.show', $inquiry)
                ->with('error', 'Cannot convert: inquiry must have a name. Please add the contact name.');
        }

        $parts = explode(' ', $name, 2);
        $firstName = $parts[0] ?? $name;
        $lastName = $parts[1] ?? '';

        // Create student from inquiry
        $student = Student::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $inquiry->email,
            'phone' => $inquiry->phone ?? '',
            'address' => 'To be updated',
            'city' => 'To be updated',
            'source' => $inquiry->source,
            'status' => 'registered',
            'counselor_id' => $inquiry->counselor_id,
        ]);

        // Update inquiry
        $inquiry->update([
            'student_id' => $student->id,
            'status' => 'converted',
        ]);

        return redirect()->route('consultancy.students.edit', $student)
            ->with('success', 'Inquiry converted to student! Please complete the student profile.');
    }
}
