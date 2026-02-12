<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Task Details
            </h2>
            <a href="{{ route('consultancy.tasks.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{ $task->title }}</h3>
                
                <div class="space-y-4">
                    @if($task->description)
                    <div>
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="text-gray-900 dark:text-white">{{ $task->description }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Type</p>
                            <p class="text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $task->type)) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Priority</p>
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($task->priority == 'urgent') bg-red-100 text-red-800
                                @elseif($task->priority == 'high') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($task->status == 'completed') bg-green-100 text-green-800
                                @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Due Date</p>
                            <p class="text-gray-900 dark:text-white {{ $task->due_date && $task->due_date->isPast() ? 'text-red-600' : '' }}">
                                {{ $task->due_date?->format('M d, Y') ?? 'No date' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Assigned To</p>
                            <p class="text-gray-900 dark:text-white">{{ $task->assignedTo?->name ?? 'Unassigned' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Student</p>
                            <p class="text-gray-900 dark:text-white">{{ $task->student?->full_name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="flex space-x-4 pt-4">
                        <a href="{{ route('consultancy.tasks.edit', $task) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Edit</a>
                        @if($task->status != 'completed')
                        <form action="{{ route('consultancy.tasks.complete', $task) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">Mark Complete</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
