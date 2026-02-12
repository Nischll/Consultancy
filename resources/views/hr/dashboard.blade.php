<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('HR Portal') }} - Welcome, {{ Auth::user()->name }}!
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Employees</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_employees'] }}</p>
                                </div>
                                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Active Employees</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['active_employees'] }}</p>
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Present Today</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['present_today'] }}</p>
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Monthly Attendance Rate</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['monthly_attendance_rate'] }}%</p>
                                </div>
                                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Attendance -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Attendance Records</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Employee</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Check In</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($recentAttendances as $attendance)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $attendance->check_in ? date('H:i', strtotime($attendance->check_in)) : 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $attendance->status == 'present' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $attendance->status == 'late' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $attendance->status == 'absent' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-center text-gray-500">No recent attendance records</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Low Attendance Employees -->
                    @if($lowAttendanceEmployees->count() > 0)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Employees with Low Attendance (This Month)</h3>
                        <div class="space-y-3">
                            @foreach($lowAttendanceEmployees as $employee)
                            <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $employee->position ?? 'N/A' }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $employee->present_count }} days
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Links -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                        <div class="space-y-2">
                            <a href="{{ route('hr.employees') }}" class="block p-3 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                                <p class="font-medium text-blue-900 dark:text-blue-100">View All Employees</p>
                            </a>
                            <a href="{{ route('hr.attendance') }}" class="block p-3 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition">
                                <p class="font-medium text-green-900 dark:text-green-100">Attendance Overview</p>
                            </a>
                        </div>
                    </div>

                    <!-- Profile Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Profile</h3>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-500">Name: <span class="text-gray-900 dark:text-white font-medium">{{ Auth::user()->name }}</span></p>
                            <p class="text-sm text-gray-500">Email: <span class="text-gray-900 dark:text-white font-medium">{{ Auth::user()->email }}</span></p>
                            <p class="text-sm text-gray-500">Role: <span class="text-gray-900 dark:text-white font-medium">HR</span></p>
                        </div>
                        <a href="{{ route('hr.profile') }}" class="mt-4 block text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
