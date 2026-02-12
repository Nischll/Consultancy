<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Visa Application') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('consultancy.visa.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Student *</label>
                            <select name="student_id" id="student_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                onchange="window.location=this.value ? '{{ route('consultancy.visa.create') }}?student_id='+this.value : '{{ route('consultancy.visa.create') }}';">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ (old('student_id') ?? $selectedStudent?->id ?? request('student_id')) == $student->id ? 'selected' : '' }}>
                                        {{ $student->full_name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select a student to load their accepted applications.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Application (Optional)</label>
                            <select name="application_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Application</option>
                                @foreach($applications as $app)
                                    <option value="{{ $app->id }}" {{ old('application_id', request('application_id')) == $app->id ? 'selected' : '' }}>
                                        {{ $app->application_id }} - {{ $app->university->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Visa Type *</label>
                                <select name="visa_type" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="Student" {{ old('visa_type', 'Student') == 'Student' ? 'selected' : '' }}>Student</option>
                                    <option value="Dependent" {{ old('visa_type') == 'Dependent' ? 'selected' : '' }}>Dependent</option>
                                    <option value="SSW" {{ old('visa_type') == 'SSW' ? 'selected' : '' }}>Specified Skilled Worker</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Embassy Location</label>
                                <input type="text" name="embassy_location" value="{{ old('embassy_location', 'Kathmandu') }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Counselor</label>
                                <select name="counselor_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">Select</option>
                                    @foreach($counselors as $counselor)
                                        <option value="{{ $counselor->id }}">{{ $counselor->user->name ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Planned Departure</label>
                                <input type="date" name="planned_departure_date" value="{{ old('planned_departure_date') }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                            <textarea name="notes" rows="3"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('consultancy.visa.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Create Visa Application</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
