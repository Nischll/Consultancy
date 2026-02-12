<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Student;
use App\Models\DocumentChecklist;
use App\Models\ConsultancyProfile;
use App\Mail\DocumentStatusMail;
use App\Mail\DocumentRemovedMail;
use App\Mail\DocumentStatusConsultancyMail;
use App\Mail\DocumentRemovedConsultancyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['student', 'verifiedBy']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('consultancy.documents.index', compact('documents'));
    }

    public function create(Request $request)
    {
        $students = Student::orderBy('first_name')->get();
        $selectedStudent = $request->student_id ? Student::find($request->student_id) : null;
        $checklist = DocumentChecklist::orderBy('order')->get();
        
        return view('consultancy.documents.create', compact('students', 'selectedStudent', 'checklist'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'document_type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:51200',
            'expiry_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $student = Student::find($validated['student_id']);
        $file = $request->file('file');
        $fileName = $student->student_id . '_' . $validated['document_type'] . '_' . time() . '.' . $file->getClientOriginalExtension();
        $fileSizeKb = round($file->getSize() / 1024);

        $path = public_path('documents/' . $student->student_id);
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $file->move($path, $fileName);

        Document::create([
            'student_id' => $validated['student_id'],
            'document_type' => $validated['document_type'],
            'title' => $validated['title'],
            'file_path' => 'documents/' . $student->student_id . '/' . $fileName,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $fileSizeKb,
            'expiry_date' => $validated['expiry_date'],
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        return redirect()->route('consultancy.students.show', $student)
            ->with('success', 'Document uploaded successfully!');
    }

    public function show(Document $document)
    {
        $document->load(['student', 'verifiedBy']);
        return view('consultancy.documents.show', compact('document'));
    }

    public function verify(Request $request, Document $document)
    {
        // Normalize status (form may send via hidden input or button)
        $status = trim((string) $request->input('status', ''));
        if ($status === '' && $request->has('verify')) {
            $status = 'verified';
        }
        $request->merge(['status' => $status]);

        $validated = $request->validate([
            'status' => 'required|in:verified,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:1000',
        ]);

        $document->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['rejection_reason'] ?? null,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        $document->load('student');
        if ($document->student && $document->student->email) {
            try {
                Mail::to($document->student->email)->send(new DocumentStatusMail($document, $validated['status']));
            } catch (\Exception $e) {
            }
        }
        $profile = ConsultancyProfile::where('is_active', true)->first();
        if ($profile && $profile->email) {
            try {
                Mail::to($profile->email)->send(new DocumentStatusConsultancyMail($document, $validated['status']));
            } catch (\Exception $e) {
            }
        }

        return redirect()->back()
            ->with('success', 'Document ' . $validated['status'] . ' successfully!');
    }

    public function destroy(Document $document)
    {
        $document->load('student');
        if ($document->student && $document->student->email) {
            try {
                Mail::to($document->student->email)->send(new DocumentRemovedMail($document));
            } catch (\Exception $e) {
            }
        }
        $profile = ConsultancyProfile::where('is_active', true)->first();
        if ($profile && $profile->email) {
            try {
                Mail::to($profile->email)->send(new DocumentRemovedConsultancyMail($document));
            } catch (\Exception $e) {
            }
        }

        // Delete file
        if ($document->file_path && file_exists(public_path($document->file_path))) {
            unlink(public_path($document->file_path));
        }

        $document->delete();
        return redirect()->back()
            ->with('success', 'Document deleted successfully!');
    }

    // Document Checklist Management
    public function checklist()
    {
        $checklist = DocumentChecklist::orderBy('order')->get();
        return view('consultancy.documents.checklist', compact('checklist'));
    }

    public function storeChecklist(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_required' => 'boolean',
            'applicable_for' => 'nullable|string|max:255',
        ]);

        DocumentChecklist::create($validated);

        return redirect()->route('consultancy.documents.checklist')
            ->with('success', 'Checklist item added successfully!');
    }
}
