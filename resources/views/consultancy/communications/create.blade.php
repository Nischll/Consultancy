<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Communication') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('consultancy.communications.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Student Selection -->
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student *</label>
                            <select name="student_id" id="student_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ $selectedStudent && $selectedStudent->id == $student->id ? 'selected' : '' }}>
                                        {{ $student->full_name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type and Direction -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type *</label>
                                <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">Select Type</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="sms">SMS</option>
                                    <option value="meeting">Meeting</option>
                                    <option value="note">Note</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="direction" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Direction *</label>
                                <select name="direction" id="direction" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">Select Direction</option>
                                    <option value="incoming">Incoming</option>
                                    <option value="outgoing">Outgoing</option>
                                </select>
                                @error('direction')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content *</label>
                            <textarea name="content" id="content" rows="5" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type-specific fields -->
                        <div id="emailFields" class="hidden">
                            <label for="email_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email To</label>
                            <input type="email" name="email_to" id="email_to" value="{{ old('email_to') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div id="phoneFields" class="hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="call_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Call Duration (minutes)</label>
                                    <input type="number" name="call_duration" id="call_duration" value="{{ old('call_duration') }}" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <div id="meetingFields" class="hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="meeting_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meeting Date</label>
                                    <input type="datetime-local" name="meeting_date" id="meeting_date" value="{{ old('meeting_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="meeting_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                                    <input type="text" name="meeting_location" id="meeting_location" value="{{ old('meeting_location') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Follow-up -->
                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="requires_follow_up" value="1" {{ old('requires_follow_up') ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Requires Follow-up</span>
                            </label>
                            <div id="followUpFields" class="hidden">
                                <label for="follow_up_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Follow-up Date</label>
                                <input type="datetime-local" name="follow_up_date" id="follow_up_date" value="{{ old('follow_up_date') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('consultancy.communications.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                Save Communication
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('type').addEventListener('change', function() {
            const type = this.value;
            document.getElementById('emailFields').classList.add('hidden');
            document.getElementById('phoneFields').classList.add('hidden');
            document.getElementById('meetingFields').classList.add('hidden');
            
            if (type === 'email') {
                document.getElementById('emailFields').classList.remove('hidden');
            } else if (['phone', 'whatsapp', 'sms'].includes(type)) {
                document.getElementById('phoneFields').classList.remove('hidden');
            } else if (type === 'meeting') {
                document.getElementById('meetingFields').classList.remove('hidden');
            }
        });

        document.querySelector('input[name="requires_follow_up"]').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('followUpFields').classList.remove('hidden');
            } else {
                document.getElementById('followUpFields').classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
