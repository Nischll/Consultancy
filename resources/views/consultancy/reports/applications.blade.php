<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Applications Report') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <input type="date" name="from_date" value="{{ request('from_date') }}"
                        class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <input type="date" name="to_date" value="{{ request('to_date') }}"
                        class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <select name="status" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">All Status</option>
                        @foreach(['submitted', 'under_review', 'interview_scheduled', 'accepted', 'rejected', 'enrolled'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                    <select name="university_id" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">All Universities</option>
                        @foreach($universities as $university)
                            <option value="{{ $university->id }}" {{ request('university_id') == $university->id ? 'selected' : '' }}>{{ $university->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Generate</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Applications</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $summary['total'] }}</p>
                </div>
                <div class="bg-green-50 dark:bg-green-900 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Acceptance Rate</p>
                    <p class="text-3xl font-bold text-green-600">{{ $summary['acceptance_rate'] }}%</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">By Status</p>
                    <div class="mt-2 space-y-1 max-h-32 overflow-y-auto">
                        @foreach($summary['by_status'] as $status => $count)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                            <span class="font-medium">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Top Universities</p>
                    <div class="mt-2 space-y-1 max-h-32 overflow-y-auto">
                        @foreach($summary['by_university']->take(5) as $uni => $count)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ $uni ?? 'N/A' }}</span>
                            <span class="font-medium">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Application ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">University</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Intake</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">COE</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($applications as $app)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $app->application_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $app->student?->full_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $app->university?->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $app->intake }}</td>
                            <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_', ' ', $app->status)) }}</span></td>
                            <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ ucfirst(str_replace('_', ' ', $app->coe_status)) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
