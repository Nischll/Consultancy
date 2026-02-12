<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Communication Details') }}
            </h2>
            <a href="{{ route('consultancy.communications.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400">
                ← Back to Communications
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 space-y-6">
                    <!-- Communication Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Student</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">
                                {{ $communication->student->full_name ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $communication->student->student_id ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Type</label>
                            <span class="mt-1 inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ ucfirst($communication->type) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Direction</label>
                            <span class="mt-1 inline-block px-3 py-1 text-xs font-semibold rounded-full
                                @if($communication->direction == 'incoming') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 @endif">
                                {{ ucfirst($communication->direction) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Date</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $communication->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @if($communication->subject)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Subject</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $communication->subject }}</p>
                        </div>
                        @endif
                        @if($communication->email_to)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email To</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $communication->email_to }}</p>
                        </div>
                        @endif
                        @if($communication->phone_number)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $communication->phone_number }}</p>
                        </div>
                        @endif
                        @if($communication->call_duration)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Call Duration</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $communication->call_duration }} minutes</p>
                        </div>
                        @endif
                        @if($communication->meeting_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Meeting Date</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $communication->meeting_date->format('M d, Y h:i A') }}</p>
                        </div>
                        @endif
                        @if($communication->meeting_location)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Meeting Location</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $communication->meeting_location }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Logged By</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $communication->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Content</label>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $communication->content }}</p>
                        </div>
                    </div>

                    <!-- Follow-up -->
                    @if($communication->requires_follow_up)
                    <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-orange-800 dark:text-orange-200">Follow-up Required</label>
                                @if($communication->follow_up_date)
                                <p class="mt-1 text-sm text-orange-700 dark:text-orange-300">
                                    Scheduled for: {{ $communication->follow_up_date->format('M d, Y h:i A') }}
                                </p>
                                @endif
                                <p class="mt-1 text-sm text-orange-700 dark:text-orange-300">
                                    Status: {{ $communication->follow_up_completed ? 'Completed' : 'Pending' }}
                                </p>
                            </div>
                            @if(!$communication->follow_up_completed)
                            <form method="POST" action="{{ route('consultancy.communications.follow-up', $communication) }}">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                    Mark as Completed
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <form method="POST" action="{{ route('consultancy.communications.destroy', $communication) }}" onsubmit="return confirm('Are you sure you want to delete this communication?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
