<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Course;
use App\Models\TeacherCourse;
use App\Models\TeacherDailyLog;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TeacherPortalController extends Controller
{
    public function dashboard()
    {
        $teacher = $this->getAuthenticatedTeacher();
        
        if (!$teacher) {
            return redirect()->route('home')->with('error', 'No teacher profile found.');
        }

        $teacher->load([
            'courses' => function($q) {
                $q->wherePivot('status', 'active')->orWherePivot('status', 'assigned');
            },
            'attendances' => function($q) {
                $q->whereMonth('date', Carbon::now()->month)
                  ->whereYear('date', Carbon::now()->year);
            }
        ]);

        // Get statistics
        $stats = [
            'total_courses' => $teacher->courses()->count(),
            'active_courses' => $teacher->courses()->wherePivot('status', 'active')->count(),
            'monthly_attendance' => $teacher->attendances()
                ->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)
                ->where('status', 'present')
                ->count(),
            'total_hours_this_month' => $teacher->attendances()
                ->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)
                ->where('status', 'present')
                ->sum('hours_worked') ?? 0,
        ];

        // Get recent attendance
        $recentAttendance = $teacher->attendances()
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        // Get upcoming courses
        $upcomingCourses = $teacher->courses()
            ->where('start_date', '>=', Carbon::now())
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get();

        return view('teacher.dashboard', compact('teacher', 'stats', 'recentAttendance', 'upcomingCourses'));
    }

    public function courses()
    {
        $teacher = $this->getAuthenticatedTeacher();
        
        if (!$teacher) {
            return redirect()->route('home')->with('error', 'No teacher profile found.');
        }

        $courses = $teacher->courses()
            ->withPivot('hourly_rate', 'hours_per_week', 'status', 'assigned_date')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.courses', compact('teacher', 'courses'));
    }

    public function attendance()
    {
        $teacher = $this->getAuthenticatedTeacher();
        
        if (!$teacher) {
            return redirect()->route('home')->with('error', 'No teacher profile found.');
        }

        $month = request('month', Carbon::now()->month);
        $year = request('year', Carbon::now()->year);

        $attendances = $teacher->attendances()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'total_days' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'on_leave' => $attendances->where('status', 'on_leave')->count(),
            'total_hours' => $attendances->where('status', 'present')->sum('hours_worked') ?? 0,
        ];

        $todayAttendance = $teacher->attendances()->whereDate('date', Carbon::today())->first();

        return view('teacher.attendance', compact('teacher', 'attendances', 'stats', 'month', 'year', 'todayAttendance'));
    }

    public function checkIn(Request $request)
    {
        $teacher = $this->getAuthenticatedTeacher();
        if (!$teacher) {
            return redirect()->route('home')->with('error', 'No teacher profile found.');
        }
        $today = Carbon::today();
        $attendance = EmployeeAttendance::firstOrCreate(
            ['employee_id' => $teacher->id, 'date' => $today],
            ['status' => 'present']
        );
        if ($attendance->check_in) {
            return redirect()->route('teacher.attendance')->with('error', 'Already checked in today.');
        }
        $attendance->check_in = now();
        $attendance->check_in_location = $request->input('location', 'Office');
        $attendance->status = 'present';
        $attendance->save();
        return redirect()->route('teacher.attendance')->with('success', 'Checked in successfully!');
    }

    public function checkOut(Request $request)
    {
        $teacher = $this->getAuthenticatedTeacher();
        if (!$teacher) {
            return redirect()->route('home')->with('error', 'No teacher profile found.');
        }
        $today = Carbon::today();
        $attendance = $teacher->attendances()
            ->whereDate('date', $today)
            ->whereNotNull('check_in')
            ->first();
        if (!$attendance) {
            return redirect()->route('teacher.attendance')->with('error', 'Please check in first.');
        }
        if ($attendance->check_out) {
            return redirect()->route('teacher.attendance')->with('error', 'Already checked out today.');
        }
        $attendance->check_out = now();
        $attendance->check_out_location = $request->input('location', 'Office');
        $checkIn = Carbon::parse($attendance->check_in);
        $checkOut = Carbon::parse($attendance->check_out);
        $attendance->hours_worked = round($checkIn->diffInMinutes($checkOut) / 60, 2);
        $attendance->save();
        return redirect()->route('teacher.attendance')->with('success', 'Checked out successfully!');
    }

    public function markAttendance(Request $request)
    {
        $teacher = $this->getAuthenticatedTeacher();
        
        if (!$teacher) {
            return redirect()->route('home')->with('error', 'No teacher profile found.');
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,on_leave,half_day',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'hours_worked' => 'nullable|numeric|min:0|max:24',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if attendance already exists for this date
        $existing = EmployeeAttendance::where('employee_id', $teacher->id)
            ->where('date', $validated['date'])
            ->first();

        if ($existing) {
            $existing->update($validated);
            return redirect()->route('teacher.attendance')
                ->with('success', 'Attendance updated successfully!');
        }

        EmployeeAttendance::create([
            'employee_id' => $teacher->id,
            'date' => $validated['date'],
            'status' => $validated['status'],
            'check_in' => $validated['check_in'] ?? null,
            'check_out' => $validated['check_out'] ?? null,
            'hours_worked' => $validated['hours_worked'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('teacher.attendance')
            ->with('success', 'Attendance marked successfully!');
    }

    public function dailyLog(Request $request)
    {
        $teacher = $this->getAuthenticatedTeacher();
        
        if (!$teacher) {
            return redirect()->route('home')->with('error', 'No teacher profile found.');
        }

        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $logs = TeacherDailyLog::where('teacher_id', $teacher->id)
            ->whereMonth('log_date', $month)
            ->whereYear('log_date', $year)
            ->with('course')
            ->orderBy('log_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $courses = $teacher->courses()->wherePivotIn('status', ['active', 'assigned'])->get();

        return view('teacher.daily-log', compact('teacher', 'logs', 'courses', 'month', 'year'));
    }

    public function storeDailyLog(Request $request)
    {
        $teacher = $this->getAuthenticatedTeacher();
        
        if (!$teacher) {
            return redirect()->route('home')->with('error', 'No teacher profile found.');
        }

        $validated = $request->validate([
            'log_date' => 'required|date',
            'course_id' => 'nullable|exists:courses,id',
            'hours_taught' => 'nullable|numeric|min:0|max:24',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['teacher_id'] = $teacher->id;
        $validated['hours_taught'] = $validated['hours_taught'] ?? 0;

        TeacherDailyLog::create($validated);

        return redirect()->route('teacher.daily-log')
            ->with('success', 'Daily task recorded successfully!');
    }

    public function payments()
    {
        $teacher = $this->getAuthenticatedTeacher();
        
        if (!$teacher) {
            return redirect()->route('home')->with('error', 'No teacher profile found.');
        }

        // Calculate payments based on courses and attendance
        $month = request('month', Carbon::now()->month);
        $year = request('year', Carbon::now()->year);

        // Get courses with hourly rates
        $courses = $teacher->courses()
            ->wherePivot('status', 'active')
            ->get();

        // Get attendance for the month
        $attendances = $teacher->attendances()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('status', 'present')
            ->get();

        // Calculate earnings
        $totalEarnings = 0;
        $courseEarnings = [];

        foreach ($courses as $course) {
            $hourlyRate = $course->pivot->hourly_rate ?? 0;
            $hoursPerWeek = $course->pivot->hours_per_week ?? 0;
            
            // Calculate hours for the month (approximate)
            $weeksInMonth = 4.33; // Average weeks per month
            $monthlyHours = $hoursPerWeek * $weeksInMonth;
            
            $courseEarning = $hourlyRate * $monthlyHours;
            $totalEarnings += $courseEarning;

            $courseEarnings[] = [
                'course' => $course,
                'hourly_rate' => $hourlyRate,
                'hours_per_week' => $hoursPerWeek,
                'monthly_hours' => round($monthlyHours, 2),
                'earning' => round($courseEarning, 2),
            ];
        }

        // Get payment history (if you have a teacher_payments table, use that)
        // For now, we'll show calculated earnings

        return view('teacher.payments', compact(
            'teacher', 
            'courseEarnings', 
            'totalEarnings', 
            'month', 
            'year',
            'attendances'
        ));
    }

    public function profile()
    {
        $teacher = $this->getAuthenticatedTeacher();
        return view('teacher.profile', compact('teacher'));
    }

    public function updateProfile(Request $request)
    {
        $teacher = $this->getAuthenticatedTeacher();

        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $teacher->update($validated);

        return redirect()->route('teacher.profile')
            ->with('success', 'Profile updated successfully!');
    }

    private function getAuthenticatedTeacher()
    {
        $user = Auth::user();
        
        // Check if user is a teacher (role_id = 6)
        if ($user && $user->role_id == 6) {
            return Employee::where('user_id', $user->id)->first();
        }
        
        return null;
    }
}
