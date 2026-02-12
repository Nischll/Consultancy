<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Tasks') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded dark:bg-green-900/30 dark:border-green-700 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" class="flex gap-4">
                    <select name="status" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md">Filter</button>
                </form>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Student</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Priority</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Due Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($tasks as $task)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $task->title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $task->student ? $task->student->full_name : '—' }}</td>
                            <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full
                                {{ $task->priority == 'high' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                {{ $task->priority == 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                {{ $task->priority == 'low' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}">{{ ucfirst($task->priority) }}</span></td>
                            <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full
                                @if($task->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">{{ ucfirst($task->status) }}</span></td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($task->status != 'completed')
                                <form method="POST" action="{{ route('editor.tasks.complete', $task) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:text-green-800 dark:text-green-400">Mark complete</button>
                                </form>
                                @else
                                —
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No tasks assigned to you.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700">{{ $tasks->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
