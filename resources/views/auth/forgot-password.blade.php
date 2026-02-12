<x-guest-layout :profile="$profile ?? null">
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-slate-900">Forgot Password</h2>
            <p class="mt-2 text-sm text-slate-600">Enter your email address and we'll send you a password reset link</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" class="text-slate-700 font-medium" />
                <x-text-input 
                    id="email" 
                    class="block mt-2 w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus
                    placeholder="Enter your email"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm hover:shadow-md"
                >
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="text-center pt-4 border-t border-slate-200">
            <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                ← Back to login
            </a>
        </div>
    </div>
</x-guest-layout>
