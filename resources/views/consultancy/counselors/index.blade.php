<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Counselors Management') }}
            </h2>
            <a href="{{ route('consultancy.counselors.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                + Add Counselor
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($counselors as $counselor)
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $counselor->user->name ?? 'N/A' }}</h3>
                            <p class="text-sm text-gray-500">{{ $counselor->employee_id }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $counselor->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $counselor->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Specialization</span>
                            <span class="text-gray-900 dark:text-white">{{ $counselor->specialization ?? 'General' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Students</span>
                            <span class="text-gray-900 dark:text-white">{{ $counselor->students->count() }} / {{ $counselor->max_students }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Phone</span>
                            <span class="text-gray-900 dark:text-white">{{ $counselor->phone ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t flex justify-between">
                        <a href="{{ route('consultancy.counselors.show', $counselor) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                        <a href="{{ route('consultancy.counselors.edit', $counselor) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                    No counselors found. Add your first counselor.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
