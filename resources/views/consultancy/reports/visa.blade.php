<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Visa Report') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="date" name="from_date" value="{{ request('from_date') }}"
                        class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <input type="date" name="to_date" value="{{ request('to_date') }}"
                        class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <select name="status" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">All Status</option>
                        @foreach(['submitted', 'processing', 'interview_scheduled', 'approved', 'rejected'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Generate</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Applications</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $summary['total'] }}</p>
                </div>
                <div class="bg-green-50 dark:bg-green-900 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Approved</p>
                    <p class="text-3xl font-bold text-green-600">{{ $summary['approved'] }}</p>
                </div>
                <div class="bg-red-50 dark:bg-red-900 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Rejected</p>
                    <p class="text-3xl font-bold text-red-600">{{ $summary['rejected'] }}</p>
                </div>
                <div class="bg-yellow-50 dark:bg-yellow-900 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Processing</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $summary['processing'] }}</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Approval Rate</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $summary['approval_rate'] }}%</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visa ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">University</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Departure</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($visaApplications as $visa)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $visa->visa_application_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $visa->student?->full_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $visa->application?->university?->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $visa->visa_type }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($visa->status == 'approved') bg-green-100 text-green-800
                                    @elseif($visa->status == 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $visa->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $visa->actual_departure_date?->format('M d, Y') ?? $visa->planned_departure_date?->format('M d, Y') ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
