<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Applications') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($applications->count() > 0)
                    <div class="space-y-4">
                        @foreach($applications as $application)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $application->university->name ?? 'N/A' }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $application->course_name ?? $application->course_type }} - {{ $application->intake }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full 
                                    @if($application->status === 'accepted') bg-green-100 text-green-800
                                    @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                    @elseif($application->status === 'enrolled') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Application ID</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $application->application_id }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Application Date</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $application->application_date?->format('M d, Y') ?? $application->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                @if($application->submitted_at)
                                <div>
                                    <p class="text-sm text-gray-500">Submitted Date</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $application->submitted_at->format('M d, Y') }}</p>
                                </div>
                                @endif
                                @if($application->result_date)
                                <div>
                                    <p class="text-sm text-gray-500">Result Date</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $application->result_date->format('M d, Y') }}</p>
                                </div>
                                @endif
                            </div>

                            @if($application->visaApplication)
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">Visa Application Status</p>
                                <span class="px-3 py-1 text-sm rounded-full 
                                    @if($application->visaApplication->status === 'approved') bg-green-100 text-green-800
                                    @elseif($application->visaApplication->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $application->visaApplication->status)) }}
                                </span>
                            </div>
                            @endif

                            @if($application->notes)
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-500">Notes</p>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $application->notes }}</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No applications found.</p>
                        <p class="text-sm text-gray-400 mt-2">Contact your counselor to start an application.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
