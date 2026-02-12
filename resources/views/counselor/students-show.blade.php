<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $student->full_name }} ({{ $student->student_id }})
            </h2>
            <a href="{{ route('counselor.students') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 text-sm">← Back to Students</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Student Details</h3>
                    <dl class="space-y-2 text-sm">
                        <div><dt class="text-gray-500 dark:text-gray-400">Email</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $student->email }}</dd></div>
                        <div><dt class="text-gray-500 dark:text-gray-400">Phone</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $student->phone ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500 dark:text-gray-400">Status</dt><dd><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">{{ ucfirst(str_replace('_', ' ', $student->status ?? 'N/A')) }}</span></dd></div>
                        <div><dt class="text-gray-500 dark:text-gray-400">Target Intake</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $student->target_intake ?? '—' }}</dd></div>
                    </dl>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Applications ({{ $student->applications->count() }})</h3>
                    @if($student->applications->count())
                    <ul class="space-y-2">
                        @foreach($student->applications as $app)
                        <li class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700 rounded">
                            <span class="text-gray-900 dark:text-white">{{ $app->university->name ?? 'N/A' }} — {{ $app->intake ?? $app->application_id }}</span>
                            <a href="{{ route('counselor.applications.show', $app) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm">View</a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-gray-500 dark:text-gray-400">No applications yet.</p>
                    @endif
                </div>
            </div>
            <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Documents ({{ $student->documents->count() }})</h3>
                @if($student->documents->count())
                <ul class="space-y-2 text-sm">
                    @foreach($student->documents as $doc)
                    <li class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700 rounded">
                        <span class="text-gray-900 dark:text-white">{{ $doc->title }} ({{ ucfirst($doc->status) }})</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-500 dark:text-gray-400">No documents uploaded.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
