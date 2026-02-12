<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment History') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Month/Year Filter -->
                    <div class="mb-6 flex justify-end">
                        <form method="GET" class="flex gap-2">
                            <select name="month" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                @endfor
                            </select>
                            <select name="year" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                            <x-primary-button type="submit">Filter</x-primary-button>
                        </form>
                    </div>

                    <!-- Total Earnings Card -->
                    <div class="mb-6 p-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg text-white">
                        <p class="text-sm opacity-90">Total Earnings for {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</p>
                        <p class="text-4xl font-bold mt-2">NPR {{ number_format($totalEarnings, 2) }}</p>
                    </div>

                    <!-- Course Earnings Breakdown -->
                    @if(count($courseEarnings) > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Breakdown</h3>
                        <div class="space-y-4">
                            @foreach($courseEarnings as $earning)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $earning['course']->course_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $earning['course']->course_code }}</p>
                                    </div>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                                        NPR {{ number_format($earning['earning'], 2) }}
                                    </p>
                                </div>
                                <div class="grid grid-cols-3 gap-4 mt-3 text-sm">
                                    <div>
                                        <p class="text-gray-500">Hourly Rate</p>
                                        <p class="font-medium text-gray-900 dark:text-white">NPR {{ number_format($earning['hourly_rate'], 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Hours/Week</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $earning['hours_per_week'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Monthly Hours</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $earning['monthly_hours'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Attendance Summary -->
                    @if($attendances->count() > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Attendance Summary</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hours Worked</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($attendances as $attendance)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $attendance->date->format('M d, Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($attendance->status === 'present') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No attendance records for this month.</p>
                    </div>
                    @endif

                    <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            <strong>Note:</strong> Payments are calculated based on your assigned courses and attendance records. 
                            Actual payments may vary based on administrative review.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
