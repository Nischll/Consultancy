<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Day-to-Day Task Recording') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded dark:bg-green-900/30 dark:border-green-700 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Record Task Form -->
                <div class="lg:col-span-1 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Record Today's Task</h3>
                        <form action="{{ route('teacher.daily-log.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="log_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date *</label>
                                <input type="date" name="log_date" id="log_date" value="{{ old('log_date', date('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                @error('log_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course (optional)</label>
                                <select name="course_id" id="course_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">— None —</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->course_code }} - {{ $c->course_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="hours_taught" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hours taught</label>
                                <input type="number" name="hours_taught" id="hours_taught" value="{{ old('hours_taught') }}" step="0.5" min="0" max="24"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title (optional)</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="e.g. Lesson 1-5"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description" rows="3" placeholder="What was covered today?"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                <textarea name="notes" id="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Record Task</button>
                        </form>
                    </div>
                </div>

                <!-- Log History -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recorded Tasks</h3>
                            <form method="GET" class="flex gap-2">
                                <select name="month" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ (int)$month == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                    @endfor
                                </select>
                                <select name="year" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                                    @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                                        <option value="{{ $y }}" {{ (int)$year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded text-sm">Go</button>
                            </form>
                        </div>
                        @if($logs->count())
                        <div class="space-y-3 max-h-[600px] overflow-y-auto">
                            @foreach($logs as $log)
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $log->log_date->format('M d, Y') }}</p>
                                        @if($log->title)<p class="text-sm text-gray-700 dark:text-gray-300">{{ $log->title }}</p>@endif
                                        @if($log->course)<p class="text-xs text-gray-500 dark:text-gray-400">{{ $log->course->course_code }} - {{ $log->course->course_name }}</p>@endif
                                        @if($log->description)<p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($log->description, 120) }}</p>@endif
                                        @if($log->hours_taught > 0)<span class="inline-block mt-1 text-xs text-gray-500">{{ $log->hours_taught }} hrs</span>@endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No tasks recorded for this month. Use the form to add an entry.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
