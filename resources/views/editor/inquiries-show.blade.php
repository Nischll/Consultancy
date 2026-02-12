<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Inquiry #{{ $inquiry->id }}
            </h2>
            <a href="{{ route('editor.inquiries') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 text-sm">← Back to Inquiries</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500 dark:text-gray-400">Student / Contact</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $inquiry->student ? $inquiry->student->full_name : ($inquiry->name ?? 'N/A') }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">Status</dt><dd><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">{{ ucfirst($inquiry->status ?? 'N/A') }}</span></dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">Email</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $inquiry->email ?? ($inquiry->student->email ?? '—') }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400">Date</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $inquiry->created_at ? $inquiry->created_at->format('M d, Y H:i') : '—' }}</dd></div>
                </dl>
                @if($inquiry->message ?? $inquiry->notes ?? null)
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Message / Notes</p>
                    <p class="text-gray-900 dark:text-white mt-1">{{ $inquiry->message ?? $inquiry->notes ?? '—' }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
