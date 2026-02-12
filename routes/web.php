<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Consultancy Controllers
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\VisaApplicationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentPortalController;
use App\Http\Controllers\TeacherPortalController;
use App\Http\Controllers\EditorPortalController;
use App\Http\Controllers\EmployeePortalController;
use App\Http\Controllers\HRPortalController;
use App\Http\Controllers\CounselorPortalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\ConsultancyProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicInquiryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Public Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public inquiry submission (no auth required)
Route::get('/inquiry', [PublicInquiryController::class, 'showForm'])->name('public.inquiry.form');
Route::post('/inquiry', [PublicInquiryController::class, 'submit'])->name('public.inquiry.submit');
Route::get('/inquiry/thank-you', [PublicInquiryController::class, 'thankYou'])->name('public.inquiry.thank-you');

// Admin/Editor Routes (Role: 1, 2)
Route::middleware(['auth', 'verified', 'role:1,2'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirect basic dashboard to consultancy dashboard
    Route::get('/dashboard', fn() => redirect()->route('consultancy.dashboard'))->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:1'])->group(function () {
    Route::resource('users', UserController::class);
});

// Admin University Management (separate prefix to avoid conflict with public routes)
Route::middleware(['auth', 'verified', 'role:1'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('universities', UniversityController::class);
});

// ==========================================
// CONSULTANCY MANAGEMENT SYSTEM ROUTES
// ==========================================

// Consultancy Admin Routes (Role: 1, 2)
Route::middleware(['auth', 'verified', 'role:1,2'])->prefix('consultancy')->name('consultancy.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Students Management
    Route::resource('students', StudentController::class);
    Route::post('students/{student}/courses', [StudentController::class, 'enrollCourse'])->name('students.enroll-course');
    Route::post('students/{student}/courses/{course}/approve', [StudentController::class, 'approveCourseEnrollment'])->name('students.approve-course-enrollment');
    Route::post('students/{student}/courses/{course}/reject', [StudentController::class, 'rejectCourseEnrollment'])->name('students.reject-course-enrollment');
    
    // Inquiries Management
    Route::resource('inquiries', InquiryController::class);
    Route::post('inquiries/{inquiry}/convert', [InquiryController::class, 'convertToStudent'])->name('inquiries.convert');
    
    // Documents Management
    Route::resource('documents', DocumentController::class)->except(['edit', 'update']);
    Route::post('documents/{document}/verify', [DocumentController::class, 'verify'])->name('documents.verify');
    Route::get('document-checklist', [DocumentController::class, 'checklist'])->name('documents.checklist');
    Route::post('document-checklist', [DocumentController::class, 'storeChecklist'])->name('documents.checklist.store');
    
    // Applications Management
    Route::resource('applications', ApplicationController::class);
    
    // Visa Applications Management
    Route::resource('visa', VisaApplicationController::class);
    
    // Payments Management
    Route::resource('payments', PaymentController::class);
    Route::post('payments/{payment}/record', [PaymentController::class, 'recordPayment'])->name('payments.record');
    
    // Tasks Management
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    
    // Communications
    Route::resource('communications', CommunicationController::class)->except(['edit', 'update']);
    Route::post('communications/{communication}/follow-up', [CommunicationController::class, 'completeFollowUp'])->name('communications.follow-up');
    
    // Counselors Management
    Route::resource('counselors', CounselorController::class);

    // Courses Management
    Route::resource('courses', CourseController::class);
    Route::post('courses/{course}/teachers', [CourseController::class, 'assignTeacher'])->name('courses.assign-teacher');
    Route::delete('courses/{course}/teachers/{employee}', [CourseController::class, 'unassignTeacher'])->name('courses.unassign-teacher');
    
    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/students', [ReportController::class, 'students'])->name('reports.students');
    Route::get('reports/applications', [ReportController::class, 'applications'])->name('reports.applications');
    Route::get('reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
    Route::get('reports/visa', [ReportController::class, 'visa'])->name('reports.visa');
    
    // Consultancy Profile
    Route::resource('profile', ConsultancyProfileController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::post('profile/{profile}/remove-image', [ConsultancyProfileController::class, 'removeImage'])->name('profile.remove-image');
    
    // Employees Management
    Route::resource('employees', EmployeeController::class);
    Route::post('employees/{employee}/check-in', [EmployeeController::class, 'checkIn'])->name('employees.check-in');
    Route::post('employees/{employee}/check-out', [EmployeeController::class, 'checkOut'])->name('employees.check-out');
    Route::get('employees/{employee}/attendance', [EmployeeController::class, 'attendance'])->name('employees.attendance');
    Route::put('employees/{employee}/attendance/{attendance}/checkout', [EmployeeController::class, 'updateAttendanceCheckout'])->name('employees.attendance.update-checkout');
});

// Student Portal Routes (Role: 4 - Student)
Route::middleware(['auth', 'verified'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/dashboard', [StudentPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentPortalController::class, 'profile'])->name('profile');
    Route::put('/profile', [StudentPortalController::class, 'updateProfile'])->name('profile.update');
    Route::get('/documents', [StudentPortalController::class, 'documents'])->name('documents');
    Route::post('/documents', [StudentPortalController::class, 'uploadDocument'])->name('documents.upload');
    Route::get('/applications', [StudentPortalController::class, 'applications'])->name('applications');
    Route::get('/payments', [StudentPortalController::class, 'payments'])->name('payments');
    Route::get('/tasks', [StudentPortalController::class, 'tasks'])->name('tasks');
    Route::patch('/tasks/{task}/status', [StudentPortalController::class, 'updateTaskStatus'])->name('tasks.updateStatus');
    Route::get('/courses', [StudentPortalController::class, 'courses'])->name('courses');
    Route::post('/courses/{course}/enroll', [StudentPortalController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course}/withdraw', [StudentPortalController::class, 'withdraw'])->name('courses.withdraw');
    Route::post('/courses/{course}/cancel-request', [StudentPortalController::class, 'cancelEnrollmentRequest'])->name('courses.cancel-request');
    Route::get('/messages', [StudentPortalController::class, 'messages'])->name('messages');
    Route::post('/messages', [StudentPortalController::class, 'sendMessage'])->name('messages.send');
});

// Editor Portal Routes (Role: 3 - Editor)
Route::middleware(['auth', 'verified', 'role:3'])->prefix('editor')->name('editor.')->group(function () {
    Route::get('/dashboard', [EditorPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/inquiries', [EditorPortalController::class, 'inquiries'])->name('inquiries');
    Route::get('/inquiries/{inquiry}', [EditorPortalController::class, 'showInquiry'])->name('inquiries.show');
    Route::get('/applications', [EditorPortalController::class, 'applications'])->name('applications');
    Route::get('/applications/{application}', [EditorPortalController::class, 'showApplication'])->name('applications.show');
    Route::get('/tasks', [EditorPortalController::class, 'tasks'])->name('tasks');
    Route::patch('/tasks/{task}/complete', [EditorPortalController::class, 'completeTask'])->name('tasks.complete');
    Route::get('/profile', [EditorPortalController::class, 'profile'])->name('profile');
    Route::put('/profile', [EditorPortalController::class, 'updateProfile'])->name('profile.update');
});

// Employee Portal Routes (Role: 5 - Employee)
Route::middleware(['auth', 'verified', 'role:5'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeePortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [EmployeePortalController::class, 'attendance'])->name('attendance');
    Route::post('/check-in', [EmployeePortalController::class, 'checkIn'])->name('check-in');
    Route::post('/check-out', [EmployeePortalController::class, 'checkOut'])->name('check-out');
    Route::get('/profile', [EmployeePortalController::class, 'profile'])->name('profile');
    Route::put('/profile', [EmployeePortalController::class, 'updateProfile'])->name('profile.update');
});

// Teacher Portal Routes (Role: 6 - Teacher)
Route::middleware(['auth', 'verified', 'role:6'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [TeacherPortalController::class, 'courses'])->name('courses');
    Route::get('/attendance', [TeacherPortalController::class, 'attendance'])->name('attendance');
    Route::post('/attendance', [TeacherPortalController::class, 'markAttendance'])->name('attendance.mark');
    Route::post('/check-in', [TeacherPortalController::class, 'checkIn'])->name('check-in');
    Route::post('/check-out', [TeacherPortalController::class, 'checkOut'])->name('check-out');
    Route::get('/daily-log', [TeacherPortalController::class, 'dailyLog'])->name('daily-log');
    Route::post('/daily-log', [TeacherPortalController::class, 'storeDailyLog'])->name('daily-log.store');
    Route::get('/payments', [TeacherPortalController::class, 'payments'])->name('payments');
    Route::get('/profile', [TeacherPortalController::class, 'profile'])->name('profile');
    Route::put('/profile', [TeacherPortalController::class, 'updateProfile'])->name('profile.update');
});

// HR Portal Routes (Role: 7 - HR)
Route::middleware(['auth', 'verified', 'role:7'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('/dashboard', [HRPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/employees', [HRPortalController::class, 'employees'])->name('employees');
    Route::get('/attendance', [HRPortalController::class, 'attendance'])->name('attendance');
    Route::get('/profile', [HRPortalController::class, 'profile'])->name('profile');
    Route::put('/profile', [HRPortalController::class, 'updateProfile'])->name('profile.update');
});

// Counselor Portal Routes (Role: 8 - Counselor)
Route::middleware(['auth', 'verified', 'role:8'])->prefix('counselor')->name('counselor.')->group(function () {
    Route::get('/dashboard', [CounselorPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [CounselorPortalController::class, 'students'])->name('students');
    Route::get('/students/{student}', [CounselorPortalController::class, 'showStudent'])->name('students.show');
    Route::get('/applications', [CounselorPortalController::class, 'applications'])->name('applications');
    Route::get('/applications/{application}', [CounselorPortalController::class, 'showApplication'])->name('applications.show');
    Route::patch('/applications/{application}/status', [CounselorPortalController::class, 'updateApplicationStatus'])->name('applications.update-status');
    Route::get('/tasks', [CounselorPortalController::class, 'tasks'])->name('tasks');
    Route::patch('/tasks/{task}/complete', [CounselorPortalController::class, 'completeTask'])->name('tasks.complete');
    Route::get('/messages', [CounselorPortalController::class, 'messages'])->name('messages');
    Route::post('/messages', [CounselorPortalController::class, 'sendMessage'])->name('messages.send');
    Route::get('/profile', [CounselorPortalController::class, 'profile'])->name('profile');
    Route::put('/profile', [CounselorPortalController::class, 'updateProfile'])->name('profile.update');
});

// Public University Routes
Route::get('/universities', [UniversityController::class, 'publicIndex'])->name('universities.public');
Route::get('/universities/{university}', [UniversityController::class, 'show'])->name('universities.show');

Route::get('/lang/{locale}', function ($locale) {
    session()->put('locale', $locale);
    app()->setLocale($locale);
    return redirect()->back();
})->name('lang.switch');

// Theme switching - Admin only
Route::middleware(['auth', 'verified', 'role:1,2'])->group(function () {
    Route::post('/theme/switch', [HomeController::class, 'switchTheme'])->name('theme.switch');
});



// Auth routes
require __DIR__ . '/auth.php';