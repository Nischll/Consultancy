<x-guest-layout :profile="$profile ?? null">
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-slate-900">Welcome Back</h2>
            <p class="mt-2 text-sm text-slate-600">Sign in to your account to continue</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
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
                    autocomplete="username"
                    placeholder="Enter your email"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-medium" />
                <x-text-input 
                    id="password" 
                    class="block mt-2 w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="Enter your password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                        name="remember"
                    >
                    <span class="ml-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a 
                        class="text-sm text-indigo-600 hover:text-indigo-700 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md" 
                        href="{{ route('password.request') }}"
                    >
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm hover:shadow-md"
                >
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <div class="text-center pt-4 border-t border-slate-200">
            <p class="text-sm text-slate-600">{{ __('Contact your administrator for a user account.') }}</p>
        </div>
    </div>
</x-guest-layout>
