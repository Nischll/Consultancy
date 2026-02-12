<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $course->course_code }} — {{ $course->course_name }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('consultancy.courses.edit', $course) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Edit</a>
                <a href="{{ route('consultancy.courses.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
            </div>
        </div>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Code</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $course->course_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Level</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $course->level ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Duration</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $course->duration_hours ? $course->duration_hours . ' hours' : '—' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Fee</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $course->currency }} {{ $course->fee ? number_format($course->fee, 2) : '—' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Students</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $course->current_students ?? 0 }} / {{ $course->max_students ?? 30 }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                <span class="inline-block px-2 py-1 text-xs rounded-full
                                    @if($course->status == 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($course->status == 'completed') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @elseif($course->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </div>
                        </div>
                        @if($course->description)
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                            <p class="text-gray-900 dark:text-white mt-1">{{ $course->description }}</p>
                        </div>
                        @endif
                        @if($course->start_date || $course->end_date)
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Dates</p>
                            <p class="text-gray-900 dark:text-white mt-1">{{ $course->start_date?->format('M d, Y') ?? '—' }} — {{ $course->end_date?->format('M d, Y') ?? '—' }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Assigned Teachers -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Assigned Teachers ({{ $course->teachers->count() }})</h3>
                        @if($course->teachers->count())
                        <div class="space-y-3">
                            @foreach($course->teachers as $teacher)
                            <div class="flex justify-between items-start p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $teacher->full_name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $teacher->email ?? $teacher->user?->email ?? '—' }}</p>
                                    <div class="mt-2 flex flex-wrap gap-3 text-xs text-gray-500 dark:text-gray-400">
                                        @if($teacher->pivot->hourly_rate)<span>Rate: {{ $teacher->pivot->hourly_rate }}</span>@endif
                                        @if($teacher->pivot->hours_per_week)<span>{{ $teacher->pivot->hours_per_week }} hrs/week</span>@endif
                                        @if($teacher->pivot->assigned_date)<span>From: {{ \Carbon\Carbon::parse($teacher->pivot->assigned_date)->format('M d, Y') }}</span>@endif
                                        <span class="px-2 py-0.5 rounded {{ $teacher->pivot->status == 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-300' }}">{{ ucfirst($teacher->pivot->status) }}</span>
                                    </div>
                                    @if($teacher->pivot->notes)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $teacher->pivot->notes }}</p>
                                    @endif
                                </div>
                                <form method="POST" action="{{ route('consultancy.courses.unassign-teacher', [$course, $teacher]) }}" class="shrink-0" onsubmit="return confirm('Remove this teacher from the course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 text-sm">Remove</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No teachers assigned yet. Use the form on the right to assign a teacher.</p>
                        @endif
                    </div>
                </div>

                <!-- Assign Teacher -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Assign Teacher to Course</h3>
                        <form method="POST" action="{{ route('consultancy.courses.assign-teacher', $course) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teacher *</label>
                                <select name="teacher_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">Select teacher</option>
                                    @foreach($teachers as $t)
                                        @if(!$course->teachers->contains($t))
                                        <option value="{{ $t->id }}" {{ old('teacher_id') == $t->id ? 'selected' : '' }}>{{ $t->full_name }} ({{ $t->employee_id ?? $t->email }})</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if($teachers->isEmpty())
                                <p class="text-amber-600 dark:text-amber-400 text-sm mt-1">No teachers (Employees with role Teacher) found. Add employees with teacher role first.</p>
                                @elseif($course->teachers->count() >= $teachers->count())
                                <p class="text-amber-600 dark:text-amber-400 text-sm mt-1">All teachers are already assigned to this course.</p>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hourly Rate</label>
                                    <input type="number" name="hourly_rate" value="{{ old('hourly_rate') }}" min="0" step="0.01"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hours/Week</label>
                                    <input type="number" name="hours_per_week" value="{{ old('hours_per_week', 0) }}" min="0"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                <select name="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    @foreach(['assigned', 'active', 'completed', 'cancelled'] as $s)
                                        <option value="{{ $s }}" {{ old('status', 'assigned') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assigned Date</label>
                                <input type="date" name="assigned_date" value="{{ old('assigned_date', date('Y-m-d')) }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                                <textarea name="notes" rows="2" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Assign Teacher</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
