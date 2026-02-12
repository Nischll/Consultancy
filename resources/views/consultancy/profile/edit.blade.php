<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Consultancy Profile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('consultancy.profile.update', $profile) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Consultancy Name</label>
                            <input type="text" name="name" value="{{ old('name', $profile->name) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Short Description</label>
                            <textarea name="description" rows="2"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('description', $profile->description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">About Us</label>
                            <textarea name="about" rows="5"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('about', $profile->about) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Images</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logo</label>
                            @if($profile->logo)
                            <div class="mb-2">
                                <img src="{{ asset($profile->logo) }}" alt="Current Logo" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                            @endif
                            <input type="file" name="logo" accept="image/*"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Banner</label>
                            @if($profile->banner)
                            <div class="mb-2">
                                <img src="{{ asset($profile->banner) }}" alt="Current Banner" class="w-full h-48 object-cover rounded-lg">
                            </div>
                            @endif
                            <input type="file" name="banner" accept="image/*"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gallery Images (Add More)</label>
                            @if($profile->images && count($profile->images) > 0)
                            <div class="grid grid-cols-4 gap-2 mb-2">
                                @foreach($profile->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset($image) }}" alt="Gallery" class="w-full h-24 object-cover rounded-lg">
                                    <form method="POST" action="{{ route('consultancy.profile.remove-image', $profile) }}" class="absolute top-1 right-1">
                                        @csrf
                                        <input type="hidden" name="image_path" value="{{ $image }}">
                                        <button type="submit" class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">×</button>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <input type="file" name="images[]" accept="image/*" multiple
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                            <textarea name="address" rows="2"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('address', $profile->address) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Website</label>
                            <input type="url" name="website" value="{{ old('website', $profile->website) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Social Media Links</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Facebook</label>
                            <input type="url" name="social_links[facebook]" value="{{ old('social_links.facebook', $profile->social_links['facebook'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Twitter</label>
                            <input type="url" name="social_links[twitter]" value="{{ old('social_links.twitter', $profile->social_links['twitter'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">LinkedIn</label>
                            <input type="url" name="social_links[linkedin]" value="{{ old('social_links.linkedin', $profile->social_links['linkedin'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Instagram</label>
                            <input type="url" name="social_links[instagram]" value="{{ old('social_links.instagram', $profile->social_links['instagram'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Services</h3>
                    <textarea name="services" rows="5"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('services', $profile->services) }}</textarea>
                </div>

                <!-- Advertisement -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Advertisement</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Advertisement Image</label>
                            @if($profile->advertisement_image)
                            <div class="mb-2">
                                <img src="{{ asset($profile->advertisement_image) }}" alt="Current Ad" class="w-full max-w-md h-48 object-cover rounded-lg">
                            </div>
                            @endif
                            <input type="file" name="advertisement_image" accept="image/*"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Advertisement Text</label>
                            <textarea name="advertisement" rows="4"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('advertisement', $profile->advertisement) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $profile->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600">
                        <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active (Display on home page)</label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('consultancy.profile.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
