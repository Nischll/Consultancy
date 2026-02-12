<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Attendance') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded dark:bg-red-900/30 dark:border-red-700 dark:text-red-200">{{ session('error') }}</div>
            @endif

            <!-- Today's Attendance - Check In / Check Out -->
            <div class="mb-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Attendance</h3>
                <div class="flex flex-wrap items-center gap-4">
                    @if(isset($todayAttendance) && $todayAttendance->check_in)
                        <p class="text-sm text-gray-500 dark:text-gray-400">Checked in: <strong class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') }}</strong></p>
                        @if(!$todayAttendance->check_out)
                            <form method="POST" action="{{ route('teacher.check-out') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm">Check Out</button>
                            </form>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Checked out: <strong class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') }}</strong></p>
                        @endif
                    @else
                        <form method="POST" action="{{ route('teacher.check-in') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm">Check In</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Attendance Form -->
                <div class="lg:col-span-1 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Mark Attendance</h3>
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('teacher.attendance.mark') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" value="{{ old('date', date('Y-m-d')) }}" required />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="late">Late</option>
                                    <option value="on_leave">On Leave</option>
                                    <option value="half_day">Half Day</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="check_in" :value="__('Check In Time')" />
                                <x-text-input id="check_in" name="check_in" type="time" class="mt-1 block w-full" value="{{ old('check_in') }}" />
                                <x-input-error :messages="$errors->get('check_in')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="check_out" :value="__('Check Out Time')" />
                                <x-text-input id="check_out" name="check_out" type="time" class="mt-1 block w-full" value="{{ old('check_out') }}" />
                                <x-input-error :messages="$errors->get('check_out')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="hours_worked" :value="__('Hours Worked')" />
                                <x-text-input id="hours_worked" name="hours_worked" type="number" step="0.5" min="0" max="24" class="mt-1 block w-full" value="{{ old('hours_worked') }}" />
                                <x-input-error :messages="$errors->get('hours_worked')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="notes" :value="__('Notes (Optional)')" />
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                            <div>
                                <x-primary-button>{{ __('Mark Attendance') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Attendance List -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Attendance History</h3>
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

                        <!-- Statistics -->
                        <div class="grid grid-cols-5 gap-4 mb-6">
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_days'] }}</p>
                                <p class="text-xs text-gray-500">Total Days</p>
                            </div>
                            <div class="text-center p-3 bg-green-50 dark:bg-green-900 rounded-lg">
                                <p class="text-2xl font-bold text-green-600">{{ $stats['present'] }}</p>
                                <p class="text-xs text-gray-500">Present</p>
                            </div>
                            <div class="text-center p-3 bg-red-50 dark:bg-red-900 rounded-lg">
                                <p class="text-2xl font-bold text-red-600">{{ $stats['absent'] }}</p>
                                <p class="text-xs text-gray-500">Absent</p>
                            </div>
                            <div class="text-center p-3 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                                <p class="text-2xl font-bold text-yellow-600">{{ $stats['late'] }}</p>
                                <p class="text-xs text-gray-500">Late</p>
                            </div>
                            <div class="text-center p-3 bg-blue-50 dark:bg-blue-900 rounded-lg">
                                <p class="text-2xl font-bold text-blue-600">{{ $stats['total_hours'] }}</p>
                                <p class="text-xs text-gray-500">Total Hours</p>
                            </div>
                        </div>

                        @if($attendances->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Check In</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Check Out</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hours</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($attendances as $attendance)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $attendance->date->format('M d, Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($attendance->status === 'present') bg-green-100 text-green-800
                                                @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                                                @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800
                                                @elseif($attendance->status === 'on_leave') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $attendance->check_in ? date('H:i', strtotime($attendance->check_in)) : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $attendance->check_out ? date('H:i', strtotime($attendance->check_out)) : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No attendance records for this month.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
