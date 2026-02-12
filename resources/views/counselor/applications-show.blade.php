<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Application: {{ $application->application_id }}
            </h2>
            <a href="{{ route('counselor.applications') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 text-sm">← Back to Applications</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded dark:bg-green-900/30 dark:border-green-700 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Application Details</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500 dark:text-gray-400">Student</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $application->student->full_name ?? 'N/A' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">University</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $application->university->name ?? 'N/A' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">Intake</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $application->intake ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">Course</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $application->course_type ?? $application->course_name ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">Application Date</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $application->application_date ? $application->application_date->format('M d, Y') : '—' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Update Status</h3>
                <form method="POST" action="{{ route('counselor.applications.update-status', $application) }}" class="flex flex-wrap items-end gap-4">
                    @csrf
                    @method('PATCH')
                    <div class="flex-1 min-w-[200px]">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                        <select name="status" id="status" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            @foreach(['draft', 'submitted', 'under_review', 'accepted', 'rejected', 'enrolled', 'withdrawn'] as $s)
                                <option value="{{ $s }}" {{ $application->status == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
