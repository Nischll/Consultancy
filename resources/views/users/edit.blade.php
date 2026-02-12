<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            User name:
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $user->name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            placeholder="Example: User"
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Role:
                        </label>
                        <select
                            name="role_id"
                            id="role_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        >
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" 
                                    {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->role }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email:
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            placeholder="Example: user@gmail.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Password:
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password confirmation -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Confirm Password:
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        >
                    </div>

                    <!-- Student Fields -->
                    <div id="student_fields" style="display: none;" class="border-t pt-4 mt-4">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Student Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name *</label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->student->first_name ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('first_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name *</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->student->last_name ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('last_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone *</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->student->phone ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('phone')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                                <select name="gender" id="gender"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('gender', $user->student->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->student->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->student->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->student->date_of_birth ? $user->student->date_of_birth->format('Y-m-d') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            </div>
                            <div>
                                <label for="counselor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Counselor</label>
                                <select name="counselor_id" id="counselor_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                    <option value="">Select Counselor</option>
                                    @foreach($counselors ?? [] as $counselor)
                                        <option value="{{ $counselor->id }}" {{ old('counselor_id', $user->student->counselor_id ?? '') == $counselor->id ? 'selected' : '' }}>
                                            {{ $counselor->user->name ?? 'Unknown' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address *</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $user->student->address ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('address')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City *</label>
                                <input type="text" name="city" id="city" value="{{ old('city', $user->student->city ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('city')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Employee/Teacher/HR Fields -->
                    <div id="employee_fields" style="display: none;" class="border-t pt-4 mt-4">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Employee Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="employee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employee ID *</label>
                                <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $user->employee->employee_id ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('employee_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="first_name_emp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name *</label>
                                <input type="text" name="first_name" id="first_name_emp" value="{{ old('first_name', $user->employee->first_name ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('first_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="last_name_emp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name *</label>
                                <input type="text" name="last_name" id="last_name_emp" value="{{ old('last_name', $user->employee->last_name ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('last_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="phone_emp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                <input type="text" name="phone" id="phone_emp" value="{{ old('phone', $user->employee->phone ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            </div>
                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                                <input type="text" name="position" id="position" value="{{ old('position', $user->employee->position ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            </div>
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                <input type="text" name="department" id="department" value="{{ old('department', $user->employee->department ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            </div>
                            <div>
                                <label for="hire_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hire Date *</label>
                                <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date', $user->employee->hire_date ? $user->employee->hire_date->format('Y-m-d') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('hire_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="employment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employment Type *</label>
                                <select name="employment_type" id="employment_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                    <option value="">Select</option>
                                    <option value="full_time" {{ old('employment_type', $user->employee->employment_type ?? '') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="part_time" {{ old('employment_type', $user->employee->employment_type ?? '') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="contract" {{ old('employment_type', $user->employee->employment_type ?? '') == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="intern" {{ old('employment_type', $user->employee->employment_type ?? '') == 'intern' ? 'selected' : '' }}>Intern</option>
                                </select>
                                @error('employment_type')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salary</label>
                                <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary', $user->employee->salary ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            </div>
                            <div>
                                <label for="gender_emp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                                <select name="gender" id="gender_emp"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('gender', $user->employee->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->employee->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->employee->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Counselor Fields -->
                    <div id="counselor_fields" style="display: none;" class="border-t pt-4 mt-4">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Counselor Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="employee_id_counselor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employee ID *</label>
                                <input type="text" name="employee_id" id="employee_id_counselor" value="{{ old('employee_id', $user->counselor->employee_id ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @error('employee_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="specialization" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Specialization</label>
                                <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $user->counselor->specialization ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                    placeholder="e.g., Language School, University, Visa">
                            </div>
                            <div>
                                <label for="phone_counselor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                <input type="text" name="phone" id="phone_counselor" value="{{ old('phone', $user->counselor->phone ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            </div>
                            <div>
                                <label for="extension" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Extension</label>
                                <input type="text" name="extension" id="extension" value="{{ old('extension', $user->counselor->extension ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            </div>
                            <div>
                                <label for="max_students" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Students</label>
                                <input type="number" name="max_students" id="max_students" value="{{ old('max_students', $user->counselor->max_students ?? 50) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            </div>
                            <div>
                                <label for="hire_date_counselor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hire Date</label>
                                <input type="date" name="hire_date" id="hire_date_counselor" value="{{ old('hire_date', $user->employee->hire_date ? $user->employee->hire_date->format('Y-m-d') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            </div>
                            <div>
                                <label for="employment_type_counselor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employment Type</label>
                                <select name="employment_type" id="employment_type_counselor"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                    <option value="full_time" {{ old('employment_type', $user->employee->employment_type ?? 'full_time') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="part_time" {{ old('employment_type', $user->employee->employment_type ?? '') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="contract" {{ old('employment_type', $user->employee->employment_type ?? '') == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="intern" {{ old('employment_type', $user->employee->employment_type ?? '') == 'intern' ? 'selected' : '' }}>Intern</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('users.index') }}" class="mr-4 text-gray-600 hover:text-gray-800">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role_id');
            const studentFields = document.getElementById('student_fields');
            const employeeFields = document.getElementById('employee_fields');
            const counselorFields = document.getElementById('counselor_fields');

            function toggleFields() {
                const selectedText = roleSelect.options[roleSelect.selectedIndex].text.trim().toLowerCase();
                
                // Hide all role-specific fields first
                studentFields.style.display = 'none';
                employeeFields.style.display = 'none';
                counselorFields.style.display = 'none';

                // Show appropriate fields based on role
                if (selectedText === 'student' || selectedText === 'students') {
                    studentFields.style.display = 'block';
                } else if (selectedText === 'employee' || selectedText === 'employees' || 
                          selectedText === 'teacher' || selectedText === 'teachers' || 
                          selectedText === 'hr' || selectedText === 'human resources') {
                    employeeFields.style.display = 'block';
                } else if (selectedText === 'counselor' || selectedText === 'counselors') {
                    counselorFields.style.display = 'block';
                }
            }

            // Check on page load to show fields for current role
            toggleFields();

            // Check when role changes
            roleSelect.addEventListener('change', toggleFields);
        });
    </script>
</x-app-layout>