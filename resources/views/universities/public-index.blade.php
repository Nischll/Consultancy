<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universities & Institutions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Universities & Institutions</h1>
            <p class="text-xl text-gray-600">Explore partner institutions worldwide</p>
        </div>

        @if(isset($countries) && count($countries) > 0)
        <div class="mb-6 flex flex-wrap justify-center gap-2">
            <a href="{{ route('universities.public') }}" class="px-4 py-2 rounded-lg {{ !request('country') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">All</a>
            @foreach($countries as $c)
                <a href="{{ route('universities.public', ['country' => $c]) }}" class="px-4 py-2 rounded-lg {{ request('country') == $c ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">{{ $c }}</a>
            @endforeach
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($universities as $university)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                @if($university->banner_image)
                <img src="{{ asset($university->banner_image) }}" alt="{{ $university->name }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                    <span class="text-white text-4xl font-bold">{{ substr($university->name, 0, 2) }}</span>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $university->name }}</h2>
                            @if($university->name_japanese)
                            <p class="text-sm text-gray-500">{{ $university->name_japanese }}</p>
                            @endif
                        </div>
                        @if($university->logo)
                        <img src="{{ asset($university->logo) }}" alt="" class="w-12 h-12 rounded-lg object-cover">
                        @endif
                    </div>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full mr-2">{{ ucfirst($university->type) }}</span>
                        @if($university->country)
                        <span class="mr-2">{{ $university->country }}</span>
                        @endif
                        @if($university->city || $university->prefecture)
                        <span>{{ $university->city }}{{ $university->city && $university->prefecture ? ', ' : '' }}{{ $university->prefecture }}</span>
                        @endif
                    </div>

                    @if($university->description)
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($university->description, 120) }}</p>
                    @endif

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">
                            <strong>{{ $university->international_students_count }}</strong> international students
                        </span>
                        <a href="{{ route('universities.show', $university) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            View Details →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No universities found.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8 text-center">
            <a href="/" class="text-gray-600 hover:text-gray-800">← Back to Home</a>
        </div>
    </div>
</body>
</html>
