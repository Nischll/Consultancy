<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HRPortalController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'present_today' => EmployeeAttendance::whereDate('date', Carbon::today())
                ->where('status', 'present')
                ->distinct('employee_id')
                ->count('employee_id'),
            'absent_today' => Employee::where('status', 'active')->count() - 
                EmployeeAttendance::whereDate('date', Carbon::today())
                    ->where('status', 'present')
                    ->distinct('employee_id')
                    ->count('employee_id'),
            'monthly_attendance_rate' => $this->calculateMonthlyAttendanceRate($currentMonth, $currentYear),
        ];

        // Get recent attendance records
        $recentAttendances = EmployeeAttendance::with('employee')
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc')
            ->limit(10)
            ->get();

        // Get employees with low attendance this month
        $lowAttendanceEmployees = Employee::withCount([
            'attendances as present_count' => function($q) use ($currentMonth, $currentYear) {
                $q->whereMonth('date', $currentMonth)
                  ->whereYear('date', $currentYear)
                  ->where('status', 'present');
            }
        ])
        ->having('present_count', '<', 15)
        ->orderBy('present_count', 'asc')
        ->limit(5)
        ->get();

        return view('hr.dashboard', compact('stats', 'recentAttendances', 'lowAttendanceEmployees'));
    }

    public function employees()
    {
        $employees = Employee::with(['user', 'attendances' => function($q) {
            $q->whereMonth('date', Carbon::now()->month)
              ->whereYear('date', Carbon::now()->year);
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('hr.employees', compact('employees'));
    }

    public function attendance()
    {
        $month = request('month', Carbon::now()->month);
        $year = request('year', Carbon::now()->year);

        $employees = Employee::with(['attendances' => function($q) use ($month, $year) {
            $q->whereMonth('date', $month)
              ->whereYear('date', $year);
        }])
        ->where('status', 'active')
        ->get();

        $attendanceData = [];
        foreach ($employees as $employee) {
            $attendances = $employee->attendances;
            $attendanceData[] = [
                'employee' => $employee,
                'present' => $attendances->where('status', 'present')->count(),
                'late' => $attendances->where('status', 'late')->count(),
                'absent' => $attendances->where('status', 'absent')->count(),
                'on_leave' => $attendances->where('status', 'on_leave')->count(),
                'total_hours' => $attendances->where('status', 'present')->sum('hours_worked') ?? 0,
            ];
        }

        return view('hr.attendance', compact('attendanceData', 'month', 'year'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('hr.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('hr.profile')
            ->with('success', 'Profile updated successfully!');
    }

    private function calculateMonthlyAttendanceRate($month, $year)
    {
        $totalEmployees = Employee::where('status', 'active')->count();
        if ($totalEmployees == 0) return 0;

        $workingDays = Carbon::create($year, $month, 1)->daysInMonth;
        $expectedAttendance = $totalEmployees * $workingDays;
        
        $actualAttendance = EmployeeAttendance::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('status', 'present')
            ->count();

        return $expectedAttendance > 0 ? round(($actualAttendance / $expectedAttendance) * 100, 2) : 0;
    }
}
