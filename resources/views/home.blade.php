<x-consultancy-home-layout :profile="$profile ?? null" :theme="$theme ?? 'default'">

    @if(isset($profile) && $profile && $profile->is_active)

    <!-- Hero -->
    <section id="hero" class="relative min-h-[70vh] flex items-center overflow-hidden">
        @if($profile->banner)
        <div class="absolute inset-0 z-0">
            <img src="{{ asset($profile->banner) }}" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-900/60"></div>
        </div>
        @else
            @if(($theme ?? 'default') === 'dark')
                <div class="absolute inset-0 z-0 bg-gradient-to-br from-slate-800 via-slate-900 to-black"></div>
            @elseif(($theme ?? 'default') === 'modern')
                <div class="absolute inset-0 z-0 bg-gradient-to-br from-purple-600 via-pink-600 to-indigo-700"></div>
            @elseif(($theme ?? 'default') === 'classic')
                <div class="absolute inset-0 z-0 bg-gradient-to-br from-blue-700 via-blue-800 to-slate-900"></div>
            @else
                <div class="absolute inset-0 z-0 bg-gradient-to-br from-indigo-600 via-indigo-700 to-slate-900"></div>
            @endif
        @endif
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 w-full">
            <div class="max-w-3xl">
                @if($profile->logo && !$profile->banner)
                <img src="{{ asset($profile->logo) }}" alt="{{ $profile->name }}" class="h-16 w-auto mb-6 rounded-lg">
                @endif
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight mb-6">
                    {{ $profile->name ?? config('app.name') }}
                </h1>
                @if($profile->description)
                <p class="text-xl text-slate-200 mb-8 max-w-2xl">
                    {{ $profile->description }}
                </p>
                @endif
                <div class="flex flex-wrap gap-4">
                    <a href="#contact" class="inline-flex items-center px-6 py-3 bg-white text-indigo-700 font-semibold rounded-lg hover:bg-slate-100 transition-colors shadow-lg">
                        Contact Us
                    </a>
                    @if($profile->website)
                    <a href="{{ $profile->website }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-indigo-500/90 text-white font-semibold rounded-lg hover:bg-indigo-500 transition-colors border border-white/30">
                        Visit Website
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section id="about" class="py-16 lg:py-24 @if(($theme ?? 'default') === 'dark') bg-slate-800 text-slate-100 @elseif(($theme ?? 'default') === 'modern') bg-gradient-to-br from-purple-50 to-pink-50 @elseif(($theme ?? 'default') === 'classic') bg-slate-50 @else bg-white @endif">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                @if($profile->logo && $profile->banner)
                <div class="order-2 lg:order-1">
                    <img src="{{ asset($profile->logo) }}" alt="{{ $profile->name }}" class="w-full max-w-md rounded-2xl shadow-xl object-cover">
                </div>
                @endif
                <div class="{{ ($profile->logo && $profile->banner) ? 'order-1 lg:order-2' : '' }}">
                    <h2 class="text-3xl font-bold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-6">About Us</h2>
                    @if($profile->about)
                    <div class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif text-lg leading-relaxed whitespace-pre-line">
                        {{ $profile->about }}
                    </div>
                    @else
                    <p class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif text-lg leading-relaxed">{{ $profile->description ?? 'We provide expert consultancy services to help you achieve your goals.' }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    @if($profile->services)
    <section id="services" class="py-16 lg:py-24 @if(($theme ?? 'default') === 'dark') bg-slate-900 text-slate-100 @elseif(($theme ?? 'default') === 'modern') bg-white @elseif(($theme ?? 'default') === 'classic') bg-blue-50 @else bg-slate-50 @endif">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-4 text-center">Our Services</h2>
            <p class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif text-lg text-center max-w-2xl mx-auto mb-12">What we offer to support your journey</p>
            <div class="@if(($theme ?? 'default') === 'dark') bg-slate-800 border-slate-700 @elseif(($theme ?? 'default') === 'modern') bg-gradient-to-br from-purple-50 to-pink-50 border-purple-200 @elseif(($theme ?? 'default') === 'classic') bg-white border-blue-200 @else bg-white border-slate-200 @endif rounded-2xl shadow-sm border p-8 lg:p-12">
                <div class="prose prose-lg max-w-none @if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-700 @endif whitespace-pre-line">
                    {{ $profile->services }}
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Gallery -->
    @if($profile->images && count($profile->images) > 0)
    <section class="py-16 lg:py-24 @if(($theme ?? 'default') === 'dark') bg-slate-800 @elseif(($theme ?? 'default') === 'modern') bg-gradient-to-br from-indigo-50 to-purple-50 @elseif(($theme ?? 'default') === 'classic') bg-slate-50 @else bg-white @endif">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-4 text-center">Gallery</h2>
            <p class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif text-lg text-center max-w-2xl mx-auto mb-12">Explore our work and milestones</p>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                @foreach($profile->images as $image)
                <div class="aspect-square rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                    <img src="{{ asset($image) }}" alt="Gallery" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Advertisement -->
    @if($profile->advertisement || $profile->advertisement_image)
    <section class="py-16 lg:py-24 @if(($theme ?? 'default') === 'dark') bg-slate-900 @elseif(($theme ?? 'default') === 'modern') bg-gradient-to-br from-pink-50 to-purple-50 @elseif(($theme ?? 'default') === 'classic') bg-gradient-to-br from-blue-50 to-indigo-50 @else bg-gradient-to-br from-indigo-50 to-slate-50 @endif">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl @if(($theme ?? 'default') === 'dark') bg-slate-800 border-slate-700 @else bg-white border-slate-200 @endif shadow-xl border overflow-hidden">
                @if($profile->advertisement_image)
                <div class="aspect-video md:aspect-[21/9] overflow-hidden">
                    <img src="{{ asset($profile->advertisement_image) }}" alt="Advertisement" class="w-full h-full object-cover">
                </div>
                @endif
                @if($profile->advertisement)
                <div class="p-8 lg:p-12 text-center">
                    <p class="text-xl @if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-700 @endif whitespace-pre-line max-w-3xl mx-auto">{{ $profile->advertisement }}</p>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- Contact -->
    <section id="contact" class="py-16 lg:py-24 @if(($theme ?? 'default') === 'dark') bg-slate-800 text-slate-100 @elseif(($theme ?? 'default') === 'modern') bg-gradient-to-br from-indigo-50 to-purple-50 @elseif(($theme ?? 'default') === 'classic') bg-white @else bg-white @endif">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-slate-900 mb-4 text-center">Contact Us</h2>
            <p class="text-slate-600 text-lg text-center max-w-2xl mx-auto mb-6">Get in touch — we’d love to hear from you</p>
            <p class="text-center mb-12">
                <a href="{{ route('public.inquiry.form') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                    Submit an Inquiry
                </a>
            </p>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-4xl mx-auto">
                @if($profile->email)
                <a href="mailto:{{ $profile->email }}" class="flex flex-col items-center p-6 rounded-xl @if(($theme ?? 'default') === 'dark') bg-slate-700 hover:bg-slate-600 @elseif(($theme ?? 'default') === 'modern') bg-white hover:bg-purple-50 @elseif(($theme ?? 'default') === 'classic') bg-blue-50 hover:bg-blue-100 @else bg-slate-50 hover:bg-indigo-50 @endif transition-colors group">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-3 group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="font-semibold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-1">Email</span>
                    <span class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif text-sm text-center break-all">{{ $profile->email }}</span>
                </a>
                @endif
                @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="flex flex-col items-center p-6 rounded-xl @if(($theme ?? 'default') === 'dark') bg-slate-700 hover:bg-slate-600 @elseif(($theme ?? 'default') === 'modern') bg-white hover:bg-purple-50 @elseif(($theme ?? 'default') === 'classic') bg-blue-50 hover:bg-blue-100 @else bg-slate-50 hover:bg-indigo-50 @endif transition-colors group">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-3 group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <span class="font-semibold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-1">Phone</span>
                    <span class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif text-sm">{{ $profile->phone }}</span>
                </a>
                @endif
                @if($profile->address)
                <div class="flex flex-col items-center p-6 rounded-xl @if(($theme ?? 'default') === 'dark') bg-slate-700 @elseif(($theme ?? 'default') === 'modern') bg-white @elseif(($theme ?? 'default') === 'classic') bg-blue-50 @else bg-slate-50 @endif">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="font-semibold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-1">Address</span>
                    <span class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif text-sm text-center">{{ $profile->address }}</span>
                </div>
                @endif
                @if($profile->website)
                <a href="{{ $profile->website }}" target="_blank" class="flex flex-col items-center p-6 rounded-xl @if(($theme ?? 'default') === 'dark') bg-slate-700 hover:bg-slate-600 @elseif(($theme ?? 'default') === 'modern') bg-white hover:bg-purple-50 @elseif(($theme ?? 'default') === 'classic') bg-blue-50 hover:bg-blue-100 @else bg-slate-50 hover:bg-indigo-50 @endif transition-colors group">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-3 group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </div>
                    <span class="font-semibold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-1">Website</span>
                    <span class="@if(($theme ?? 'default') === 'dark') text-indigo-400 @else text-indigo-600 @endif text-sm">Visit site</span>
                </a>
                @endif
            </div>
            @if($profile->social_links && (($profile->social_links['facebook'] ?? null) || ($profile->social_links['twitter'] ?? null) || ($profile->social_links['linkedin'] ?? null) || ($profile->social_links['instagram'] ?? null)))
            <div class="mt-12 text-center">
                <p class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif font-medium mb-4">Follow us</p>
                <div class="flex justify-center gap-4">
                    @if(isset($profile->social_links['facebook']) && $profile->social_links['facebook'])
                    <a href="{{ $profile->social_links['facebook'] }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-indigo-100 hover:text-indigo-600 transition-colors">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    @if(isset($profile->social_links['twitter']) && $profile->social_links['twitter'])
                    <a href="{{ $profile->social_links['twitter'] }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-indigo-100 hover:text-indigo-600 transition-colors">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    @endif
                    @if(isset($profile->social_links['linkedin']) && $profile->social_links['linkedin'])
                    <a href="{{ $profile->social_links['linkedin'] }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-indigo-100 hover:text-indigo-600 transition-colors">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    @endif
                    @if(isset($profile->social_links['instagram']) && $profile->social_links['instagram'])
                    <a href="{{ $profile->social_links['instagram'] }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-indigo-100 hover:text-indigo-600 transition-colors">
                        <span class="sr-only">Instagram</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </section>

    @else

    <!-- No profile: welcome + CTA -->
    <section id="hero" class="min-h-[70vh] flex items-center">
        @if(($theme ?? 'default') === 'dark')
            <div class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-900 to-black"></div>
        @elseif(($theme ?? 'default') === 'modern')
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-pink-600 to-indigo-700"></div>
        @elseif(($theme ?? 'default') === 'classic')
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-blue-800 to-slate-900"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-700 to-slate-900"></div>
        @endif
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight mb-6">
                {{ config('app.name') }}
            </h1>
            <p class="text-xl text-slate-200 mb-8 max-w-2xl mx-auto">
                Welcome. Set up your consultancy profile to showcase your services and reach more clients.
            </p>
            @auth
                <a href="{{ route('consultancy.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-700 font-semibold rounded-lg hover:bg-slate-100 transition-colors shadow-lg">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-700 font-semibold rounded-lg hover:bg-slate-100 transition-colors shadow-lg">
                    Sign In
                </a>
            @endauth
        </div>
    </section>
    <section id="about" class="py-16 lg:py-24 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-slate-900 mb-6">Need an account?</h2>
            <p class="text-slate-600 text-lg">User accounts are created by your administrator. Contact your administrator for access. Once you have an account, use Sign In above to access the system.</p>
        </div>
    </section>

    @endif

</x-consultancy-home-layout>
