<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Inquiry: {{ $inquiry->inquiry_id }}
            </h2>
            <a href="{{ route('consultancy.inquiries.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $inquiry->subject }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $inquiry->message }}</p>
                    </div>

                    @if($inquiry->response)
                    <div class="bg-green-50 dark:bg-green-900 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Response</h3>
                        <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $inquiry->response }}</p>
                        <p class="text-sm text-gray-500 mt-2">Responded by {{ $inquiry->respondedBy->name ?? 'N/A' }} on {{ $inquiry->responded_at?->format('M d, Y h:i A') }}</p>
                    </div>
                    @endif

                    <!-- Response Form -->
                    @if($inquiry->status != 'converted' && $inquiry->status != 'closed')
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Update Inquiry</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">When you submit a response, it is saved here and a copy is emailed to the client (if they have an email address). You can convert this inquiry to a student at any time using the button on the right.</p>
                        <form action="{{ route('consultancy.inquiries.update', $inquiry) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                <select name="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    @foreach(['new', 'in_progress', 'responded', 'follow_up', 'closed'] as $status)
                                        <option value="{{ $status }}" {{ $inquiry->status == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Response message (emailed to client)</label>
                                <textarea name="response" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Type your response. It will be saved and emailed to the inquiry email address.">{{ old('response', $inquiry->response) }}</textarea>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Follow-up Date</label>
                                    <input type="datetime-local" name="follow_up_date" value="{{ old('follow_up_date', $inquiry->follow_up_date?->format('Y-m-d\TH:i')) }}"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Counselor</label>
                                    <select name="counselor_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        <option value="">Select</option>
                                        @foreach(\App\Models\Counselor::with('user')->where('is_active', true)->get() as $counselor)
                                            <option value="{{ $counselor->id }}" {{ $inquiry->counselor_id == $counselor->id ? 'selected' : '' }}>{{ $counselor->user->name ?? 'N/A' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update</button>
                        </form>
                    </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Details</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $inquiry->name ?? $inquiry->student?->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $inquiry->email ?? $inquiry->student?->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $inquiry->phone ?? $inquiry->student?->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Details</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Type</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($inquiry->type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Priority</span>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($inquiry->priority == 'urgent') bg-red-100 text-red-800
                                    @elseif($inquiry->priority == 'high') bg-orange-100 text-orange-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($inquiry->priority) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Status</span>
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Source</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $inquiry->source ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Created</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $inquiry->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($inquiry->status != 'converted')
                    <form action="{{ route('consultancy.inquiries.convert', $inquiry) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                            Convert to Student
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
