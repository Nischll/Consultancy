<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($profile) && $profile && $profile->name ? $profile->name . ' | ' : '' }}{{ config('app.name', 'Consultancy Management') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        
        /* Theme: Default */
        .theme-default { }
        
        /* Theme: Dark */
        .theme-dark body {
            background-color: #0f172a;
            color: #f1f5f9;
        }
        .theme-dark .header-bg {
            background-color: rgba(15, 23, 42, 0.95);
            border-color: #1e293b;
        }
        .theme-dark .text-primary {
            color: #f1f5f9;
        }
        .theme-dark .text-secondary {
            color: #cbd5e1;
        }
        .theme-dark .bg-section {
            background-color: #1e293b;
        }
        .theme-dark .bg-section-alt {
            background-color: #0f172a;
        }
        
        /* Theme: Modern */
        .theme-modern .header-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .theme-modern .text-primary {
            color: #667eea;
        }
        
        /* Theme: Classic */
        .theme-classic .header-bg {
            background-color: #ffffff;
            border-bottom: 3px solid #1e40af;
        }
        .theme-classic .text-primary {
            color: #1e40af;
        }
    </style>
</head>
<body class="font-sans antialiased theme-{{ $theme ?? 'default' }}" x-data="{ mobileMenuOpen: false, themeMenuOpen: false, currentTheme: '{{ $theme ?? 'default' }}' }">
    <!-- Top Navigation - No Sidebar -->
    <header class="sticky top-0 z-50 header-bg bg-white/95 backdrop-blur border-b border-slate-200 shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-20">
                <!-- Logo / Brand -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    @if(isset($profile) && $profile && $profile->logo)
                        <img src="{{ asset($profile->logo) }}" alt="{{ $profile->name ?? config('app.name') }}" class="h-10 w-10 lg:h-12 lg:w-12 rounded-lg object-cover">
                    @else
                        <div class="h-10 w-10 lg:h-12 lg:w-12 rounded-lg bg-indigo-600 flex items-center justify-center">
                            <svg class="h-6 w-6 lg:h-7 lg:w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    @endif
                    <span class="text-lg lg:text-xl font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                        {{ (isset($profile) && $profile && $profile->name) ? $profile->name : config('app.name') }}
                    </span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ url('/') }}#hero" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Home</a>
                    <a href="{{ url('/') }}#about" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">About</a>
                    <a href="{{ url('/') }}#services" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Services</a>
                    <a href="{{ url('/') }}#contact" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Contact</a>
                    <a href="{{ route('public.inquiry.form') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Submit Inquiry</a>
                    
                    <!-- Theme Switcher - Admin Only -->
                    @auth
                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                        <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                            <span class="text-sm font-medium">Theme</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 py-2 z-50">
                            <form method="POST" action="{{ route('theme.switch') }}" class="space-y-1">
                                @csrf
                                <button type="submit" name="theme" value="default" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                                    <span>Default</span>
                                    @if(($theme ?? 'default') === 'default')
                                        <svg class="w-4 h-4 ml-auto text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </button>
                                <button type="submit" name="theme" value="dark" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-slate-800"></span>
                                    <span>Dark</span>
                                    @if(($theme ?? 'default') === 'dark')
                                        <svg class="w-4 h-4 ml-auto text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </button>
                                <button type="submit" name="theme" value="modern" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-gradient-to-r from-purple-500 to-pink-500"></span>
                                    <span>Modern</span>
                                    @if(($theme ?? 'default') === 'modern')
                                        <svg class="w-4 h-4 ml-auto text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </button>
                                <button type="submit" name="theme" value="classic" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-blue-700"></span>
                                    <span>Classic</span>
                                    @if(($theme ?? 'default') === 'classic')
                                        <svg class="w-4 h-4 ml-auto text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        </div>
                        </div>
                        @endif
                    @endauth
                    
                    @auth
                        <a href="{{ route('consultancy.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-600 hover:text-red-600 font-medium transition-colors">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">Sign In</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="lg:hidden py-4 border-t border-slate-200 space-y-2">
                <a href="{{ url('/') }}#hero" class="block py-2 text-slate-600 hover:text-indigo-600 font-medium">Home</a>
                <a href="{{ url('/') }}#about" class="block py-2 text-slate-600 hover:text-indigo-600 font-medium">About</a>
                <a href="{{ url('/') }}#services" class="block py-2 text-slate-600 hover:text-indigo-600 font-medium">Services</a>
                <a href="{{ url('/') }}#contact" class="block py-2 text-slate-600 hover:text-indigo-600 font-medium">Contact</a>
                <a href="{{ route('public.inquiry.form') }}" class="block py-2 text-slate-600 hover:text-indigo-600 font-medium">Submit Inquiry</a>
                
                <!-- Mobile Theme Switcher - Admin Only -->
                @auth
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <div class="px-2 py-2 border-t border-slate-200 mt-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Theme</p>
                    <form method="POST" action="{{ route('theme.switch') }}" class="grid grid-cols-2 gap-2">
                        @csrf
                        <button type="submit" name="theme" value="default" class="px-3 py-2 text-sm rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors {{ ($theme ?? 'default') === 'default' ? 'bg-indigo-50 border-indigo-300' : '' }}">
                            Default
                        </button>
                        <button type="submit" name="theme" value="dark" class="px-3 py-2 text-sm rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors {{ ($theme ?? 'default') === 'dark' ? 'bg-indigo-50 border-indigo-300' : '' }}">
                            Dark
                        </button>
                        <button type="submit" name="theme" value="modern" class="px-3 py-2 text-sm rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors {{ ($theme ?? 'default') === 'modern' ? 'bg-indigo-50 border-indigo-300' : '' }}">
                            Modern
                        </button>
                            <button type="submit" name="theme" value="classic" class="px-3 py-2 text-sm rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors {{ ($theme ?? 'default') === 'classic' ? 'bg-indigo-50 border-indigo-300' : '' }}">
                                Classic
                            </button>
                    </form>
                    </div>
                    @endif
                @endauth
                
                @auth
                    <a href="{{ route('consultancy.dashboard') }}" class="block py-2 text-indigo-600 font-semibold">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block py-2 text-left text-red-600 font-medium w-full">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-indigo-600 font-semibold">Sign In</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="@if(($theme ?? 'default') === 'dark') bg-black text-slate-400 @elseif(($theme ?? 'default') === 'modern') bg-gradient-to-br from-purple-900 to-pink-900 text-slate-200 @elseif(($theme ?? 'default') === 'classic') bg-blue-900 text-slate-200 @else bg-slate-900 text-slate-300 @endif mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    @if(isset($profile) && $profile && $profile->logo)
                        <img src="{{ asset($profile->logo) }}" alt="" class="h-8 w-8 rounded-lg object-cover">
                    @endif
                    <span class="font-semibold text-white">{{ (isset($profile) && $profile && $profile->name) ? $profile->name : config('app.name') }}</span>
                </div>
                <div class="flex gap-6 text-sm">
                    <a href="{{ url('/') }}#about" class="hover:text-white transition-colors">About</a>
                    <a href="{{ url('/') }}#services" class="hover:text-white transition-colors">Services</a>
                    <a href="{{ url('/') }}#contact" class="hover:text-white transition-colors">Contact</a>
                    <a href="{{ route('public.inquiry.form') }}" class="hover:text-white transition-colors">Submit Inquiry</a>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t @if(($theme ?? 'default') === 'dark') border-slate-800 @elseif(($theme ?? 'default') === 'modern') border-purple-800 @elseif(($theme ?? 'default') === 'classic') border-blue-800 @else border-slate-700 @endif text-center text-sm @if(($theme ?? 'default') === 'dark') text-slate-500 @elseif(($theme ?? 'default') === 'modern') text-purple-300 @elseif(($theme ?? 'default') === 'classic') text-blue-300 @else text-slate-500 @endif">
                &copy; {{ date('Y') }} {{ (isset($profile) && $profile && $profile->name) ? $profile->name : config('app.name') }}. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
