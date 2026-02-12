<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Register New Student') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('consultancy.students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Personal Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">First Name *</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Last Name *</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                            <select name="gender" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nationality</label>
                            <input type="text" name="nationality" value="{{ old('nationality') }}" placeholder="e.g. Nepali, Indian"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country (residence)</label>
                            <input type="text" name="country" value="{{ old('country') }}" placeholder="e.g. Nepal, India"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name (local / alternate)</label>
                            <input type="text" name="first_name_japanese" value="{{ old('first_name_japanese') }}" placeholder="First name in local script"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name (local) – Last</label>
                            <input type="text" name="last_name_japanese" value="{{ old('last_name_japanese') }}" placeholder="Last name in local script"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Photo</label>
                            <input type="file" name="photo" accept="image/*"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City *</label>
                            <input type="text" name="city" value="{{ old('city') }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address *</label>
                            <textarea name="address" rows="2" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Login Credentials -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Login Credentials</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">A user account will be automatically created for system login. Leave password blank to use default password: <strong>password</strong></p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password (Optional)</label>
                            <input type="password" name="password" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Leave blank for default: password">
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters. If blank, default password will be used.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Confirm password">
                        </div>
                    </div>
                </div>

                <!-- Educational Background -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Educational Background</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Highest Education</label>
                            <select name="highest_education" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select</option>
                                <option value="SLC" {{ old('highest_education') == 'SLC' ? 'selected' : '' }}>SLC/SEE</option>
                                <option value="+2" {{ old('highest_education') == '+2' ? 'selected' : '' }}>+2/Higher Secondary</option>
                                <option value="Bachelor" {{ old('highest_education') == 'Bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                <option value="Master" {{ old('highest_education') == 'Master' ? 'selected' : '' }}>Master's Degree</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Language / Test Scores -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Language / Test Scores</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Add scores relevant to target country (e.g. JLPT for Japan; IELTS/TOEFL/PTE for Canada, USA, Australia, UK).</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">JLPT Level</label>
                            <select name="jlpt_level" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Not Taken</option>
                                <option value="N5" {{ old('jlpt_level') == 'N5' ? 'selected' : '' }}>N5</option>
                                <option value="N4" {{ old('jlpt_level') == 'N4' ? 'selected' : '' }}>N4</option>
                                <option value="N3" {{ old('jlpt_level') == 'N3' ? 'selected' : '' }}>N3</option>
                                <option value="N2" {{ old('jlpt_level') == 'N2' ? 'selected' : '' }}>N2</option>
                                <option value="N1" {{ old('jlpt_level') == 'N1' ? 'selected' : '' }}>N1</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IELTS Score</label>
                            <input type="text" name="ielts_score" value="{{ old('ielts_score') }}" placeholder="e.g. 6.5"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IELTS Date</label>
                            <input type="date" name="ielts_date" value="{{ old('ielts_date') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">TOEFL Score</label>
                            <input type="text" name="toefl_score" value="{{ old('toefl_score') }}" placeholder="e.g. 90"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">TOEFL Date</label>
                            <input type="date" name="toefl_date" value="{{ old('toefl_date') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PTE Score</label>
                            <input type="text" name="pte_score" value="{{ old('pte_score') }}" placeholder="e.g. 65"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PTE Date</label>
                            <input type="date" name="pte_date" value="{{ old('pte_date') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Target & Assignment -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Target & Assignment</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Country</label>
                            <select name="target_country" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select</option>
                                @foreach(config('destinations.countries', []) as $c)
                                    <option value="{{ $c }}" {{ old('target_country') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Intake</label>
                            <input type="text" name="target_intake" value="{{ old('target_intake') }}" placeholder="e.g. April 2026, September 2026"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course Type</label>
                            <select name="target_course_type" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select</option>
                                <option value="Language School" {{ old('target_course_type') == 'Language School' ? 'selected' : '' }}>Language School</option>
                                <option value="University" {{ old('target_course_type') == 'University' ? 'selected' : '' }}>University</option>
                                <option value="Vocational" {{ old('target_course_type') == 'Vocational' ? 'selected' : '' }}>Vocational School</option>
                                <option value="Graduate School" {{ old('target_course_type') == 'Graduate School' ? 'selected' : '' }}>Graduate School</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target University</label>
                            <select name="target_university_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select University</option>
                                @foreach($universities as $university)
                                    <option value="{{ $university->id }}" {{ old('target_university_id') == $university->id ? 'selected' : '' }}>{{ $university->name }}@if($university->country) ({{ $university->country }})@endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assign Counselor</label>
                            <select name="counselor_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Counselor</option>
                                @foreach($counselors as $counselor)
                                    <option value="{{ $counselor->id }}" {{ old('counselor_id') == $counselor->id ? 'selected' : '' }}>{{ $counselor->user->name ?? 'N/A' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Source</label>
                            <select name="source" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select</option>
                                <option value="Walk-in" {{ old('source') == 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                                <option value="Referral" {{ old('source') == 'Referral' ? 'selected' : '' }}>Referral</option>
                                <option value="Social Media" {{ old('source') == 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                <option value="Website" {{ old('source') == 'Website' ? 'selected' : '' }}>Website</option>
                                <option value="Agent" {{ old('source') == 'Agent' ? 'selected' : '' }}>Agent</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('consultancy.students.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Register Student</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
