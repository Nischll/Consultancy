<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="font-sans antialiased" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Mobile sidebar backdrop -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"
                 style="display: none;">
            </div>

            <!-- Main content -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top bar (mobile menu + header) -->
                <header class="sticky top-0 z-30 flex min-h-16 shrink-0 items-center gap-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 sm:px-6 lg:px-8 py-4">
                    <button @click="sidebarOpen = true" type="button" class="lg:hidden -m-2.5 p-2.5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg shrink-0">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    @if (isset($header))
                        <div class="flex-1 min-w-0 overflow-hidden">
                            {{ $header }}
                        </div>
                    @endif
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-auto bg-gray-100 dark:bg-gray-900">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("form").forEach(function(form) {
                form.addEventListener("submit", function(e) {
                    const submitBtn = form.querySelector("button[type='submit']");
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="ml-2">Loading...</span>';
                    }
                });
            });
        });
        </script>
    </body>
</html>
