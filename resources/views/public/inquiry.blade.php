<x-consultancy-home-layout :profile="$profile ?? null" :theme="$theme ?? 'default'">
    <section class="py-16 lg:py-24 @if(($theme ?? 'default') === 'dark') bg-slate-800 text-slate-100 @elseif(($theme ?? 'default') === 'modern') bg-gradient-to-br from-indigo-50 to-purple-50 @elseif(($theme ?? 'default') === 'classic') bg-slate-50 @else bg-white @endif">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold @if(($theme ?? 'default') === 'dark') text-white @else text-slate-900 @endif mb-2">Send an Inquiry</h1>
            <p class="@if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-600 @endif mb-8">Fill out the form below and we’ll get back to you as soon as possible.</p>

            <div class="@if(($theme ?? 'default') === 'dark') bg-slate-700 border-slate-600 @elseif(($theme ?? 'default') === 'modern') bg-white border-purple-200 @elseif(($theme ?? 'default') === 'classic') bg-white border-blue-200 @else bg-slate-50 border-slate-200 @endif rounded-2xl border p-6 lg:p-8 shadow-sm">
                <form action="{{ route('public.inquiry.submit') }}" method="POST" class="space-y-5">
                    @csrf

                    @if ($errors->any())
                        <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="name" class="block text-sm font-medium @if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-700 @endif mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-lg border @if(($theme ?? 'default') === 'dark') border-slate-600 bg-slate-800 text-white @else border-slate-300 bg-white text-slate-900 @endif px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium @if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-700 @endif mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full rounded-lg border @if(($theme ?? 'default') === 'dark') border-slate-600 bg-slate-800 text-white @else border-slate-300 bg-white text-slate-900 @endif px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium @if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-700 @endif mb-1">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                            class="w-full rounded-lg border @if(($theme ?? 'default') === 'dark') border-slate-600 bg-slate-800 text-white @else border-slate-300 bg-white text-slate-900 @endif px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium @if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-700 @endif mb-1">Subject <span class="text-red-500">*</span></label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                            class="w-full rounded-lg border @if(($theme ?? 'default') === 'dark') border-slate-600 bg-slate-800 text-white @else border-slate-300 bg-white text-slate-900 @endif px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium @if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-700 @endif mb-1">Message <span class="text-red-500">*</span></label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full rounded-lg border @if(($theme ?? 'default') === 'dark') border-slate-600 bg-slate-800 text-white @else border-slate-300 bg-white text-slate-900 @endif px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('message') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium @if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-700 @endif mb-1">Type</label>
                            <select id="type" name="type" class="w-full rounded-lg border @if(($theme ?? 'default') === 'dark') border-slate-600 bg-slate-800 text-white @else border-slate-300 bg-white text-slate-900 @endif px-4 py-2">
                                <option value="general" {{ old('type', 'general') === 'general' ? 'selected' : '' }}>General</option>
                                <option value="admission" {{ old('type') === 'admission' ? 'selected' : '' }}>Admission</option>
                                <option value="visa" {{ old('type') === 'visa' ? 'selected' : '' }}>Visa</option>
                                <option value="language" {{ old('type') === 'language' ? 'selected' : '' }}>Language</option>
                                <option value="scholarship" {{ old('type') === 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                                <option value="accommodation" {{ old('type') === 'accommodation' ? 'selected' : '' }}>Accommodation</option>
                                <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="source" class="block text-sm font-medium @if(($theme ?? 'default') === 'dark') text-slate-300 @else text-slate-700 @endif mb-1">How did you find us?</label>
                            <select id="source" name="source" class="w-full rounded-lg border @if(($theme ?? 'default') === 'dark') border-slate-600 bg-slate-800 text-white @else border-slate-300 bg-white text-slate-900 @endif px-4 py-2">
                                <option value="Website" {{ old('source', 'Website') === 'Website' ? 'selected' : '' }}>Website</option>
                                <option value="Phone" {{ old('source') === 'Phone' ? 'selected' : '' }}>Phone</option>
                                <option value="Walk-in" {{ old('source') === 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                                <option value="Referral" {{ old('source') === 'Referral' ? 'selected' : '' }}>Referral</option>
                                <option value="Social Media" {{ old('source') === 'Social Media' ? 'selected' : '' }}>Social Media</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                            Submit Inquiry
                        </button>
                        <a href="{{ url('/') }}#contact" class="ml-4 inline-block text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-consultancy-home-layout>
