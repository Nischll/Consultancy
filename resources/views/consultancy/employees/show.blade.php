<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $employee->full_name }} - {{ $employee->employee_id }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('consultancy.employees.edit', $employee) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Edit</a>
                <a href="{{ route('consultancy.employees.attendance', $employee) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Attendance</a>
                <a href="{{ route('consultancy.employees.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Employee ID</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->employee_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Position</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->position ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Department</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->department ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Employment Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Hire Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->hire_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Employment Type</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $employee->employment_type)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                    @if($employee->status == 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($employee->status == 'inactive') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @elseif($employee->status == 'terminated') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $employee->status)) }}
                                </span>
                            </div>
                            @if($employee->salary)
                            <div>
                                <p class="text-sm text-gray-500">Salary</p>
                                <p class="font-medium text-gray-900 dark:text-white">${{ number_format($employee->salary, 2) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Photo -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        @if($employee->photo)
                            <img src="{{ asset($employee->photo) }}" alt="{{ $employee->full_name }}" class="w-full rounded-lg">
                        @else
                            <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400 text-4xl font-bold">{{ substr($employee->first_name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Today's Attendance -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Attendance</h3>
                        @if($todayAttendance)
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">Check In</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $todayAttendance->check_in ? $todayAttendance->check_in->format('h:i A') : 'Not checked in' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Check Out</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $todayAttendance->check_out ? $todayAttendance->check_out->format('h:i A') : 'Not checked out' }}
                                    </p>
                                </div>
                                @if($todayAttendance->hours_worked)
                                <div>
                                    <p class="text-sm text-gray-500">Hours Worked</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $todayAttendance->hours_worked }} hours</p>
                                </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No attendance record for today</p>
                        @endif

                        <div class="mt-4 space-y-2">
                            @if(!$todayAttendance || !$todayAttendance->check_in)
                            <form method="POST" action="{{ route('consultancy.employees.check-in', $employee) }}">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                    Check In
                                </button>
                            </form>
                            @endif
                            @if($todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out)
                            <form method="POST" action="{{ route('consultancy.employees.check-out', $employee) }}">
                                @csrf
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                    Check Out
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <!-- Monthly Stats -->
                    @if($thisMonthStats)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">This Month</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Present Days</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $thisMonthStats['present_days'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Absent Days</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $thisMonthStats['absent_days'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Total Hours</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $thisMonthStats['total_hours'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
