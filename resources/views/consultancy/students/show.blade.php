<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $student->full_name }} - {{ $student->student_id }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('consultancy.students.edit', $student) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Edit</a>
                <a href="{{ route('consultancy.students.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
            </div>
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
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Gender</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst($student->gender ?? 'N/A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date of Birth</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->address }}, {{ $student->city }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nationality</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->nationality ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Country (residence)</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->country ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Applications -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Applications</h3>
                            <a href="{{ route('consultancy.applications.create', ['student_id' => $student->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">+ New Application</a>
                        </div>
                        @if($student->applications->count())
                            <div class="space-y-3">
                                @foreach($student->applications as $app)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $app->university->name ?? 'N/A' }}</p>
                                            <p class="text-sm text-gray-500">{{ $app->application_id }} - {{ $app->intake }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_', ' ', $app->status)) }}</span>
                                    </div>
                                    <a href="{{ route('consultancy.applications.show', $app) }}" class="text-sm text-blue-600 hover:text-blue-800 mt-2 inline-block">View Details →</a>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No applications yet</p>
                        @endif
                    </div>

                    <!-- Courses (Enrolled) -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Courses</h3>
                            <a href="{{ route('consultancy.courses.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all courses</a>
                        </div>

                        @if(isset($availableCoursesForEnrollment) && $availableCoursesForEnrollment->count() > 0)
                            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Assign course to student</h4>
                                <form action="{{ route('consultancy.students.enroll-course', $student) }}" method="POST" class="flex flex-wrap items-end gap-3">
                                    @csrf
                                    <div class="min-w-[200px]">
                                        <label for="course_id" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Course</label>
                                        <select name="course_id" id="course_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                                            <option value="">Select course</option>
                                            @foreach($availableCoursesForEnrollment as $c)
                                                <option value="{{ $c->id }}">{{ $c->course_code }} – {{ $c->course_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">Enroll</button>
                                </form>
                            </div>
                        @endif

                        @php
                            $pendingCourses = $student->courses->where('pivot.status', 'pending_verification');
                            $enrolledCourses = $student->courses->where('pivot.status', 'enrolled');
                        @endphp

                        @if($pendingCourses->count() > 0)
                            <div class="mb-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-700">
                                <h4 class="text-sm font-medium text-amber-800 dark:text-amber-200 mb-2">Pending verification (student requested from portal)</h4>
                                <p class="text-xs text-amber-700 dark:text-amber-300 mb-3">Approve only after payment is done.</p>
                                <div class="space-y-3">
                                    @foreach($pendingCourses as $course)
                                    <div class="flex flex-wrap justify-between items-start gap-3 p-3 bg-white dark:bg-gray-800 rounded border border-amber-200 dark:border-amber-700">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $course->course_code }}</p>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $course->course_name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Requested: {{ $course->pivot->enrolled_at ? \Carbon\Carbon::parse($course->pivot->enrolled_at)->format('M d, Y') : '—' }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            @if(isset($hasCompletedPayment) && $hasCompletedPayment)
                                                <form action="{{ route('consultancy.students.approve-course-enrollment', [$student, $course]) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg">Approve enrollment</button>
                                                </form>
                                            @else
                                                <span class="text-xs text-amber-700 dark:text-amber-300 px-2 py-1 bg-amber-100 dark:bg-amber-800/50 rounded">Complete a payment to enable Approve</span>
                                            @endif
                                            <form action="{{ route('consultancy.students.reject-course-enrollment', [$student, $course]) }}" method="POST" class="inline" onsubmit="return confirm('Reject this enrollment request?');">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded-lg dark:bg-red-900/30 dark:text-red-200">Reject</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($enrolledCourses->count() > 0)
                            <div class="space-y-3">
                                @foreach($enrolledCourses as $course)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex justify-between items-start gap-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $course->course_code }}</p>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $course->course_name }}</p>
                                            @if($course->level)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Level: {{ $course->level }}</p>
                                            @endif
                                            <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                <span>Enrolled: {{ $course->pivot->enrolled_at ? \Carbon\Carbon::parse($course->pivot->enrolled_at)->format('M d, Y') : '—' }}</span>
                                                @if($course->duration_hours)
                                                    <span>{{ $course->duration_hours }} hrs</span>
                                                @endif
                                                @if($course->fee !== null)
                                                    <span>{{ $course->currency }} {{ number_format($course->fee, 2) }}</span>
                                                @endif
                                            </div>
                                            @if($course->description)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ Str::limit($course->description, 100) }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('consultancy.courses.show', $course) }}" class="text-blue-600 hover:text-blue-800 text-sm whitespace-nowrap shrink-0">View course →</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        @if($pendingCourses->count() === 0 && $enrolledCourses->count() === 0)
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">Not enrolled in any courses yet</p>
                        @endif
                    </div>

                    <!-- Documents -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Documents</h3>
                            <a href="{{ route('consultancy.documents.create', ['student_id' => $student->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">+ Upload Document</a>
                        </div>
                        @if($student->documents->count())
                            <div class="space-y-3">
                                @foreach($student->documents as $doc)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex flex-wrap justify-between items-start gap-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $doc->title }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $doc->document_type }}</p>
                                            <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                <span>File: {{ $doc->file_name }}</span>
                                                @if($doc->file_size)
                                                <span>{{ number_format($doc->file_size) }} KB</span>
                                                @endif
                                                <span>Uploaded: {{ $doc->created_at->format('M d, Y H:i') }}</span>
                                                @if($doc->expiry_date)
                                                <span>Expires: {{ $doc->expiry_date->format('M d, Y') }}</span>
                                                @endif
                                            </div>
                                            @if($doc->notes)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $doc->notes }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($doc->status == 'verified') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($doc->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                                {{ ucfirst($doc->status) }}
                                            </span>
                                            <a href="{{ route('consultancy.documents.show', $doc) }}" class="text-blue-600 hover:text-blue-800 text-sm whitespace-nowrap">View</a>
                                            @if($doc->status == 'pending')
                                            <form method="POST" action="{{ route('consultancy.documents.verify', $doc) }}" class="inline" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" name="verify" value="1" class="text-green-600 hover:text-green-800 text-sm cursor-pointer bg-transparent border-0 p-0">Verify</button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                    @if($doc->status == 'rejected' && $doc->rejection_reason)
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-2">Reason: {{ $doc->rejection_reason }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No documents uploaded</p>
                        @endif
                    </div>

                    <!-- Payments -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Payments</h3>
                            <a href="{{ route('consultancy.payments.create', ['student_id' => $student->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">+ Record Payment</a>
                        </div>
                        @if($student->payments->count())
                            <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left text-xs text-gray-500 uppercase">
                                        <th class="pb-2">Type</th>
                                        <th class="pb-2">Amount</th>
                                        <th class="pb-2">Paid</th>
                                        <th class="pb-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($student->payments as $payment)
                                    <tr>
                                        <td class="py-2 text-sm text-gray-900 dark:text-white">{{ $payment->payment_type }}</td>
                                        <td class="py-2 text-sm text-gray-900 dark:text-white">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                                        <td class="py-2 text-sm text-gray-900 dark:text-white">{{ $payment->currency }} {{ number_format($payment->paid_amount, 2) }}</td>
                                        <td class="py-2">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($payment->status == 'completed') bg-green-100 text-green-800
                                                @elseif($payment->status == 'partial') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No payments recorded</p>
                        @endif
                    </div>

                    <!-- Communication Log -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Communication Log</h3>
                            <a href="{{ route('consultancy.communications.create', ['student_id' => $student->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">+ Log Communication</a>
                        </div>
                        @if($student->communications->count())
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($student->communications->take(10) as $comm)
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $comm->subject ?? ucfirst($comm->type) }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($comm->content, 100) }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $comm->created_at->format('M d, H:i') }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">By: {{ $comm->user->name ?? 'System' }}</p>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No communications logged</p>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Photo & Status -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                        @if($student->photo)
                            <img src="{{ asset($student->photo) }}" alt="{{ $student->full_name }}" class="w-32 h-32 rounded-full mx-auto object-cover mb-4">
                        @else
                            <div class="w-32 h-32 rounded-full mx-auto bg-gray-200 flex items-center justify-center mb-4">
                                <span class="text-4xl text-gray-500">{{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $student->full_name }}</h3>
                        <p class="text-gray-500">{{ $student->student_id }}</p>
                        <span class="mt-2 px-3 py-1 inline-flex text-sm rounded-full 
                            @if($student->status == 'visa_approved') bg-green-100 text-green-800
                            @elseif($student->status == 'visa_rejected') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $student->status)) }}
                        </span>
                    </div>

                    <!-- Quick Info -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Info</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Target Country</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->target_country ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Target Intake</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->target_intake ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Target University</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->targetUniversity->name ?? 'Not selected' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Language / Test Scores</p>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">
                                    @if($student->jlpt_level) JLPT {{ $student->jlpt_level }}@endif
                                    @if($student->ielts_score) @if($student->jlpt_level) · @endif IELTS {{ $student->ielts_score }}@endif
                                    @if($student->toefl_score) @if($student->jlpt_level || $student->ielts_score) · @endif TOEFL {{ $student->toefl_score }}@endif
                                    @if($student->pte_score) @if($student->jlpt_level || $student->ielts_score || $student->toefl_score) · @endif PTE {{ $student->pte_score }}@endif
                                    @if(!$student->jlpt_level && !$student->ielts_score && !$student->toefl_score && !$student->pte_score) — @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Counselor</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->counselor->user->name ?? 'Unassigned' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Registered</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tasks</h3>
                            <a href="{{ route('consultancy.tasks.create', ['student_id' => $student->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">+ Add</a>
                        </div>
                        @if($student->tasks->where('status', 'pending')->count())
                            <div class="space-y-2">
                                @foreach($student->tasks->where('status', 'pending')->take(5) as $task)
                                <div class="p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $task->title }}</p>
                                    <p class="text-xs text-gray-500">Due: {{ $task->due_date ? $task->due_date->format('M d') : 'No date' }}</p>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4 text-sm">No pending tasks</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
