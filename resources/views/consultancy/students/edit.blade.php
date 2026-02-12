<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Student') }} - {{ $student->student_id }}
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

            <form id="update-student-form" action="{{ route('consultancy.students.update', $student) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">First Name *</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Last Name *</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                            <select name="gender" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nationality</label>
                            <input type="text" name="nationality" value="{{ old('nationality', $student->nationality) }}" placeholder="e.g. Nepali, Indian"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country (residence)</label>
                            <input type="text" name="country" value="{{ old('country', $student->country) }}" placeholder="e.g. Nepal, India"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name (local / alternate)</label>
                            <input type="text" name="first_name_japanese" value="{{ old('first_name_japanese', $student->first_name_japanese) }}" placeholder="First name in local script"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name (local) – Last</label>
                            <input type="text" name="last_name_japanese" value="{{ old('last_name_japanese', $student->last_name_japanese) }}" placeholder="Last name in local script"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                            <select name="status" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                @foreach(['inquiry', 'registered', 'documents_pending', 'documents_submitted', 'applied', 'interview_scheduled', 'accepted', 'visa_processing', 'visa_approved', 'visa_rejected', 'departed', 'enrolled', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $student->status) == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Photo</label>
                            @if($student->photo)
                                <img src="{{ asset($student->photo) }}" alt="" class="h-20 w-20 rounded-full object-cover mb-2">
                            @endif
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
                            <input type="email" name="email" value="{{ old('email', $student->email) }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone *</label>
                            <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $student->whatsapp) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City *</label>
                            <input type="text" name="city" value="{{ old('city', $student->city) }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address *</label>
                            <textarea name="address" rows="2" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('address', $student->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Language / Test Scores -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Language / Test Scores</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">JLPT Level</label>
                            <select name="jlpt_level" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Not Taken</option>
                                @foreach(['N5','N4','N3','N2','N1'] as $l)
                                    <option value="{{ $l }}" {{ old('jlpt_level', $student->jlpt_level) == $l ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IELTS Score</label>
                            <input type="text" name="ielts_score" value="{{ old('ielts_score', $student->ielts_score) }}" placeholder="e.g. 6.5"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IELTS Date</label>
                            <input type="date" name="ielts_date" value="{{ old('ielts_date', $student->ielts_date?->format('Y-m-d')) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">TOEFL Score</label>
                            <input type="text" name="toefl_score" value="{{ old('toefl_score', $student->toefl_score) }}" placeholder="e.g. 90"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">TOEFL Date</label>
                            <input type="date" name="toefl_date" value="{{ old('toefl_date', $student->toefl_date?->format('Y-m-d')) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PTE Score</label>
                            <input type="text" name="pte_score" value="{{ old('pte_score', $student->pte_score) }}" placeholder="e.g. 65"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PTE Date</label>
                            <input type="date" name="pte_date" value="{{ old('pte_date', $student->pte_date?->format('Y-m-d')) }}"
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
                                    <option value="{{ $c }}" {{ old('target_country', $student->target_country) == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Intake</label>
                            <input type="text" name="target_intake" value="{{ old('target_intake', $student->target_intake) }}" placeholder="e.g. April 2026, September 2026"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target University</label>
                            <select name="target_university_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select University</option>
                                @foreach($universities as $university)
                                    <option value="{{ $university->id }}" {{ old('target_university_id', $student->target_university_id) == $university->id ? 'selected' : '' }}>{{ $university->name }}@if($university->country) ({{ $university->country }})@endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assign Counselor</label>
                            <select name="counselor_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Counselor</option>
                                @foreach($counselors as $counselor)
                                    <option value="{{ $counselor->id }}" {{ old('counselor_id', $student->counselor_id) == $counselor->id ? 'selected' : '' }}>{{ $counselor->user->name ?? 'N/A' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Login Credentials -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Login Credentials</h3>
                    @if($student->user_id)
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">User account exists. Leave password blank to keep current password.</p>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">No user account found. A new account will be created. Leave password blank to use default password: <strong>password</strong></p>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password (Optional)</label>
                            <input type="password" name="password" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Leave blank to keep/use default">
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters. Leave blank to keep current password or use default.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Confirm password">
                        </div>
                    </div>
                </div>
            </form>

                <div class="flex justify-between mt-6">
                    <form action="{{ route('consultancy.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this student?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">Delete Student</button>
                    </form>
                    <div class="space-x-4">
                        <a href="{{ route('consultancy.students.show', $student) }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">Cancel</a>
                        <button type="submit" form="update-student-form" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update Student</button>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
