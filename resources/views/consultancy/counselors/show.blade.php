<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Counselor: {{ $counselor->user->name ?? 'N/A' }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('consultancy.counselors.edit', $counselor) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Edit</a>
                <a href="{{ route('consultancy.counselors.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Profile</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $counselor->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Employee ID</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $counselor->employee_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $counselor->user->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $counselor->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Specialization</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $counselor->specialization ?? 'General' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Students Capacity</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $counselor->students->count() }} / {{ $counselor->max_students }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Assigned Students ({{ $counselor->students->count() }})</h3>
                        @if($counselor->students->count())
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach($counselor->students as $student)
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $student->full_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $student->student_id }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_', ' ', $student->status)) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">No students assigned</p>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Applications</h3>
                        @if($counselor->applications->count())
                        <div class="space-y-2">
                            @foreach($counselor->applications->take(5) as $app)
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $app->student->full_name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $app->application_id }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_', ' ', $app->status)) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">No applications</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
