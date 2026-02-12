<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Portal') }} - Welcome, {{ $student->first_name }}!
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Overview -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Application Status</h3>
                        @if($activeApplication)
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $activeApplication->university->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $activeApplication->intake }} - {{ $activeApplication->course_type }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst(str_replace('_', ' ', $activeApplication->status)) }}
                                </span>
                            </div>
                            
                            <!-- Progress Steps -->
                            <div class="flex justify-between items-center mt-4">
                                @php
                                    $steps = ['applied', 'accepted', 'document_collection', 'visa_processing', 'visa_approved', 'departed'];
                                    $currentIndex = array_search($student->status, $steps);
                                    if ($currentIndex === false) {
                                        $currentIndex = in_array($student->status, ['document_collection', 'documents_preparing']) ? 2 : 0;
                                    }
                                @endphp
                                @foreach($steps as $index => $step)
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $index <= ($currentIndex ?: 0) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                        @if($index < ($currentIndex ?: 0))
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <p class="text-xs mt-1 text-gray-500">{{ ucfirst(str_replace('_', ' ', $step)) }}</p>
                                </div>
                                @if($index < count($steps) - 1)
                                <div class="flex-1 h-1 {{ $index < ($currentIndex ?: 0) ? 'bg-green-500' : 'bg-gray-200' }} mx-2"></div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">No active application. Contact your counselor to get started.</p>
                        @endif
                    </div>

                    @if(in_array($student->status, ['document_collection', 'documents_preparing']))
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                        <p class="text-amber-800 dark:text-amber-200 font-medium">You are in the <strong>Document collection</strong> step.</p>
                        <p class="text-sm text-amber-700 dark:text-amber-300 mt-1">Please prepare and upload the required documents so we can proceed with your visa application.</p>
                        <a href="{{ route('portal.documents') }}" class="inline-block mt-3 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg">Upload Documents</a>
                    </div>
                    @endif

                    <!-- Documents -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Documents</h3>
                            <a href="{{ route('portal.documents') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                        </div>
                        <div class="grid grid-cols-4 gap-4 text-center">
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $documentsStatus['total'] }}</p>
                                <p class="text-xs text-gray-500">Total</p>
                            </div>
                            <div class="p-3 bg-green-50 dark:bg-green-900 rounded-lg">
                                <p class="text-2xl font-bold text-green-600">{{ $documentsStatus['verified'] }}</p>
                                <p class="text-xs text-gray-500">Verified</p>
                            </div>
                            <div class="p-3 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                                <p class="text-2xl font-bold text-yellow-600">{{ $documentsStatus['pending'] }}</p>
                                <p class="text-xs text-gray-500">Pending</p>
                            </div>
                            <div class="p-3 bg-red-50 dark:bg-red-900 rounded-lg">
                                <p class="text-2xl font-bold text-red-600">{{ $documentsStatus['rejected'] }}</p>
                                <p class="text-xs text-gray-500">Rejected</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Assigned to You -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tasks Assigned to You</h3>
                            <a href="{{ route('portal.tasks') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                        </div>
                        @if($student->tasks && $student->tasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($student->tasks->take(5) as $task)
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 {{ $task->due_date && $task->due_date->isPast() ? 'border-l-4 border-l-red-500' : '' }}">
                                <div class="flex justify-between items-start gap-2">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $task->title }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            Due: {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No date' }}
                                            @if($task->assignedTo)
                                            · From: {{ $task->assignedTo->name }}
                                            @endif
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full shrink-0
                                        @if($task->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($task->priority == 'urgent') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No pending tasks assigned to you.</p>
                        @endif
                    </div>

                    <!-- Pending Payments -->
                    @if($pendingPayments->count())
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pending Payments</h3>
                            <a href="{{ route('portal.payments') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                        </div>
                        <div class="space-y-3">
                            @foreach($pendingPayments as $payment)
                            <div class="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $payment->description }}</p>
                                    <p class="text-sm text-gray-500">Due: {{ $payment->due_date?->format('M d, Y') ?? 'N/A' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-red-600">{{ $payment->currency }} {{ number_format($payment->due_amount, 2) }}</p>
                                    <p class="text-xs text-gray-500">remaining</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Profile Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                        @if($student->photo)
                            <img src="{{ asset($student->photo) }}" alt="" class="w-24 h-24 rounded-full mx-auto object-cover mb-4">
                        @else
                            <div class="w-24 h-24 rounded-full mx-auto bg-gray-200 flex items-center justify-center mb-4">
                                <span class="text-3xl text-gray-500">{{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $student->full_name }}</h3>
                        <p class="text-gray-500">{{ $student->student_id }}</p>
                        <span class="mt-2 px-3 py-1 inline-flex text-sm rounded-full bg-blue-100 text-blue-800">
                            {{ ucfirst(str_replace('_', ' ', $student->status)) }}
                        </span>
                        <a href="{{ route('portal.profile') }}" class="block mt-4 text-blue-600 hover:text-blue-800 text-sm">Edit Profile</a>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                        <div class="space-y-2">
                            <a href="{{ route('portal.tasks') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-white">My Tasks</span>
                            </a>
                            <a href="{{ route('portal.documents') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-white">Upload Documents</span>
                            </a>
                            <a href="{{ route('portal.applications') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-white">My Applications</span>
                            </a>
                            <a href="{{ route('portal.payments') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-white">Payment History</span>
                            </a>
                            <a href="{{ route('portal.messages') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-white">Messages</span>
                            </a>
                        </div>
                    </div>

                    <!-- Contact Counselor -->
                    @if($student->counselor)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Counselor</h3>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $student->counselor->user->name ?? 'N/A' }}</p>
                        @if($student->counselor->phone)
                        <p class="text-sm text-gray-500">{{ $student->counselor->phone }}</p>
                        @endif
                        <a href="{{ route('portal.messages') }}" class="mt-3 inline-block text-blue-600 hover:text-blue-800 text-sm">Send Message</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
