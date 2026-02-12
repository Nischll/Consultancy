<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Consultancy Profile') }}
            </h2>
            @if($profile)
                <a href="{{ route('consultancy.profile.edit', $profile) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Edit Profile
                </a>
            @else
                <a href="{{ route('consultancy.profile.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Create Profile
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($profile)
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="p-6 space-y-6">
                        <!-- Banner -->
                        @if($profile->banner)
                        <div class="relative h-64 rounded-lg overflow-hidden">
                            <img src="{{ asset($profile->banner) }}" alt="Banner" class="w-full h-full object-cover">
                        </div>
                        @endif

                        <!-- Logo and Basic Info -->
                        <div class="flex items-start gap-6">
                            @if($profile->logo)
                            <div class="flex-shrink-0">
                                <img src="{{ asset($profile->logo) }}" alt="Logo" class="w-32 h-32 rounded-lg object-cover border-4 border-gray-200 dark:border-gray-700">
                            </div>
                            @endif
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $profile->name ?? 'Consultancy Name' }}</h1>
                                @if($profile->description)
                                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $profile->description }}</p>
                                @endif
                                <div class="mt-4 flex flex-wrap gap-4 text-sm">
                                    @if($profile->email)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $profile->email }}</span>
                                    </div>
                                    @endif
                                    @if($profile->phone)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $profile->phone }}</span>
                                    </div>
                                    @endif
                                    @if($profile->website)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                        <a href="{{ $profile->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">{{ $profile->website }}</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- About Section -->
                        @if($profile->about)
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">About Us</h2>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $profile->about }}</p>
                        </div>
                        @endif

                        <!-- Services -->
                        @if($profile->services)
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Services</h2>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $profile->services }}</p>
                        </div>
                        @endif

                        <!-- Images Gallery -->
                        @if($profile->images && count($profile->images) > 0)
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Gallery</h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($profile->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset($image) }}" alt="Gallery Image" class="w-full h-48 object-cover rounded-lg">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Advertisement -->
                        @if($profile->advertisement || $profile->advertisement_image)
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Advertisement</h2>
                            @if($profile->advertisement_image)
                            <div class="mb-4">
                                <img src="{{ asset($profile->advertisement_image) }}" alt="Advertisement" class="w-full max-w-2xl mx-auto rounded-lg">
                            </div>
                            @endif
                            @if($profile->advertisement)
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $profile->advertisement }}</p>
                            @endif
                        </div>
                        @endif

                        <!-- Social Links -->
                        @if($profile->social_links)
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Follow Us</h2>
                            <div class="flex gap-4">
                                @if(isset($profile->social_links['facebook']) && $profile->social_links['facebook'])
                                <a href="{{ $profile->social_links['facebook'] }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">...</svg>
                                </a>
                                @endif
                                @if(isset($profile->social_links['twitter']) && $profile->social_links['twitter'])
                                <a href="{{ $profile->social_links['twitter'] }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">...</svg>
                                </a>
                                @endif
                                @if(isset($profile->social_links['linkedin']) && $profile->social_links['linkedin'])
                                <a href="{{ $profile->social_links['linkedin'] }}" target="_blank" class="text-blue-700 hover:text-blue-900">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">...</svg>
                                </a>
                                @endif
                                @if(isset($profile->social_links['instagram']) && $profile->social_links['instagram'])
                                <a href="{{ $profile->social_links['instagram'] }}" target="_blank" class="text-pink-600 hover:text-pink-800">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">...</svg>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Status -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $profile->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                    {{ $profile->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">No consultancy profile found. Create one to get started.</p>
                    <a href="{{ route('consultancy.profile.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Create Profile
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
