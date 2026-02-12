<x-guest2-layout :profile="$profile ?? null">
    <div class="max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">

        <!-- Login only - users are created by administrator -->
        <div class="flex justify-center">
            <div class="bg-white/95 backdrop-blur-sm rounded-xl border border-slate-200/50 shadow-xl max-w-md w-full">
                <div class="p-6 sm:p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-slate-900">Welcome Back</h2>
                        <p class="mt-2 text-sm text-slate-600">Sign in to your account to continue</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <input class="cart_items" type="hidden" value="" name="cart_items" />

                        <!-- Email -->
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

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                    name="remember"
                                >
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-400">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a
                                    class="text-sm text-gray-600 hover:text-gray-900 underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('password.request') }}"
                                >
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit -->
                        <div class="pt-2">
                            <button 
                                type="submit" 
                                class="w-full flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm hover:shadow-md"
                            >
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </form>
                        <p class="mt-4 text-center text-sm text-slate-600">{{ __('Contact your administrator for a user account.') }}</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cart_items = localStorage.getItem("cart_items");
            document.querySelectorAll(".cart_items").forEach(el => {
                el.value = cart_items;
            });

            // Disable submit buttons on submit for both forms
            document.querySelectorAll("form").forEach(form => {
                form.addEventListener("submit", () => {
                    const btn = form.querySelector("button[type='submit'], [type='submit']");
                    if (btn) {
                        btn.disabled = true;
                        btn.classList.add('opacity-75', 'cursor-not-allowed');
                        // Keep button height stable
                        const current = btn.innerHTML;
                        btn.innerHTML = `<span>${current}</span>`;
                    }
                });
            });
        });
    </script>
</x-guest2-layout>
