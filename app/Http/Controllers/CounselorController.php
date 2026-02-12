<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CounselorController extends Controller
{
    public function index()
    {
        $counselors = Counselor::with(['user', 'students'])->get();
        return view('consultancy.counselors.index', compact('counselors'));
    }

    public function create()
    {
        // Get users who are admins/editors but not yet counselors (optional - for selecting existing user)
        $users = User::whereIn('role_id', [1, 2])
            ->whereDoesntHave('counselor')
            ->get();
        return view('consultancy.counselors.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Determine if creating new user or using existing
        $createNewUser = !$request->filled('user_id') || $request->user_id === 'new';
        
        if ($createNewUser) {
            // Validate new user creation
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'nullable|string|min:8|confirmed',
                'employee_id' => 'required|string|max:255|unique:counselors,employee_id|unique:employees,employee_id',
                'specialization' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'extension' => 'nullable|string|max:10',
                'max_students' => 'nullable|integer|min:1',
            ]);

            // Get Counselor role
            $counselorRole = Role::where('role', 'Counselor')->first();
            if (!$counselorRole) {
                return back()->withErrors(['error' => 'Counselor role not found. Please seed the database first.'])->withInput();
            }

            // Create User account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'] ?? 'password'),
                'role_id' => $counselorRole->id,
                'email_verified_at' => now(),
            ]);

            // Create Employee record (counselors need employee records)
            $nameParts = explode(' ', $validated['name'], 2);
            $employee = Employee::create([
                'user_id' => $user->id,
                'employee_id' => $validated['employee_id'],
                'first_name' => $nameParts[0] ?? $validated['name'],
                'last_name' => $nameParts[1] ?? '',
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'position' => 'Counselor',
                'department' => 'Counseling',
                'hire_date' => now(),
                'employment_type' => 'full_time',
                'status' => 'active',
            ]);

            // Create Counselor record
            $counselor = Counselor::create([
                'user_id' => $user->id,
                'employee_id' => $validated['employee_id'],
                'specialization' => $validated['specialization'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'extension' => $validated['extension'] ?? null,
                'is_active' => true,
                'max_students' => $validated['max_students'] ?? 50,
            ]);

            $message = 'Counselor created successfully!';
            if (!$request->filled('password')) {
                $message .= ' Default password: password';
            }

            return redirect()->route('consultancy.counselors.index')
                ->with('success', $message);
        } else {
            // Use existing user
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id|unique:counselors,user_id',
                'employee_id' => 'required|string|max:255|unique:counselors,employee_id',
                'specialization' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'extension' => 'nullable|string|max:10',
                'max_students' => 'nullable|integer|min:1',
            ]);

            $validated['is_active'] = true;

            Counselor::create($validated);

            return redirect()->route('consultancy.counselors.index')
                ->with('success', 'Counselor created successfully!');
        }
    }

    public function show(Counselor $counselor)
    {
        $counselor->load(['user', 'students', 'applications.student', 'visaApplications.student']);
        return view('consultancy.counselors.show', compact('counselor'));
    }

    public function edit(Counselor $counselor)
    {
        return view('consultancy.counselors.edit', compact('counselor'));
    }

    public function update(Request $request, Counselor $counselor)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|max:255|unique:counselors,employee_id,' . $counselor->id,
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'extension' => 'nullable|string|max:10',
            'max_students' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $counselor->update($validated);

            return redirect()->route('consultancy.counselors.show', $counselor)
            ->with('success', 'Counselor updated successfully!');
    }

    public function destroy(Counselor $counselor)
    {
        $counselor->delete();
        return redirect()->route('consultancy.counselors.index')
            ->with('success', 'Counselor deleted successfully!');
    }
}
