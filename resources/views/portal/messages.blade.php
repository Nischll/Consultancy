<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Messages List -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Messages</h3>
                        @if($communications->count() > 0)
                        <div class="space-y-4">
                            @foreach($communications as $communication)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $communication->subject }}</p>
                                        <p class="text-sm text-gray-500">
                                            @if($communication->user)
                                                {{ $communication->direction === 'incoming' ? 'From' : 'To' }}: {{ $communication->user->name }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($communication->direction === 'incoming') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst($communication->direction) }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">{{ $communication->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ Str::limit($communication->content, 150) }}</p>
                                @if($communication->type === 'email' && $communication->email_to)
                                <p class="text-xs text-gray-500 mt-2">Email: {{ $communication->email_to }}</p>
                                @endif
                                @if($communication->type === 'phone' && $communication->phone_number)
                                <p class="text-xs text-gray-500 mt-2">Phone: {{ $communication->phone_number }}</p>
                                @endif
                                @if($communication->type === 'meeting' && $communication->meeting_date)
                                <p class="text-xs text-gray-500 mt-2">Meeting: {{ $communication->meeting_date->format('M d, Y h:i A') }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $communications->links() }}
                        </div>
                        @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No messages found.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Send Message Form -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Send Message</h3>
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('portal.messages.send') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="subject" :value="__('Subject')" />
                                <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="content" :value="__('Message')" />
                                <textarea id="content" name="content" rows="6" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required></textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>
                            <div>
                                <x-primary-button>{{ __('Send Message') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
