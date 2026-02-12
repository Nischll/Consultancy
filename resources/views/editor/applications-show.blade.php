<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Application: {{ $application->application_id ?? $application->id }}
            </h2>
            <a href="{{ route('editor.applications') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 text-sm">← Back to Applications</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500 dark:text-gray-400">Student</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $application->student->full_name ?? 'N/A' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">University</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $application->university->name ?? 'N/A' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">Intake</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $application->intake ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">Status</dt><dd><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">{{ ucfirst(str_replace('_', ' ', $application->status)) }}</span></dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">Application Date</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $application->application_date ? $application->application_date->format('M d, Y') : ($application->created_at ? $application->created_at->format('M d, Y') : '—') }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
