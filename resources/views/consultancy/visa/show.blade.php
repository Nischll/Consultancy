<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Visa: {{ $visa->visa_application_id }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('consultancy.visa.edit', $visa) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Edit</a>
                <a href="{{ route('consultancy.visa.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Visa Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Student</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('consultancy.students.show', $visa->student) }}" class="text-blue-600 hover:underline">
                                        {{ $visa->student->full_name ?? 'N/A' }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Visa Type</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->visa_type }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">University</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->application?->university?->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Embassy</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->embassy_location ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Timeline</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Submission Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->submission_date?->format('M d, Y') ?? 'Not submitted' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Interview Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->interview_date?->format('M d, Y h:i A') ?? 'Not scheduled' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Result Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->result_date?->format('M d, Y') ?? 'Pending' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Visa Issue Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->visa_issue_date?->format('M d, Y') ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($visa->status == 'approved')
                    <div class="bg-green-50 dark:bg-green-900 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Travel Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Visa Number</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->visa_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Visa Expiry</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->visa_expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Planned Departure</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->planned_departure_date?->format('M d, Y') ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Actual Departure</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->actual_departure_date?->format('M d, Y') ?? 'Not departed' }}</p>
                            </div>
                            @if($visa->flight_details)
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Flight Details</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $visa->flight_details }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($visa->status == 'rejected' && $visa->rejection_reason)
                    <div class="bg-red-50 dark:bg-red-900 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">Rejection Reason</h3>
                        <p class="text-red-700 dark:text-red-300">{{ $visa->rejection_reason }}</p>
                    </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                        <span class="px-4 py-2 text-lg rounded-full 
                            @if($visa->status == 'approved') bg-green-100 text-green-800
                            @elseif($visa->status == 'rejected') bg-red-100 text-red-800
                            @elseif(in_array($visa->status, ['submitted', 'processing'])) bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $visa->status)) }}
                        </span>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Counselor</h3>
                        <p class="text-gray-900 dark:text-white">{{ $visa->counselor?->user?->name ?? 'Unassigned' }}</p>
                    </div>

                    @if($visa->notes)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Notes</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $visa->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
