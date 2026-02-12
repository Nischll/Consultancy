<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Courses') }}
            </h2>
            <a href="{{ route('portal.dashboard') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 text-sm">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded dark:bg-green-900/30 dark:border-green-700 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded dark:bg-red-900/30 dark:border-red-700 dark:text-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Pending approval (student requested; admin will verify after payment) -->
            @if(isset($pendingEnrollments) && $pendingEnrollments->count() > 0)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pending approval</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">These enrollment requests will be verified by admin. You will be enrolled after payment is confirmed.</p>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($pendingEnrollments as $course)
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 shadow-sm sm:rounded-lg p-6">
                            <div class="flex justify-between items-start gap-2">
                                <div>
                                    <p class="text-sm font-medium text-amber-700 dark:text-amber-300">Pending verification</p>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">{{ $course->course_code }}</p>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $course->course_name }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        Requested: {{ $course->pivot->enrolled_at ? \Carbon\Carbon::parse($course->pivot->enrolled_at)->format('M d, Y') : '—' }}
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('portal.courses.cancel-request', $course) }}" class="shrink-0" onsubmit="return confirm('Cancel this enrollment request?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 text-sm font-medium text-amber-800 bg-amber-200 hover:bg-amber-300 rounded-lg dark:bg-amber-800/50 dark:text-amber-200">
                                        Cancel request
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- My Enrolled Courses -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">My Enrolled Courses</h3>
                @if($myEnrollments->count() > 0)
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($myEnrollments as $course)
                            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-start gap-2">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $course->course_code }}</p>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $course->course_name }}</h4>
                                        @if($course->level)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $course->level }}</p>
                                        @endif
                                        @if($course->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ Str::limit($course->description, 80) }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                            Enrolled: {{ $course->pivot->enrolled_at ? \Carbon\Carbon::parse($course->pivot->enrolled_at)->format('M d, Y') : '—' }}
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('portal.courses.withdraw', $course) }}" class="shrink-0" onsubmit="return confirm('Are you sure you want to withdraw from this course?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded-lg dark:bg-red-900/30 dark:text-red-200 dark:hover:bg-red-900/50">
                                            Withdraw
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">You are not enrolled in any courses yet. Browse available courses below and click Enroll to join.</p>
                @endif
            </div>

            <!-- Available Courses -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Available Courses</h3>
                @if($availableCourses->count() > 0)
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($availableCourses as $course)
                            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $course->course_code }}</p>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $course->course_name }}</h4>
                                @if($course->level)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $course->level }}</p>
                                @endif
                                @if($course->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ Str::limit($course->description, 120) }}</p>
                                @endif
                                <div class="mt-3 flex flex-wrap gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    @if($course->duration_hours)
                                        <span>{{ $course->duration_hours }} hrs</span>
                                    @endif
                                    @if($course->fee !== null)
                                        <span>{{ $course->currency }} {{ number_format($course->fee, 2) }}</span>
                                    @endif
                                    <span>{{ $course->enrolledStudentsCount() }} / {{ $course->max_students }} enrolled</span>
                                </div>
                                @if($course->hasCapacity())
                                    <form method="POST" action="{{ route('portal.courses.enroll', $course) }}" class="mt-4">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">
                                            Enroll
                                        </button>
                                    </form>
                                @else
                                    <p class="mt-4 text-sm text-amber-600 dark:text-amber-400 font-medium">Full — no spots available</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No other courses available for enrollment at the moment. Check back later or contact your counselor.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
