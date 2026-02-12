<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Document Details') }}
            </h2>
            <a href="{{ route('consultancy.documents.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400">
                ← Back to Documents
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 space-y-6">
                    <!-- Document Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Student</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">
                                {{ $document->student->full_name ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $document->student->student_id ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Document Type</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->document_type }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Title</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->title }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                            <span class="mt-1 inline-block px-3 py-1 text-xs font-semibold rounded-full
                                @if($document->status == 'verified') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($document->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                {{ ucfirst($document->status) }}
                            </span>
                        </div>
                        @if($document->expiry_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Expiry Date</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->expiry_date->format('M d, Y') }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Uploaded</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    @if($document->notes)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Notes</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->notes }}</p>
                    </div>
                    @endif

                    @if($document->rejection_reason)
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <label class="block text-sm font-medium text-red-800 dark:text-red-200">Rejection Reason</label>
                        <p class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $document->rejection_reason }}</p>
                    </div>
                    @endif

                    @if($document->verifiedBy)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Verified By</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->verifiedBy->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $document->verified_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @endif

                    <!-- File Preview -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Document File</label>
                        @if(in_array(strtolower($document->file_type), ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset($document->file_path) }}" alt="{{ $document->title }}" class="max-w-full h-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        @else
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $document->file_name }}</p>
                                <a href="{{ asset($document->file_path) }}" target="_blank" class="mt-2 inline-block text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    View/Download
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    @if($document->status == 'pending')
                    <div class="flex gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <form method="POST" action="{{ route('consultancy.documents.verify', $document) }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="status" value="verified">
                            <button type="submit" name="verify" value="1" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                Verify Document
                            </button>
                        </form>
                        <form method="POST" action="{{ route('consultancy.documents.verify', $document) }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <input type="text" name="rejection_reason" placeholder="Rejection reason (required)" required
                                class="w-full mb-2 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                Reject Document
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
