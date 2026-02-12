<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Application: {{ $application->application_id }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('consultancy.applications.edit', $application) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Edit</a>
                <a href="{{ route('consultancy.applications.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Application Details -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Application Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Student</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('consultancy.students.show', $application->student) }}" class="text-blue-600 hover:underline">
                                        {{ $application->student->full_name ?? 'N/A' }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">University</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->university->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Intake</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->intake }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Course</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->course_name ?? 'N/A' }} ({{ $application->course_type ?? 'N/A' }})</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Application Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->application_date?->format('M d, Y') ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Submission Deadline</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->submission_deadline?->format('M d, Y') ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Counselor</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->counselor->user->name ?? 'Unassigned' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Interview Details -->
                    @if($application->interview_date)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Interview Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Date & Time</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->interview_date->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Mode</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->interview_mode ?? 'N/A' }}</p>
                            </div>
                            @if($application->interview_notes)
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Notes</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->interview_notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- COE Status -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">COE (Certificate of Eligibility)</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="px-2 py-1 text-sm rounded-full 
                                    @if($application->coe_status == 'approved') bg-green-100 text-green-800
                                    @elseif($application->coe_status == 'rejected') bg-red-100 text-red-800
                                    @elseif($application->coe_status == 'processing') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $application->coe_status)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Applied Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->coe_applied_date?->format('M d, Y') ?? 'Not applied' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Received Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $application->coe_received_date?->format('M d, Y') ?? 'Not received' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payments -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Payments</h3>
                            <a href="{{ route('consultancy.payments.create', ['student_id' => $application->student_id, 'application_id' => $application->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">+ Add Payment</a>
                        </div>
                        @if($application->payments->count())
                            <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left text-xs text-gray-500 uppercase">
                                        <th class="pb-2">Type</th>
                                        <th class="pb-2">Amount</th>
                                        <th class="pb-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($application->payments as $payment)
                                    <tr>
                                        <td class="py-2 text-sm text-gray-900 dark:text-white">{{ $payment->payment_type }}</td>
                                        <td class="py-2 text-sm text-gray-900 dark:text-white">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                                        <td class="py-2">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($payment->status == 'completed') bg-green-100 text-green-800
                                                @elseif($payment->status == 'partial') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No payments recorded</p>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $application->application_id }}</h3>
                        <span class="mt-2 px-3 py-1 inline-flex text-sm rounded-full 
                            @if($application->status == 'accepted' || $application->status == 'enrolled') bg-green-100 text-green-800
                            @elseif($application->status == 'rejected') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                        </span>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Fees</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Application Fee</span>
                                <span class="font-medium text-gray-900 dark:text-white">¥{{ number_format($application->application_fee ?? 0) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tuition Fee</span>
                                <span class="font-medium text-gray-900 dark:text-white">¥{{ number_format($application->tuition_fee ?? 0) }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t">
                                <span class="text-gray-500">App Fee Paid</span>
                                @if($application->application_fee_paid)
                                    <span class="text-green-600">Yes</span>
                                @else
                                    <span class="text-red-600">No</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Visa Application -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Visa</h3>
                        </div>
                        @if($application->visaApplication)
                            <div class="space-y-2">
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="px-2 py-1 text-sm rounded-full 
                                    @if($application->visaApplication->status == 'approved') bg-green-100 text-green-800
                                    @elseif($application->visaApplication->status == 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $application->visaApplication->status)) }}
                                </span>
                                <a href="{{ route('consultancy.visa.show', $application->visaApplication) }}" class="text-sm text-blue-600 hover:text-blue-800 block mt-2">View Details →</a>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No visa application</p>
                            @if($application->status == 'accepted')
                                <a href="{{ route('consultancy.visa.create', ['student_id' => $application->student_id, 'application_id' => $application->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">+ Create Visa Application</a>
                            @endif
                        @endif
                    </div>

                    @if($application->notes)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Notes</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $application->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
