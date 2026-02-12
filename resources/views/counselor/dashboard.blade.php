<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Counselor Portal') }} - Welcome, {{ $counselor->user->name }}!
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Students</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_students'] }}</p>
                                </div>
                                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Active Students</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['active_students'] }}</p>
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Pending Applications</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_applications'] }}</p>
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Pending Tasks</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_tasks'] }}</p>
                                </div>
                                <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Applications -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pending Applications</h3>
                        <div class="space-y-3">
                            @forelse($pendingApplications as $application)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $application->student->first_name }} {{ $application->student->last_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $application->university->name ?? 'N/A' }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                                    {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-gray-500">No pending applications</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pending Tasks -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pending Tasks</h3>
                        <div class="space-y-3">
                            @forelse($pendingTasks as $task)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $task->title }}</p>
                                    <p class="text-sm text-gray-500">Student: {{ $task->student->first_name }} {{ $task->student->last_name }}</p>
                                    <p class="text-sm text-gray-500">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-800">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-gray-500">No pending tasks</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Links -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                        <div class="space-y-2">
                            <a href="{{ route('counselor.students') }}" class="block p-3 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                                <p class="font-medium text-blue-900 dark:text-blue-100">My Students</p>
                            </a>
                            <a href="{{ route('counselor.applications') }}" class="block p-3 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition">
                                <p class="font-medium text-green-900 dark:text-green-100">Applications</p>
                            </a>
                            <a href="{{ route('counselor.tasks') }}" class="block p-3 bg-yellow-50 dark:bg-yellow-900 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-800 transition">
                                <p class="font-medium text-yellow-900 dark:text-yellow-100">Tasks</p>
                            </a>
                            <a href="{{ route('counselor.messages') }}" class="block p-3 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition">
                                <p class="font-medium text-purple-900 dark:text-purple-100">Messages</p>
                            </a>
                        </div>
                    </div>

                    <!-- Profile Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Profile</h3>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-500">Specialization: <span class="text-gray-900 dark:text-white font-medium">{{ $counselor->specialization ?? 'General' }}</span></p>
                            <p class="text-sm text-gray-500">Phone: <span class="text-gray-900 dark:text-white font-medium">{{ $counselor->phone ?? 'N/A' }}</span></p>
                            <p class="text-sm text-gray-500">Max Students: <span class="text-gray-900 dark:text-white font-medium">{{ $counselor->max_students ?? 'N/A' }}</span></p>
                        </div>
                        <a href="{{ route('counselor.profile') }}" class="mt-4 block text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
