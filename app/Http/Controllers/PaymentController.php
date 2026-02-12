<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Application;
use App\Mail\PaymentDoneMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['student', 'application', 'receivedBy']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('payment_id', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('consultancy.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $students = Student::orderBy('first_name')->get();
        $selectedStudent = $request->student_id ? Student::find($request->student_id) : null;
        $applications = $selectedStudent ? $selectedStudent->applications : collect();
        
        return view('consultancy.payments.create', compact('students', 'selectedStudent', 'applications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'application_id' => 'nullable|exists:applications,id',
            'payment_type' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'paid_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['paid_amount'] = $validated['paid_amount'] ?? 0;
        $validated['due_amount'] = $validated['amount'] - $validated['paid_amount'];
        
        if ($validated['paid_amount'] >= $validated['amount']) {
            $validated['status'] = 'completed';
            $validated['paid_date'] = now();
        } elseif ($validated['paid_amount'] > 0) {
            $validated['status'] = 'partial';
        } else {
            $validated['status'] = 'pending';
        }

        if ($validated['paid_amount'] > 0) {
            $validated['received_by'] = auth()->id();
        }

        $payment = Payment::create($validated);

        if ($validated['paid_amount'] > 0) {
            $payment->load('student');
            if ($payment->student && $payment->student->email) {
                try {
                    Mail::to($payment->student->email)->send(new PaymentDoneMail($payment));
                } catch (\Exception $e) {
                }
            }
        }

        return redirect()->route('consultancy.payments.show', $payment)
            ->with('success', 'Payment created successfully! ID: ' . $payment->payment_id);
    }

    public function show(Payment $payment)
    {
        $payment->load(['student', 'application', 'receivedBy', 'installments']);
        return view('consultancy.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $students = Student::orderBy('first_name')->get();
        $applications = $payment->student ? $payment->student->applications : collect();
        
        return view('consultancy.payments.edit', compact('payment', 'students', 'applications'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_type' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);

        return redirect()->route('consultancy.payments.show', $payment)
            ->with('success', 'Payment updated successfully!');
    }

    public function recordPayment(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $payment->due_amount,
            'payment_method' => 'required|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:255',
        ]);

        $payment->paid_amount += $validated['amount'];
        $payment->due_amount = $payment->amount - $payment->paid_amount;
        $payment->payment_method = $validated['payment_method'];
        $payment->transaction_id = $validated['transaction_id'];
        $payment->receipt_number = $validated['receipt_number'];
        $payment->received_by = auth()->id();

        if ($payment->due_amount <= 0) {
            $payment->status = 'completed';
            $payment->paid_date = now();
        } else {
            $payment->status = 'partial';
        }

        $payment->save();

        $payment->load('student');
        if ($payment->student && $payment->student->email) {
            try {
                Mail::to($payment->student->email)->send(new PaymentDoneMail($payment));
            } catch (\Exception $e) {
            }
        }

        return redirect()->route('consultancy.payments.show', $payment)
            ->with('success', 'Payment recorded successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('consultancy.payments.index')
            ->with('success', 'Payment deleted successfully!');
    }
}
