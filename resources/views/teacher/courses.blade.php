<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Courses') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($courses->count() > 0)
                    <div class="space-y-4">
                        @foreach($courses as $course)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $course->course_name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $course->course_code }} - {{ $course->level ?? 'N/A' }}
                                    </p>
                                    @if($course->description)
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ $course->description }}</p>
                                    @endif
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full 
                                    @if($course->pivot->status === 'active') bg-green-100 text-green-800
                                    @elseif($course->pivot->status === 'completed') bg-blue-100 text-blue-800
                                    @elseif($course->pivot->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst($course->pivot->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Duration</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $course->duration_hours ?? 'N/A' }} hours</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Hours/Week</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $course->pivot->hours_per_week ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Hourly Rate</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $course->pivot->hourly_rate ? $course->currency . ' ' . number_format($course->pivot->hourly_rate, 2) : 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Start Date</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $course->start_date?->format('M d, Y') ?? 'TBA' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">End Date</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $course->end_date?->format('M d, Y') ?? 'TBA' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Students</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $course->current_students }} / {{ $course->max_students }}
                                    </p>
                                </div>
                            </div>

                            @if($course->pivot->assigned_date)
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-500">Assigned Date: {{ \Carbon\Carbon::parse($course->pivot->assigned_date)->format('M d, Y') }}</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No courses assigned yet.</p>
                        <p class="text-sm text-gray-400 mt-2">Contact administration to get assigned to courses.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
