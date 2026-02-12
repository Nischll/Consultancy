<x-consultancy-home-layout :profile="$profile ?? null" :theme="$theme ?? 'default'">
    <section class="py-16 lg:py-24 @if(($theme ?? 'default') === 'dark') bg-slate-800 text-slate-100 @elseif(($theme ?? 'default') === 'modern') bg-gradient-to-br from-indigo-50 to-purple-50 @elseif(($theme ?? 'default') === 'classic') bg-slate-50 @else bg-white @endif min-h-[60vh] flex items-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if (session('success'))
                <div class="mb-6 inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-4">Thank You!</h1>
                <p class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif text-lg mb-8">{{ session('success') }}</p>
            @else
                <h1 class="text-3xl font-bold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-4">Inquiry Submitted</h1>
                <p class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif text-lg mb-8">We have received your inquiry and will get back to you soon.</p>
            @endif
            <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                Back to Home
            </a>
        </div>
    </section>
</x-consultancy-home-layout>
