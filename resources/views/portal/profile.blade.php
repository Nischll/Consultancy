<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="first_name" :value="__('First Name')" />
                                    <x-text-input id="first_name" type="text" class="mt-1 block w-full" value="{{ $student->first_name }}" disabled />
                                </div>
                                <div>
                                    <x-input-label for="last_name" :value="__('Last Name')" />
                                    <x-text-input id="last_name" type="text" class="mt-1 block w-full" value="{{ $student->last_name }}" disabled />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" type="email" class="mt-1 block w-full" value="{{ $student->email }}" disabled />
                                </div>
                                <div>
                                    <x-input-label for="student_id" :value="__('Student ID')" />
                                    <x-text-input id="student_id" type="text" class="mt-1 block w-full" value="{{ $student->student_id }}" disabled />
                                </div>
                                <div>
                                    <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                    <x-text-input id="date_of_birth" type="date" class="mt-1 block w-full" value="{{ $student->date_of_birth?->format('Y-m-d') }}" disabled />
                                </div>
                                <div>
                                    <x-input-label for="nationality" :value="__('Nationality')" />
                                    <x-text-input id="nationality" type="text" class="mt-1 block w-full" value="{{ $student->nationality }}" disabled />
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="phone" :value="__('Phone')" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $student->phone) }}" required />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="alternate_phone" :value="__('Alternate Phone')" />
                                    <x-text-input id="alternate_phone" name="alternate_phone" type="text" class="mt-1 block w-full" value="{{ old('alternate_phone', $student->alternate_phone) }}" />
                                    <x-input-error :messages="$errors->get('alternate_phone')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="whatsapp" :value="__('WhatsApp')" />
                                    <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full" value="{{ old('whatsapp', $student->whatsapp) }}" />
                                    <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="city" :value="__('City')" />
                                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" value="{{ old('city', $student->city) }}" required />
                                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="address" :value="__('Address')" />
                                    <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>{{ old('address', $student->address) }}</textarea>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Emergency Contact</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="emergency_contact_name" :value="__('Name')" />
                                    <x-text-input id="emergency_contact_name" name="emergency_contact_name" type="text" class="mt-1 block w-full" value="{{ old('emergency_contact_name', $student->emergency_contact_name) }}" />
                                    <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="emergency_contact_relation" :value="__('Relation')" />
                                    <x-text-input id="emergency_contact_relation" name="emergency_contact_relation" type="text" class="mt-1 block w-full" value="{{ old('emergency_contact_relation', $student->emergency_contact_relation) }}" />
                                    <x-input-error :messages="$errors->get('emergency_contact_relation')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="emergency_contact_phone" :value="__('Phone')" />
                                    <x-text-input id="emergency_contact_phone" name="emergency_contact_phone" type="text" class="mt-1 block w-full" value="{{ old('emergency_contact_phone', $student->emergency_contact_phone) }}" />
                                    <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>{{ __('Update Profile') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
