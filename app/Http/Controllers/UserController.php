<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        // Show all users except super admin (role_id 1)
        $users = User::where('role_id', '!=', 1)->get();
        return view('users.index', compact('users'));
    }
    
    public function create()
    {
        // Get all roles except super admin (role_id 1) - allow student, employee, teacher, hr, etc.
        $roles = Role::where('id', '!=', 1)->get();
        
        // Get counselors for student assignment
        $counselors = Counselor::with('user')->where('is_active', true)->get();
        
        return view('users.create', compact('roles', 'counselors'));
    }

    public function store(Request $request)
    {
        // Base validation
        $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Get the role to determine what type of record to create
        $role = Role::findOrFail($request->role_id);
        $roleName = strtolower(trim($role->role));

        // Role-specific validation
        if (in_array($roleName, ['student', 'students'])) {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
            ]);
        } elseif (in_array($roleName, ['employee', 'employees', 'teacher', 'teachers', 'hr', 'human resources'])) {
            $request->validate([
                'employee_id' => 'required|string|max:255|unique:employees,employee_id',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:255',
                'position' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'hire_date' => 'required|date',
                'employment_type' => 'required|in:full_time,part_time,contract,intern',
            ]);
        } elseif (in_array($roleName, ['counselor', 'counselors'])) {
            $request->validate([
                'employee_id' => 'required|string|max:255|unique:counselors,employee_id',
                'specialization' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
            ]);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
        ]);

        // Create role-specific records
        if (in_array($roleName, ['student', 'students'])) {
            // Create Student record
            $nameParts = explode(' ', $request->name, 2);
            $firstName = $request->first_name ?? ($nameParts[0] ?? $request->name);
            $lastName = $request->last_name ?? ($nameParts[1] ?? '');

            Student::create([
                'user_id' => $user->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'gender' => $request->gender ?? null,
                'date_of_birth' => $request->date_of_birth ?? null,
                'counselor_id' => $request->counselor_id ?? null,
                'status' => 'active',
            ]);
        } elseif (in_array($roleName, ['employee', 'employees', 'teacher', 'teachers', 'hr', 'human resources'])) {
            // Create Employee record
            $nameParts = explode(' ', $request->name, 2);
            $firstName = $request->first_name ?? ($nameParts[0] ?? $request->name);
            $lastName = $request->last_name ?? ($nameParts[1] ?? '');

            Employee::create([
                'user_id' => $user->id,
                'employee_id' => $request->employee_id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'date_of_birth' => $request->date_of_birth ?? null,
                'gender' => $request->gender ?? null,
                'address' => $request->address ?? null,
                'position' => $request->position ?? null,
                'department' => $request->department ?? null,
                'hire_date' => $request->hire_date,
                'employment_type' => $request->employment_type,
                'salary' => $request->salary ?? null,
                'status' => $request->status ?? 'active',
                'notes' => $request->notes ?? null,
            ]);
        } elseif (in_array($roleName, ['counselor', 'counselors'])) {
            // Create Counselor record (counselors are also employees)
            $nameParts = explode(' ', $request->name, 2);
            $firstName = $nameParts[0] ?? $request->name;
            $lastName = $nameParts[1] ?? '';

            // First create employee record if needed
            $employee = Employee::create([
                'user_id' => $user->id,
                'employee_id' => $request->employee_id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'position' => 'Counselor',
                'department' => 'Counseling',
                'hire_date' => $request->hire_date ?? now(),
                'employment_type' => $request->employment_type ?? 'full_time',
                'status' => 'active',
            ]);

            // Then create counselor record
            Counselor::create([
                'user_id' => $user->id,
                'employee_id' => $request->employee_id,
                'specialization' => $request->specialization ?? null,
                'phone' => $request->phone ?? null,
                'extension' => $request->extension ?? null,
                'is_active' => true,
                'max_students' => $request->max_students ?? 50,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User and related record created successfully.');
    }

    public function edit(User $user)
    {
        // Get all roles except super admin (role_id 1)
        $roles = Role::where('id', '!=', 1)->get();
        
        // Load related records
        $user->load(['student', 'employee', 'counselor']);
        
        // Get counselors for student assignment
        $counselors = Counselor::with('user')->where('is_active', true)->get();
        
        return view('users.edit', compact('user', 'roles', 'counselors'));
    }

    public function update(Request $request, User $user)
    {
        // Base validation
        $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Get the role to determine what type of record to update
        $role = Role::findOrFail($request->role_id);
        $roleName = strtolower(trim($role->role));

        // Role-specific validation
        if (in_array($roleName, ['student', 'students'])) {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
            ]);
        } elseif (in_array($roleName, ['employee', 'employees', 'teacher', 'teachers', 'hr', 'human resources'])) {
            $employeeId = $user->employee ? $user->employee->id : null;
            $employeeIdRule = $employeeId 
                ? 'required|string|max:255|unique:employees,employee_id,' . $employeeId . ',id'
                : 'required|string|max:255|unique:employees,employee_id';
            
            $request->validate([
                'employee_id' => $employeeIdRule,
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:255',
                'position' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'hire_date' => 'required|date',
                'employment_type' => 'required|in:full_time,part_time,contract,intern',
            ]);
        } elseif (in_array($roleName, ['counselor', 'counselors'])) {
            $counselorId = $user->counselor ? $user->counselor->id : null;
            $counselorIdRule = $counselorId 
                ? 'required|string|max:255|unique:counselors,employee_id,' . $counselorId . ',id'
                : 'required|string|max:255|unique:counselors,employee_id';
            
            $request->validate([
                'employee_id' => $counselorIdRule,
                'specialization' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
            ]);
        }

        // Update user basic info
        $user->name = $request->name;
        $user->role_id = $request->role_id;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Update or create role-specific records
        if (in_array($roleName, ['student', 'students'])) {
            // Update or create Student record
            if ($user->student) {
                $user->student->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'gender' => $request->gender ?? null,
                    'date_of_birth' => $request->date_of_birth ?? null,
                    'counselor_id' => $request->counselor_id ?? null,
                ]);
            } else {
                Student::create([
                    'user_id' => $user->id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'gender' => $request->gender ?? null,
                    'date_of_birth' => $request->date_of_birth ?? null,
                    'counselor_id' => $request->counselor_id ?? null,
                    'status' => 'active',
                ]);
            }
        } elseif (in_array($roleName, ['employee', 'employees', 'teacher', 'teachers', 'hr', 'human resources'])) {
            // Update or create Employee record
            if ($user->employee) {
                $user->employee->update([
                    'employee_id' => $request->employee_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone ?? null,
                    'date_of_birth' => $request->date_of_birth ?? null,
                    'gender' => $request->gender ?? null,
                    'address' => $request->address ?? null,
                    'position' => $request->position ?? null,
                    'department' => $request->department ?? null,
                    'hire_date' => $request->hire_date,
                    'employment_type' => $request->employment_type,
                    'salary' => $request->salary ?? null,
                    'status' => $request->status ?? 'active',
                    'notes' => $request->notes ?? null,
                ]);
            } else {
                Employee::create([
                    'user_id' => $user->id,
                    'employee_id' => $request->employee_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone ?? null,
                    'date_of_birth' => $request->date_of_birth ?? null,
                    'gender' => $request->gender ?? null,
                    'address' => $request->address ?? null,
                    'position' => $request->position ?? null,
                    'department' => $request->department ?? null,
                    'hire_date' => $request->hire_date,
                    'employment_type' => $request->employment_type,
                    'salary' => $request->salary ?? null,
                    'status' => $request->status ?? 'active',
                    'notes' => $request->notes ?? null,
                ]);
            }
        } elseif (in_array($roleName, ['counselor', 'counselors'])) {
            // Update or create Employee record first
            if ($user->employee) {
                $user->employee->update([
                    'employee_id' => $request->employee_id,
                    'first_name' => explode(' ', $request->name, 2)[0] ?? $request->name,
                    'last_name' => explode(' ', $request->name, 2)[1] ?? '',
                    'email' => $request->email,
                    'phone' => $request->phone ?? null,
                    'position' => 'Counselor',
                    'department' => 'Counseling',
                    'hire_date' => $request->hire_date ?? $user->employee->hire_date ?? now(),
                    'employment_type' => $request->employment_type ?? $user->employee->employment_type ?? 'full_time',
                    'status' => 'active',
                ]);
            } else {
                $nameParts = explode(' ', $request->name, 2);
                Employee::create([
                    'user_id' => $user->id,
                    'employee_id' => $request->employee_id,
                    'first_name' => $nameParts[0] ?? $request->name,
                    'last_name' => $nameParts[1] ?? '',
                    'email' => $request->email,
                    'phone' => $request->phone ?? null,
                    'position' => 'Counselor',
                    'department' => 'Counseling',
                    'hire_date' => $request->hire_date ?? now(),
                    'employment_type' => $request->employment_type ?? 'full_time',
                    'status' => 'active',
                ]);
            }

            // Update or create Counselor record
            if ($user->counselor) {
                $user->counselor->update([
                    'employee_id' => $request->employee_id,
                    'specialization' => $request->specialization ?? null,
                    'phone' => $request->phone ?? null,
                    'extension' => $request->extension ?? null,
                    'max_students' => $request->max_students ?? $user->counselor->max_students ?? 50,
                ]);
            } else {
                Counselor::create([
                    'user_id' => $user->id,
                    'employee_id' => $request->employee_id,
                    'specialization' => $request->specialization ?? null,
                    'phone' => $request->phone ?? null,
                    'extension' => $request->extension ?? null,
                    'is_active' => true,
                    'max_students' => $request->max_students ?? 50,
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User and related record updated successfully.');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
    
    
}
