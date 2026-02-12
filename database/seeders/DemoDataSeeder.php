<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Counselor;
use App\Models\University;
use App\Models\ConsultancyProfile;
use App\Models\Inquiry;
use App\Models\Document;
use App\Models\Application;
use App\Models\VisaApplication;
use App\Models\Payment;
use App\Models\Task;
use App\Models\Communication;
use App\Models\EmployeeAttendance;
use App\Models\Course;
use App\Models\TeacherCourse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $this->createRoles();
        
        // Create Users with different roles
        $users = $this->createUsers();
        
        // Create Universities
        $universities = $this->createUniversities();
        
        // Create Consultancy Profile
        $this->createConsultancyProfile();
        
        // Create Employees FIRST (before counselors, as counselors need employees)
        $employees = $this->createEmployees($users['employees']);
        
        // Create Counselors SECOND (before students, as students need counselors)
        $counselors = $this->createCounselors($users['counselors'], $employees);
        
        // Create Students THIRD (after counselors are created)
        $students = $this->createStudents($users['students'], $counselors);
        
        // Create Inquiries
        $this->createInquiries($students, $counselors);
        
        // Create Documents
        $this->createDocuments($students, $users['admins']);
        
        // Create Applications
        $applications = $this->createApplications($students, $universities, $counselors);
        
        // Create Visa Applications
        $this->createVisaApplications($students, $applications, $counselors);
        
        // Create Payments
        $this->createPayments($students, $applications, $users['admins']);
        
        // Create Tasks
        $this->createTasks($students, $applications, $users['admins'], $counselors);
        
        // Create Communications
        $this->createCommunications($students, $counselors);
        
        // Create Employee Attendances
        $this->createEmployeeAttendances($employees);

        // Create Teachers (Employee records for Teacher role users)
        $teachers = isset($users['teachers']) ? $this->createTeachers($users['teachers']) : [];

        // Create Courses (only if courses table exists / migrations have run)
        $courses = [];
        if (Schema::hasTable('courses')) {
            $courses = $this->createCourses();
            if (!empty($teachers)) {
                $this->createTeacherCourses($teachers, $courses);
            }
        }

        // Create Teacher Attendances
        if (!empty($teachers)) {
            $this->createTeacherAttendances($teachers);
        }
    }

    private function createRoles()
    {
        $roles = [
            'Super Admin',
            'Admin',
            'Editor',
            'Student',
            'Employee',
            'Teacher',
            'HR',
            'Counselor'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['role' => $role]);
        }
    }

    private function createUsers()
    {
        $users = [
            'admins' => [],
            'students' => [],
            'employees' => [],
            'counselors' => [],
            'teachers' => []
        ];

        // Admin Users
        $admin1 = User::create([
            'name' => 'Admin User',
            'email' => 'admin@consultancy.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'email_verified_at' => now(),
        ]);
        $users['admins'][] = $admin1;

        $admin2 = User::create([
            'name' => 'John Manager',
            'email' => 'manager@consultancy.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);
        $users['admins'][] = $admin2;

        // Student Users
        $studentNames = [
            ['name' => 'Rajesh Kumar', 'email' => 'rajesh.kumar@student.com'],
            ['name' => 'Priya Sharma', 'email' => 'priya.sharma@student.com'],
            ['name' => 'Amit Patel', 'email' => 'amit.patel@student.com'],
            ['name' => 'Sneha Gupta', 'email' => 'sneha.gupta@student.com'],
            ['name' => 'Vikram Singh', 'email' => 'vikram.singh@student.com'],
            ['name' => 'Anjali Mehta', 'email' => 'anjali.mehta@student.com'],
            ['name' => 'Rahul Verma', 'email' => 'rahul.verma@student.com'],
            ['name' => 'Kavita Reddy', 'email' => 'kavita.reddy@student.com'],
        ];

        $studentRole = Role::where('role', 'Student')->first();
        foreach ($studentNames as $studentData) {
            $user = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password'),
                'role_id' => $studentRole->id,
                'email_verified_at' => now(),
            ]);
            $users['students'][] = $user;
        }

        // Employee Users
        $employeeNames = [
            ['name' => 'Sarah Johnson', 'email' => 'sarah.johnson@consultancy.com'],
            ['name' => 'Michael Chen', 'email' => 'michael.chen@consultancy.com'],
            ['name' => 'Emily Davis', 'email' => 'emily.davis@consultancy.com'],
        ];

        $employeeRole = Role::where('role', 'Employee')->first();
        foreach ($employeeNames as $empData) {
            $user = User::create([
                'name' => $empData['name'],
                'email' => $empData['email'],
                'password' => Hash::make('password'),
                'role_id' => $employeeRole->id,
                'email_verified_at' => now(),
            ]);
            $users['employees'][] = $user;
        }

        // Counselor Users
        $counselorNames = [
            ['name' => 'Dr. Lisa Anderson', 'email' => 'lisa.anderson@consultancy.com'],
            ['name' => 'Dr. James Wilson', 'email' => 'james.wilson@consultancy.com'],
        ];

        $counselorRole = Role::where('role', 'Counselor')->first();
        foreach ($counselorNames as $counselorData) {
            $user = User::create([
                'name' => $counselorData['name'],
                'email' => $counselorData['email'],
                'password' => Hash::make('password'),
                'role_id' => $counselorRole->id,
                'email_verified_at' => now(),
            ]);
            $users['counselors'][] = $user;
        }

        // Teacher Users
        $teacherNames = [
            ['name' => 'Dr. Suresh Adhikari', 'email' => 'suresh.adhikari@consultancy.com'],
            ['name' => 'Ms. Anu Pandey', 'email' => 'anu.pandey@consultancy.com'],
            ['name' => 'Mr. Bimal Thapa', 'email' => 'bimal.thapa@consultancy.com'],
        ];

        $teacherRole = Role::where('role', 'Teacher')->first();
        if ($teacherRole) {
            foreach ($teacherNames as $teacherData) {
                $user = User::create([
                    'name' => $teacherData['name'],
                    'email' => $teacherData['email'],
                    'password' => Hash::make('password'),
                    'role_id' => $teacherRole->id,
                    'email_verified_at' => now(),
                ]);
                $users['teachers'][] = $user;
            }
        }

        return $users;
    }

    private function createUniversities()
    {
        $universities = [];

        $universityData = [
            [
                'name' => 'Tokyo University',
                'name_japanese' => '東京大学',
                'established' => 1877,
                'type' => 'university',
                'city' => 'Tokyo',
                'prefecture' => 'Tokyo',
                'email' => 'info@tokyo-u.ac.jp',
                'phone' => '+81-3-5841-2111',
                'website' => 'https://www.u-tokyo.ac.jp',
                'description' => 'One of Japan\'s most prestigious universities, known for excellence in research and education.',
                'tuition_fee' => 535800,
                'currency' => 'JPY',
                'is_featured' => true,
            ],
            [
                'name' => 'Kyoto University',
                'name_japanese' => '京都大学',
                'established' => 1897,
                'type' => 'university',
                'city' => 'Kyoto',
                'prefecture' => 'Kyoto',
                'email' => 'info@kyoto-u.ac.jp',
                'phone' => '+81-75-753-7531',
                'website' => 'https://www.kyoto-u.ac.jp',
                'description' => 'A leading research university with a strong focus on innovation and academic freedom.',
                'tuition_fee' => 535800,
                'currency' => 'JPY',
                'is_featured' => true,
            ],
            [
                'name' => 'Osaka University',
                'name_japanese' => '大阪大学',
                'established' => 1931,
                'type' => 'university',
                'city' => 'Suita',
                'prefecture' => 'Osaka',
                'email' => 'info@osaka-u.ac.jp',
                'phone' => '+81-6-6877-5111',
                'website' => 'https://www.osaka-u.ac.jp',
                'description' => 'A comprehensive research university with strong programs in science and engineering.',
                'tuition_fee' => 535800,
                'currency' => 'JPY',
                'is_featured' => false,
            ],
            [
                'name' => 'Waseda University',
                'name_japanese' => '早稲田大学',
                'established' => 1882,
                'type' => 'university',
                'city' => 'Shinjuku',
                'prefecture' => 'Tokyo',
                'email' => 'info@waseda.jp',
                'phone' => '+81-3-3203-4141',
                'website' => 'https://www.waseda.jp',
                'description' => 'A private research university known for its strong programs in humanities and social sciences.',
                'tuition_fee' => 1200000,
                'currency' => 'JPY',
                'is_featured' => true,
            ],
            [
                'name' => 'Keio University',
                'name_japanese' => '慶應義塾大学',
                'established' => 1858,
                'type' => 'university',
                'city' => 'Minato',
                'prefecture' => 'Tokyo',
                'email' => 'info@keio.ac.jp',
                'phone' => '+81-3-5427-1515',
                'website' => 'https://www.keio.ac.jp',
                'description' => 'Japan\'s oldest private university, renowned for business and economics programs.',
                'tuition_fee' => 1300000,
                'currency' => 'JPY',
                'is_featured' => true,
            ],
        ];

        foreach ($universityData as $data) {
            $university = University::create($data);
            $universities[] = $university;
        }

        return $universities;
    }

    private function createConsultancyProfile()
    {
        ConsultancyProfile::create([
            'name' => 'Global Study Consultancy',
            'description' => 'Your trusted partner for studying abroad. We help students achieve their dreams in Canada, USA, Australia, UK, Japan and more.',
            'about' => 'Global Study Consultancy has been helping students from around the world pursue their education abroad for over 15 years. Our experienced counselors provide personalized guidance for university applications, visa processing, and language preparation.',
            'email' => 'info@globalstudy.com',
            'phone' => '+1-234-567-8900',
            'address' => '123 Education Street',
            'website' => 'https://www.globalstudy.com',
            'services' => "• University & College Application Assistance\n• Visa Processing Support\n• Language Test Preparation (IELTS, TOEFL, PTE, JLPT)\n• Scholarship Guidance\n• Pre-departure Orientation\n• Post-arrival Support",
            'social_links' => [
                'facebook' => 'https://facebook.com/globalstudy',
                'twitter' => 'https://twitter.com/globalstudy',
                'linkedin' => 'https://linkedin.com/company/globalstudy',
                'instagram' => 'https://instagram.com/globalstudy',
            ],
            'is_active' => true,
        ]);
    }

    private function createStudents($studentUsers, $counselors)
    {
        $students = [];
        $firstNames = ['Rajesh', 'Priya', 'Amit', 'Sneha', 'Vikram', 'Anjali', 'Rahul', 'Kavita'];
        $lastNames = ['Kumar', 'Sharma', 'Patel', 'Gupta', 'Singh', 'Mehta', 'Verma', 'Reddy'];
        $cities = ['Kathmandu', 'Pokhara', 'Lalitpur', 'Biratnagar', 'Bhaktapur', 'Dharan', 'Butwal', 'Hetauda'];
        // Valid statuses from students table enum
        $statuses = ['inquiry', 'registered', 'documents_pending', 'documents_submitted', 'applied', 'interview_scheduled', 'accepted', 'visa_processing', 'visa_approved', 'visa_rejected', 'departed', 'enrolled', 'completed', 'cancelled'];
        $intakes = ['Spring 2025', 'Fall 2025', 'Spring 2026', 'Fall 2026'];
        $courseTypes = ['Undergraduate', 'Graduate', 'Language School', 'Vocational'];

        foreach ($studentUsers as $index => $user) {
            $nameParts = explode(' ', $user->name);
            
            // Safely assign counselor - only if counselors exist
            $counselorId = null;
            if (!empty($counselors) && count($counselors) > 0) {
                $randomCounselor = $counselors[array_rand($counselors)];
                $counselorId = $randomCounselor->id ?? null;
            }
            
            $student = Student::create([
                'user_id' => $user->id,
                'counselor_id' => $counselorId,
                'first_name' => $nameParts[0] ?? 'Student',
                'last_name' => $nameParts[1] ?? 'Name',
                'email' => $user->email,
                'phone' => '+977-98' . rand(1000000, 9999999),
                'gender' => ['male', 'female', 'other'][rand(0, 2)],
                'date_of_birth' => Carbon::now()->subYears(rand(18, 25))->subMonths(rand(0, 11))->subDays(rand(0, 30)),
                'nationality' => 'Nepali',
                'address' => rand(100, 999) . ' Street, ' . $cities[$index % count($cities)],
                'city' => $cities[$index % count($cities)],
                'country' => 'Nepal',
                'status' => $statuses[array_rand($statuses)],
                'target_country' => (function () {
                    $countries = config('destinations.countries', ['Japan', 'Canada', 'USA', 'Australia', 'UK']);
                    return $countries[array_rand($countries)];
                })(),
                'target_intake' => $intakes[array_rand($intakes)],
                'target_course_type' => $courseTypes[array_rand($courseTypes)],
                'highest_education' => ['High School', 'Bachelor\'s Degree', 'Master\'s Degree'][rand(0, 2)],
                'gpa' => rand(280, 400) / 100,
                'jlpt_level' => ['N5', 'N4', 'N3', 'N2', 'N1'][rand(0, 4)],
                'estimated_budget' => rand(500000, 3000000),
                'source' => ['Website', 'Referral', 'Social Media', 'Advertisement'][rand(0, 3)],
            ]);
            $students[] = $student;
        }

        return $students;
    }

    private function createEmployees($employeeUsers)
    {
        $employees = [];
        $positions = ['HR Manager', 'Accountant', 'Administrative Assistant', 'IT Support', 'Marketing Specialist'];
        $departments = ['HR', 'Finance', 'Administration', 'IT', 'Marketing'];
        $employmentTypes = ['full_time', 'part_time', 'contract'];

        foreach ($employeeUsers as $index => $user) {
            $nameParts = explode(' ', $user->name);
            $employee = Employee::create([
                'user_id' => $user->id,
                'employee_id' => 'EMP-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'first_name' => $nameParts[0] ?? 'Employee',
                'last_name' => $nameParts[1] ?? 'Name',
                'email' => $user->email,
                'phone' => '+81-90-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                'date_of_birth' => Carbon::now()->subYears(rand(25, 45)),
                'gender' => ['male', 'female'][rand(0, 1)],
                'position' => $positions[$index % count($positions)],
                'department' => $departments[$index % count($departments)],
                'hire_date' => Carbon::now()->subMonths(rand(6, 60)),
                'employment_type' => $employmentTypes[rand(0, 2)],
                'salary' => rand(3000000, 8000000),
                'status' => 'active',
            ]);
            $employees[] = $employee;
        }

        return $employees;
    }

    private function createCounselors($counselorUsers, $employees)
    {
        $counselors = [];
        $specializations = ['Language School', 'University', 'Visa Processing', 'Scholarship'];

        foreach ($counselorUsers as $index => $user) {
            // Create employee record for counselor
            $nameParts = explode(' ', $user->name);
            $employee = Employee::create([
                'user_id' => $user->id,
                'employee_id' => 'COUN-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'first_name' => $nameParts[0] ?? 'Counselor',
                'last_name' => $nameParts[1] ?? 'Name',
                'email' => $user->email,
                'phone' => '+81-90-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                'position' => 'Counselor',
                'department' => 'Counseling',
                'hire_date' => Carbon::now()->subMonths(rand(12, 72)),
                'employment_type' => 'full_time',
                'status' => 'active',
            ]);

            $counselor = Counselor::create([
                'user_id' => $user->id,
                'employee_id' => $employee->employee_id,
                'specialization' => $specializations[$index % count($specializations)],
                'phone' => $employee->phone,
                'extension' => rand(100, 999),
                'is_active' => true,
                'max_students' => rand(30, 60),
            ]);
            $counselors[] = $counselor;
        }

        return $counselors;
    }

    private function createInquiries($students, $counselors)
    {
        // Valid types from inquiries table enum
        $inquiryTypes = ['general', 'admission', 'visa', 'language', 'scholarship', 'accommodation', 'other'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        // Valid statuses from inquiries table enum
        $statuses = ['new', 'in_progress', 'responded', 'follow_up', 'converted', 'closed'];
        $sources = ['website', 'phone', 'email', 'walk_in', 'referral'];

        for ($i = 0; $i < 15; $i++) {
            $counselorId = null;
            if (!empty($counselors) && count($counselors) > 0) {
                $randomCounselor = $counselors[array_rand($counselors)];
                $counselorId = $randomCounselor->id ?? null;
            }
            
            Inquiry::create([
                'student_id' => !empty($students) && count($students) > 0 ? $students[array_rand($students)]->id : null,
                'counselor_id' => $counselorId,
                'name' => 'Inquiry ' . ($i + 1),
                'email' => 'inquiry' . ($i + 1) . '@example.com',
                'phone' => '+977-98' . rand(1000000, 9999999),
                'subject' => ['Application Process', 'Visa Requirements', 'Scholarship Information', 'University Selection'][rand(0, 3)],
                'message' => 'I would like to know more about ' . ['studying in Japan', 'university applications', 'visa processing', 'scholarship opportunities'][rand(0, 3)] . '.',
                'type' => $inquiryTypes[array_rand($inquiryTypes)],
                'priority' => $priorities[array_rand($priorities)],
                'status' => $statuses[array_rand($statuses)],
                'source' => $sources[array_rand($sources)],
                'follow_up_date' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 30)) : null,
            ]);
        }
    }

    private function createDocuments($students, $admins)
    {
        $documentTypes = ['passport', 'transcript', 'diploma', 'recommendation_letter', 'language_certificate', 'financial_statement', 'medical_certificate'];
        $statuses = ['pending', 'verified', 'rejected', 'expired'];

        foreach ($students as $student) {
            for ($i = 0; $i < rand(3, 6); $i++) {
                Document::create([
                    'student_id' => $student->id,
                    'document_type' => $documentTypes[array_rand($documentTypes)],
                    'title' => ucfirst(str_replace('_', ' ', $documentTypes[array_rand($documentTypes)])) . ' Document',
                    'file_path' => 'documents/student_' . $student->id . '/doc_' . ($i + 1) . '.pdf',
                    'file_name' => 'document_' . ($i + 1) . '.pdf',
                    'file_type' => 'application/pdf',
                    'file_size' => rand(100000, 5000000),
                    'status' => $statuses[array_rand($statuses)],
                    'verified_by' => rand(0, 1) ? $admins[array_rand($admins)]->id : null,
                    'verified_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 30)) : null,
                    'expiry_date' => rand(0, 1) ? Carbon::now()->addMonths(rand(6, 24)) : null,
                ]);
            }
        }
    }

    private function createApplications($students, $universities, $counselors)
    {
        $applications = [];
        $intakes = ['Spring 2025', 'Fall 2025', 'Spring 2026'];
        $courseTypes = ['Undergraduate', 'Graduate', 'Research'];
        // Valid statuses from applications table enum
        $statuses = ['draft', 'documents_preparing', 'documents_ready', 'submitted', 'under_review', 'interview_scheduled', 'interview_completed', 'accepted', 'rejected', 'waitlisted', 'withdrawn', 'enrolled'];
        $courseNames = ['Computer Science', 'Business Administration', 'Engineering', 'International Relations', 'Japanese Language'];

        foreach ($students as $index => $student) {
            if (rand(0, 1)) { // 50% chance to have application
                $counselorId = null;
                if (!empty($counselors) && count($counselors) > 0) {
                    $randomCounselor = $counselors[array_rand($counselors)];
                    $counselorId = $randomCounselor->id ?? null;
                }
                
                $application = Application::create([
                    'student_id' => $student->id,
                    'university_id' => !empty($universities) && count($universities) > 0 ? $universities[array_rand($universities)]->id : null,
                    'counselor_id' => $counselorId,
                    'intake' => $intakes[array_rand($intakes)],
                    'course_name' => $courseNames[array_rand($courseNames)],
                    'course_type' => $courseTypes[array_rand($courseTypes)],
                    'course_duration' => rand(2, 4) . ' years',
                    'status' => $statuses[array_rand($statuses)],
                    'application_date' => Carbon::now()->subMonths(rand(1, 6)),
                    'submission_deadline' => Carbon::now()->addMonths(rand(1, 6)),
                    'submitted_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 60)) : null,
                    'application_fee' => rand(5000, 50000),
                    'tuition_fee' => rand(500000, 2000000),
                    'application_fee_paid' => rand(0, 1),
                ]);
                $applications[] = $application;
            }
        }

        return $applications;
    }

    private function createVisaApplications($students, $applications, $counselors)
    {
        $visaTypes = ['Student', 'Temporary Visitor', 'Work'];
        // Valid statuses from visa_applications table enum
        $statuses = ['documents_preparing', 'documents_ready', 'submitted', 'processing', 'interview_scheduled', 'interview_completed', 'approved', 'rejected', 'additional_documents_required'];
        $embassies = ['Tokyo', 'Osaka', 'Kathmandu', 'New Delhi'];

        foreach ($applications as $application) {
            if (rand(0, 1)) { // 50% chance
                $counselorId = null;
                if (!empty($counselors) && count($counselors) > 0) {
                    $randomCounselor = $counselors[array_rand($counselors)];
                    $counselorId = $randomCounselor->id ?? null;
                }
                
                VisaApplication::create([
                    'student_id' => $application->student_id,
                    'application_id' => $application->id,
                    'counselor_id' => $counselorId,
                    'visa_type' => 'Student',
                    'embassy_location' => $embassies[array_rand($embassies)],
                    'status' => $statuses[array_rand($statuses)],
                    'submission_date' => Carbon::now()->subMonths(rand(1, 3)),
                    'interview_date' => rand(0, 1) ? Carbon::now()->addDays(rand(7, 60)) : null,
                    'expected_result_date' => Carbon::now()->addDays(rand(30, 90)),
                    'planned_departure_date' => Carbon::now()->addMonths(rand(3, 9)),
                ]);
            }
        }
    }

    private function createPayments($students, $applications, $admins)
    {
        $paymentTypes = ['application_fee', 'tuition_fee', 'visa_fee', 'service_fee', 'deposit'];
        // Valid statuses from payments table enum
        $statuses = ['pending', 'partial', 'completed', 'refunded', 'cancelled'];
        $methods = ['bank_transfer', 'credit_card', 'cash', 'online_payment'];

        foreach ($applications as $application) {
            // Application fee payment
            Payment::create([
                'student_id' => $application->student_id,
                'application_id' => $application->id,
                'payment_type' => 'application_fee',
                'description' => 'Application Fee for ' . $application->course_name,
                'amount' => $application->application_fee,
                'currency' => 'JPY',
                'amount_jpy' => $application->application_fee,
                'payment_method' => $methods[array_rand($methods)],
                'status' => $application->application_fee_paid ? 'completed' : 'pending',
                'paid_amount' => $application->application_fee_paid ? $application->application_fee : 0,
                'due_amount' => $application->application_fee_paid ? 0 : $application->application_fee,
                'due_date' => Carbon::now()->addDays(rand(7, 30)),
                'paid_date' => $application->application_fee_paid ? Carbon::now()->subDays(rand(1, 30)) : null,
                'received_by' => $application->application_fee_paid ? $admins[array_rand($admins)]->id : null,
            ]);

            // Tuition fee payment (if accepted)
            if ($application->status === 'accepted' && rand(0, 1)) {
                Payment::create([
                    'student_id' => $application->student_id,
                    'application_id' => $application->id,
                    'payment_type' => 'tuition_fee',
                    'description' => 'Tuition Fee - First Semester',
                    'amount' => $application->tuition_fee / 2,
                    'currency' => 'JPY',
                    'amount_jpy' => $application->tuition_fee / 2,
                    'payment_method' => $methods[array_rand($methods)],
                    'status' => $statuses[array_rand($statuses)],
                    'paid_amount' => rand(0, 1) ? $application->tuition_fee / 2 : rand(100000, $application->tuition_fee / 2),
                    'due_amount' => rand(0, 1) ? 0 : ($application->tuition_fee / 2) - rand(100000, $application->tuition_fee / 2),
                    'due_date' => Carbon::now()->addMonths(rand(1, 3)),
                    'paid_date' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 60)) : null,
                    'received_by' => rand(0, 1) ? $admins[array_rand($admins)]->id : null,
                ]);
            }
        }
    }

    private function createTasks($students, $applications, $admins, $counselors)
    {
        // Valid types from tasks table enum
        $taskTypes = ['document_collection', 'document_verification', 'application_submission', 'interview_preparation', 'visa_submission', 'follow_up', 'payment_collection', 'counseling_session', 'general', 'other'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        // Valid statuses from tasks table enum
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled', 'overdue'];

        foreach ($students as $student) {
            for ($i = 0; $i < rand(2, 5); $i++) {
                Task::create([
                    'student_id' => $student->id,
                    'application_id' => rand(0, 1) && count($applications) > 0 ? $applications[array_rand($applications)]->id : null,
                    'title' => ['Collect Documents', 'Review Application', 'Schedule Interview', 'Prepare Visa Documents', 'Follow up with Student'][rand(0, 4)],
                    'description' => 'Task description for ' . $student->first_name . ' ' . $student->last_name,
                    'type' => $taskTypes[array_rand($taskTypes)],
                    'priority' => $priorities[array_rand($priorities)],
                    'status' => $statuses[array_rand($statuses)],
                    'assigned_to' => (!empty($counselors) && count($counselors) > 0) 
                        ? $counselors[array_rand($counselors)]->user_id 
                        : $admins[array_rand($admins)]->id,
                    'assigned_by' => $admins[array_rand($admins)]->id,
                    'due_date' => Carbon::now()->addDays(rand(1, 30)),
                    'completed_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 15)) : null,
                ]);
            }
        }
    }

    private function createCommunications($students, $counselors)
    {
        // Valid types from communications table enum
        $types = ['email', 'phone', 'whatsapp', 'sms', 'meeting', 'note'];
        // Valid directions from communications table enum
        $directions = ['incoming', 'outgoing'];
        $subjects = ['Application Update', 'Document Request', 'Interview Schedule', 'Payment Reminder', 'General Inquiry'];

        foreach ($students as $student) {
            for ($i = 0; $i < rand(3, 8); $i++) {
                $counselor = (!empty($counselors) && count($counselors) > 0) 
                    ? $counselors[array_rand($counselors)] 
                    : null;
                Communication::create([
                    'student_id' => $student->id,
                    'user_id' => $counselor ? $counselor->user_id : null,
                    'type' => $types[array_rand($types)],
                    'direction' => $directions[array_rand($directions)],
                    'subject' => $subjects[array_rand($subjects)],
                    'content' => 'Communication message regarding ' . $student->first_name . '\'s application. This is a sample communication for demonstration purposes.',
                    'email_to' => $types[array_rand($types)] === 'email' ? $student->email : null,
                    'phone_number' => $types[array_rand($types)] === 'phone' ? $student->phone : null,
                    'meeting_date' => $types[array_rand($types)] === 'meeting' ? Carbon::now()->addDays(rand(-30, 30)) : null,
                    'requires_follow_up' => rand(0, 1),
                    'follow_up_date' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 30)) : null,
                    'follow_up_completed' => rand(0, 1),
                ]);
            }
        }
    }

    private function createEmployeeAttendances($employees)
    {
        foreach ($employees as $employee) {
            // Create attendance records for the last 30 days
            for ($i = 0; $i < 20; $i++) {
                $date = Carbon::now()->subDays($i);
                
                // Skip weekends (optional - you can remove this)
                if ($date->isWeekend() && rand(0, 1)) {
                    continue;
                }

                $checkIn = Carbon::createFromTime(rand(8, 9), rand(0, 59), 0);
                $checkOut = Carbon::createFromTime(rand(17, 18), rand(0, 59), 0);

                $checkInDateTime = $date->copy()->setTime($checkIn->hour, $checkIn->minute, 0);
                $checkOutDateTime = $date->copy()->setTime($checkOut->hour, $checkOut->minute, 0);
                $hoursWorked = $checkOutDateTime->diffInHours($checkInDateTime) + ($checkOutDateTime->diffInMinutes($checkInDateTime) % 60) / 60;
                
                EmployeeAttendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date->format('Y-m-d'),
                    'check_in' => $checkInDateTime,
                    'check_out' => $checkOutDateTime,
                    'hours_worked' => round($hoursWorked, 2),
                    'status' => ['present', 'late', 'absent'][rand(0, 2)],
                    'notes' => rand(0, 1) ? ['Worked from home', 'Overtime', 'Half day'][rand(0, 2)] : null,
                ]);
            }
        }
    }

    private function createTeachers($teacherUsers)
    {
        $teachers = [];
        if (empty($teacherUsers)) {
            return $teachers;
        }

        $positions = ['Japanese Language Teacher', 'English Teacher', 'IELTS Instructor'];
        $departments = ['Language', 'Academics', 'Language'];

        foreach ($teacherUsers as $index => $user) {
            $nameParts = explode(' ', $user->name);
            $employee = Employee::create([
                'user_id' => $user->id,
                'employee_id' => 'TCH-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'first_name' => $nameParts[0] ?? 'Teacher',
                'last_name' => isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : 'Name',
                'email' => $user->email,
                'phone' => '+977-98' . rand(10000000, 99999999),
                'date_of_birth' => Carbon::now()->subYears(rand(28, 50)),
                'gender' => ['male', 'female'][rand(0, 1)],
                'address' => rand(1, 99) . ' Street, Kathmandu',
                'position' => $positions[$index % count($positions)],
                'department' => $departments[$index % count($departments)],
                'hire_date' => Carbon::now()->subMonths(rand(6, 48)),
                'employment_type' => ['full_time', 'part_time'][rand(0, 1)],
                'salary' => rand(40000, 120000),
                'status' => 'active',
            ]);
            $teachers[] = $employee;
        }

        return $teachers;
    }

    private function createCourses()
    {
        $courseData = [
            ['code' => 'JAP101', 'name' => 'Japanese Beginner Level', 'level' => 'Beginner', 'hours' => 120, 'fee' => 25000],
            ['code' => 'JAP201', 'name' => 'Japanese Intermediate', 'level' => 'Intermediate', 'hours' => 150, 'fee' => 30000],
            ['code' => 'JAP301', 'name' => 'Japanese Advanced', 'level' => 'Advanced', 'hours' => 180, 'fee' => 35000],
            ['code' => 'ENG101', 'name' => 'English Foundation', 'level' => 'Beginner', 'hours' => 100, 'fee' => 20000],
            ['code' => 'IELTS01', 'name' => 'IELTS Preparation', 'level' => 'Intermediate', 'hours' => 80, 'fee' => 40000],
            ['code' => 'JLPT-N5', 'name' => 'JLPT N5 Preparation', 'level' => 'Beginner', 'hours' => 90, 'fee' => 22000],
            ['code' => 'JLPT-N4', 'name' => 'JLPT N4 Preparation', 'level' => 'Intermediate', 'hours' => 100, 'fee' => 26000],
        ];

        $courses = [];
        foreach ($courseData as $i => $data) {
            $startDate = Carbon::now()->addDays(rand(-30, 60));
            $courses[] = Course::create([
                'course_code' => $data['code'],
                'course_name' => $data['name'],
                'description' => 'Comprehensive ' . $data['name'] . ' course for students planning to study abroad.',
                'level' => $data['level'],
                'duration_hours' => $data['hours'],
                'fee' => $data['fee'],
                'currency' => 'NPR',
                'max_students' => rand(20, 30),
                'current_students' => rand(5, 20),
                'status' => ['active', 'active', 'draft'][rand(0, 2)],
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addMonths(3),
            ]);
        }

        return $courses;
    }

    private function createTeacherCourses($teachers, $courses)
    {
        if (empty($teachers) || empty($courses)) {
            return;
        }

        $statuses = ['active', 'active', 'assigned'];
        foreach ($teachers as $teacher) {
            // Assign 2–4 courses to each teacher
            $numCourses = rand(2, min(4, count($courses)));
            $assigned = array_rand($courses, $numCourses);
            if (!is_array($assigned)) {
                $assigned = [$assigned];
            }
            foreach ($assigned as $courseIndex) {
                $course = $courses[$courseIndex];
                TeacherCourse::create([
                    'teacher_id' => $teacher->id,
                    'course_id' => $course->id,
                    'hourly_rate' => rand(500, 1500),
                    'hours_per_week' => rand(4, 12),
                    'status' => $statuses[array_rand($statuses)],
                    'assigned_date' => Carbon::now()->subDays(rand(1, 90)),
                ]);
            }
        }
    }

    private function createTeacherAttendances($teachers)
    {
        if (empty($teachers)) {
            return;
        }

        $statuses = ['present', 'present', 'present', 'late', 'absent', 'on_leave'];
        foreach ($teachers as $teacher) {
            for ($i = 0; $i < 22; $i++) {
                $date = Carbon::now()->subDays($i);
                if ($date->isWeekend() && rand(0, 1)) {
                    continue;
                }

                $status = $statuses[array_rand($statuses)];
                $checkIn = ($status === 'present' || $status === 'late')
                    ? Carbon::createFromTime(rand(8, 10), rand(0, 59), 0)
                    : null;
                $checkOut = ($status === 'present' || $status === 'late') && $checkIn
                    ? Carbon::createFromTime(rand(16, 18), rand(0, 59), 0)
                    : null;

                $hoursWorked = 0;
                if ($checkIn && $checkOut) {
                    $hoursWorked = $checkOut->diffInMinutes($checkIn) / 60;
                }

                $checkInDateTime = $checkIn ? $date->copy()->setTime($checkIn->hour, $checkIn->minute, 0) : null;
                $checkOutDateTime = $checkOut ? $date->copy()->setTime($checkOut->hour, $checkOut->minute, 0) : null;

                EmployeeAttendance::create([
                    'employee_id' => $teacher->id,
                    'date' => $date->format('Y-m-d'),
                    'check_in' => $checkInDateTime,
                    'check_out' => $checkOutDateTime,
                    'hours_worked' => round($hoursWorked, 2),
                    'status' => $status,
                    'notes' => $status === 'on_leave' ? 'Leave' : null,
                ]);
            }
        }
    }
}
