<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employee Portal') }} - Welcome, {{ $employee->first_name }}!
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded dark:bg-green-900/30 dark:border-green-700 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded dark:bg-red-900/30 dark:border-red-700 dark:text-red-200">
                    {{ session('error') }}
                </div>
            @endif
            <!-- Check-in / Check-out -->
            <div class="mb-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Attendance</h3>
                <div class="flex flex-wrap items-center gap-4">
                    @if(isset($todayAttendance) && $todayAttendance->check_in)
                        <p class="text-sm text-gray-500 dark:text-gray-400">Checked in: <strong class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') }}</strong></p>
                        @if(!$todayAttendance->check_out)
                            <form method="POST" action="{{ route('employee.check-out') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm">Check Out</button>
                            </form>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Checked out: <strong class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') }}</strong></p>
                        @endif
                    @else
                        <form method="POST" action="{{ route('employee.check-in') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm">Check In</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Days Present (This Month)</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_attendance_days'] }}</p>
                                </div>
                                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Late Days (This Month)</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_late_days'] }}</p>
                                </div>
                                <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Absent Days (This Month)</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_absent_days'] }}</p>
                                </div>
                                <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Hours Worked (This Month)</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_hours_worked'], 1) }}</p>
                                </div>
                                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Attendance -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Attendance</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Check In</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Check Out</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hours</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($recentAttendance as $attendance)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $attendance->check_in ? date('H:i', strtotime($attendance->check_in)) : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $attendance->check_out ? date('H:i', strtotime($attendance->check_out)) : 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $attendance->status == 'present' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $attendance->status == 'late' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $attendance->status == 'absent' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $attendance->status == 'on_leave' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">No attendance records found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Employee Info -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Employee Information</h3>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-500">Employee ID: <span class="text-gray-900 dark:text-white font-medium">{{ $employee->employee_id }}</span></p>
                            <p class="text-sm text-gray-500">Position: <span class="text-gray-900 dark:text-white font-medium">{{ $employee->position ?? 'N/A' }}</span></p>
                            <p class="text-sm text-gray-500">Department: <span class="text-gray-900 dark:text-white font-medium">{{ $employee->department ?? 'N/A' }}</span></p>
                            <p class="text-sm text-gray-500">Employment Type: <span class="text-gray-900 dark:text-white font-medium">{{ ucfirst(str_replace('_', ' ', $employee->employment_type ?? 'N/A')) }}</span></p>
                        </div>
                        <a href="{{ route('employee.profile') }}" class="mt-4 block text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                            Edit Profile
                        </a>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                        <div class="space-y-2">
                            <a href="{{ route('employee.attendance') }}" class="block p-3 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                                <p class="font-medium text-blue-900 dark:text-blue-100">View Attendance History</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
