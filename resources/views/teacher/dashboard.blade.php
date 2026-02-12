<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teacher Portal') }} - Welcome, {{ $teacher->first_name }}!
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Courses</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_courses'] }}</p>
                                </div>
                                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Active Courses</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['active_courses'] }}</p>
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Monthly Attendance</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['monthly_attendance'] }}</p>
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Hours This Month</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_hours_this_month'] }}</p>
                                </div>
                                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Courses -->
                    @if($upcomingCourses->count() > 0)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Upcoming Courses</h3>
                        <div class="space-y-3">
                            @foreach($upcomingCourses as $course)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $course->course_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $course->course_code }}</p>
                                        <p class="text-sm text-gray-500 mt-1">Starts: {{ $course->start_date?->format('M d, Y') ?? 'TBA' }}</p>
                                    </div>
                                    <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Recent Attendance -->
                    @if($recentAttendance->count() > 0)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Attendance</h3>
                            <a href="{{ route('teacher.attendance') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hours</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentAttendance as $attendance)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $attendance->date->format('M d, Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($attendance->status === 'present') bg-green-100 text-green-800
                                                @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                                                @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800
                                                @else bg-blue-100 text-blue-800
                                                @endif">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Profile Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                        @if($teacher->photo)
                            <img src="{{ asset($teacher->photo) }}" alt="" class="w-24 h-24 rounded-full mx-auto object-cover mb-4">
                        @else
                            <div class="w-24 h-24 rounded-full mx-auto bg-gray-200 flex items-center justify-center mb-4">
                                <span class="text-3xl text-gray-500">{{ substr($teacher->first_name, 0, 1) }}{{ substr($teacher->last_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $teacher->full_name }}</h3>
                        <p class="text-gray-500">{{ $teacher->employee_id }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $teacher->position }}</p>
                        <a href="{{ route('teacher.profile') }}" class="block mt-4 text-blue-600 hover:text-blue-800 text-sm">Edit Profile</a>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                        <div class="space-y-2">
                            <a href="{{ route('teacher.courses') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100">
                                <span class="text-gray-900 dark:text-white">My Courses</span>
                            </a>
                            <a href="{{ route('teacher.attendance') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100">
                                <span class="text-gray-900 dark:text-white">Mark Attendance</span>
                            </a>
                            <a href="{{ route('teacher.payments') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100">
                                <span class="text-gray-900 dark:text-white">Payment History</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
