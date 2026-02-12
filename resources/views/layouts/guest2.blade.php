<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ (isset($profile) && $profile && $profile->name) ? $profile->name . ' | ' : '' }}{{ config('app.name', 'Consultancy Management') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-indigo-50/30 to-slate-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
        <!-- Logo/Brand Section -->
        <div class="mb-8 text-center">
            <a href="{{ url('/') }}" class="inline-flex flex-col items-center group">
                @if(isset($profile) && $profile && $profile->logo)
                    <img src="{{ asset($profile->logo) }}" alt="{{ $profile->name ?? config('app.name') }}" class="h-16 w-16 lg:h-20 lg:w-20 rounded-xl shadow-lg mb-3 group-hover:shadow-xl transition-shadow">
                @else
                    <div class="h-16 w-16 lg:h-20 lg:w-20 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg mb-3 group-hover:shadow-xl transition-shadow">
                        <svg class="h-10 w-10 lg:h-12 lg:w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                @endif
                <h1 class="text-2xl lg:text-3xl font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                    {{ (isset($profile) && $profile && $profile->name) ? $profile->name : config('app.name') }}
                </h1>
                @if(isset($profile) && $profile && $profile->description)
                <p class="mt-2 text-sm text-slate-600 max-w-md">{{ $profile->description }}</p>
                @endif
            </a>
        </div>

        <div class="w-full max-w-6xl">
            {{ $slot }}
        </div>

        <!-- Footer Link -->
        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="text-sm text-slate-600 hover:text-indigo-600 transition-colors">
                ← Back to home
            </a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cart_items = localStorage.getItem("cart_items");
            document.querySelectorAll(".cart_items").forEach(el => {
                el.value = cart_items;
            });

            document.querySelectorAll("form").forEach(function(form) {
                form.addEventListener("submit", function(e) {
                    const submitBtn = form.querySelector("button[type='submit']");
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<span class="ml-2">Loading...</span>';
                    }
                });
            });
        });
    </script>
</body>
</html>
