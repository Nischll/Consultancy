<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $university->name }}
            </h2>
            <a href="{{ route('admin.universities.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($university->banner_image)
            <div class="mb-6 rounded-lg overflow-hidden">
                <img src="{{ asset($university->banner_image) }}" alt="{{ $university->name }}" class="w-full h-64 object-cover">
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $university->name }}</h3>
                                @if($university->name_japanese)
                                <p class="text-lg text-gray-500">{{ $university->name_japanese }}</p>
                                @endif
                            </div>
                            @if($university->logo)
                            <img src="{{ asset($university->logo) }}" alt="" class="w-20 h-20 rounded-lg object-cover">
                            @endif
                        </div>
                        
                        @if($university->description)
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">About</h4>
                            <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $university->description }}</p>
                        </div>
                        @endif
                    </div>

                    @if($university->programs_offered)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Programs Offered</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach((is_array($university->programs_offered) ? $university->programs_offered : explode(',', $university->programs_offered)) as $program)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ trim($program) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Facts</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Type</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($university->type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Institution</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $university->institution_type ?? 'N/A' }}</span>
                            </div>
                            @if($university->established)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Established</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $university->established }}</span>
                            </div>
                            @endif
                            @if($university->tuition_fee)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tuition Fee</span>
                                <span class="font-medium text-gray-900 dark:text-white">¥{{ number_format($university->tuition_fee) }}/year</span>
                            </div>
                            @endif
                            @if($university->country)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Country</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $university->country }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-500">International Students</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $university->international_students_count }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Location</h4>
                        <div class="space-y-2 text-sm">
                            @if($university->address)
                            <p class="text-gray-600 dark:text-gray-400">{{ $university->address }}</p>
                            @endif
                            <p class="text-gray-600 dark:text-gray-400">{{ $university->city ?? '' }}{{ $university->city && $university->prefecture ? ', ' : '' }}{{ $university->prefecture ?? '' }}</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact</h4>
                        <div class="space-y-2 text-sm">
                            @if($university->website)
                            <a href="{{ $university->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 block">{{ $university->website }}</a>
                            @endif
                            @if($university->email)
                            <a href="mailto:{{ $university->email }}" class="text-gray-600 dark:text-gray-400 block">{{ $university->email }}</a>
                            @endif
                            @if($university->phone)
                            <p class="text-gray-600 dark:text-gray-400">{{ $university->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
