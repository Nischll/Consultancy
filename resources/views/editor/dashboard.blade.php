<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editor Portal') }} - Welcome, {{ Auth::user()->name }}!
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">New Inquiries</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['new_inquiries'] }}</p>
                                </div>
                                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Applications -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Applications</h3>
                        <div class="space-y-3">
                            @forelse($recentApplications as $application)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $application->student->first_name }} {{ $application->student->last_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $application->university->name ?? 'N/A' }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-gray-500">No recent applications</p>
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
                                    <p class="text-sm text-gray-500">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
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
                            <a href="{{ route('consultancy.students.index') }}" class="block p-3 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                                <p class="font-medium text-blue-900 dark:text-blue-100">View All Students</p>
                            </a>
                            <a href="{{ route('consultancy.applications.index') }}" class="block p-3 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition">
                                <p class="font-medium text-green-900 dark:text-green-100">View Applications</p>
                            </a>
                            <a href="{{ route('consultancy.inquiries.index') }}" class="block p-3 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition">
                                <p class="font-medium text-purple-900 dark:text-purple-100">View Inquiries</p>
                            </a>
                        </div>
                    </div>

                    <!-- Profile Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Profile</h3>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-500">Name: <span class="text-gray-900 dark:text-white font-medium">{{ Auth::user()->name }}</span></p>
                            <p class="text-sm text-gray-500">Email: <span class="text-gray-900 dark:text-white font-medium">{{ Auth::user()->email }}</span></p>
                            <p class="text-sm text-gray-500">Role: <span class="text-gray-900 dark:text-white font-medium">Editor</span></p>
                        </div>
                        <a href="{{ route('editor.profile') }}" class="mt-4 block text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
