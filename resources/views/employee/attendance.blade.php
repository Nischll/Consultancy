<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Attendance') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded dark:bg-green-900/30 dark:border-green-700 dark:text-green-200">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded dark:bg-red-900/30 dark:border-red-700 dark:text-red-200">{{ session('error') }}</div>
            @endif

            <!-- Today's Attendance - Check In / Check Out -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6 border-l-4 border-indigo-500">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Attendance</h3>
                <div class="flex flex-wrap items-center gap-4">
                    @if(isset($todayAttendance) && $todayAttendance->check_in)
                        <p class="text-sm text-gray-500 dark:text-gray-400">Checked in: <strong class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') }}</strong></p>
                        @if(!$todayAttendance->check_out)
                            <form method="POST" action="{{ route('employee.check-out') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm">Check Out</button>
                            </form>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Checked out: <strong class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') }}</strong></p>
                        @endif
                    @else
                        <form method="POST" action="{{ route('employee.check-in') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm">Check In</button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" class="flex gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Month</label>
                        <select name="month" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year</label>
                        <select name="year" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            @for($i = date('Y') - 2; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Filter</button>
                    </div>
                </form>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Present</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['present'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Late</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['late'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Absent</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['absent'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Hours</p>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_hours'], 1) }}</p>
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Check In</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Check Out</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hours Worked</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($attendances as $attendance)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $attendance->check_in ? date('H:i', strtotime($attendance->check_in)) : 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $attendance->check_out ? date('H:i', strtotime($attendance->check_out)) : 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $attendance->status == 'present' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $attendance->status == 'late' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $attendance->status == 'absent' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $attendance->status == 'on_leave' ? 'bg-blue-100 text-blue-800' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-gray-500">No attendance records found for this period</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
