<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Counselor') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('consultancy.counselors.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="space-y-4">
                        <!-- User Selection Toggle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Create New User or Select Existing?</label>
                            <div class="flex gap-4 mb-4">
                                <label class="flex items-center">
                                    <input type="radio" name="user_option" value="new" checked onchange="toggleUserFields()" class="mr-2">
                                    <span>Create New User</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="user_option" value="existing" onchange="toggleUserFields()" class="mr-2">
                                    <span>Select Existing User</span>
                                </label>
                            </div>
                        </div>

                        <!-- New User Fields -->
                        <div id="newUserFields">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" 
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                        placeholder="Full Name">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                        placeholder="email@example.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password (Optional)</label>
                                    <input type="password" name="password" 
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                        placeholder="Leave blank for default: password">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                                    <input type="password" name="password_confirmation" 
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                        placeholder="Confirm password">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mb-4">A user account will be automatically created for system login. Leave password blank to use default password: <strong>password</strong></p>
                        </div>

                        <!-- Existing User Selection -->
                        <div id="existingUserFields" style="display: none;">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select User *</label>
                                <select name="user_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Only admin/editor users without a counselor profile are shown</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee ID *</label>
                            <input type="text" name="employee_id" value="{{ old('employee_id') }}" required placeholder="EMP-001"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Specialization</label>
                            <select name="specialization" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">General</option>
                                <option value="Language School">Language School</option>
                                <option value="University">University</option>
                                <option value="Vocational">Vocational School</option>
                                <option value="Visa">Visa Processing</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Extension</label>
                                <input type="text" name="extension" value="{{ old('extension') }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Students</label>
                            <input type="number" name="max_students" value="{{ old('max_students', 50) }}" min="1"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('consultancy.counselors.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Add Counselor</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleUserFields() {
            const userOption = document.querySelector('input[name="user_option"]:checked').value;
            const newUserFields = document.getElementById('newUserFields');
            const existingUserFields = document.getElementById('existingUserFields');
            const userSelect = existingUserFields.querySelector('select[name="user_id"]');
            
            if (userOption === 'new') {
                newUserFields.style.display = 'block';
                existingUserFields.style.display = 'none';
                if (userSelect) userSelect.removeAttribute('required');
            } else {
                newUserFields.style.display = 'none';
                existingUserFields.style.display = 'block';
                if (userSelect) userSelect.setAttribute('required', 'required');
            }
        }
    </script>
</x-app-layout>
