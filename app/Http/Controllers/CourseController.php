<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Employee;
use App\Models\TeacherCourse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::withCount('teachers');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('course_code', 'like', "%{$search}%")
                    ->orWhere('course_name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $courses = $query->orderBy('course_code')->paginate(20);
        return view('consultancy.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('consultancy.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'nullable|string|max:50',
            'duration_hours' => 'nullable|integer|min:0',
            'fee' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'max_students' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,active,completed,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'syllabus' => 'nullable|string',
            'materials' => 'nullable|string',
        ]);

        $course = Course::create($validated);
        return redirect()->route('consultancy.courses.show', $course)
            ->with('success', 'Course created successfully!');
    }

    public function show(Course $course)
    {
        $course->load(['teachers' => fn ($q) => $q->with('user')->withPivot('hourly_rate', 'hours_per_week', 'status', 'assigned_date', 'notes')]);
        $teachers = Employee::whereHas('user', fn ($q) => $q->where('role_id', 6))
            ->orderBy('first_name')
            ->get();
        return view('consultancy.courses.show', compact('course', 'teachers'));
    }

    public function edit(Course $course)
    {
        return view('consultancy.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:50|unique:courses,course_code,' . $course->id,
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'nullable|string|max:50',
            'duration_hours' => 'nullable|integer|min:0',
            'fee' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'max_students' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,active,completed,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'syllabus' => 'nullable|string',
            'materials' => 'nullable|string',
        ]);

        $course->update($validated);
        return redirect()->route('consultancy.courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('consultancy.courses.index')
            ->with('success', 'Course deleted successfully!');
    }

    public function assignTeacher(Request $request, Course $course)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:employees,id',
            'hourly_rate' => 'nullable|numeric|min:0',
            'hours_per_week' => 'nullable|integer|min:0',
            'status' => 'nullable|in:assigned,active,completed,cancelled',
            'assigned_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($course->teachers()->where('teacher_id', $validated['teacher_id'])->exists()) {
            return redirect()->back()->with('error', 'This teacher is already assigned to this course.');
        }

        $course->teachers()->attach($validated['teacher_id'], [
            'hourly_rate' => $validated['hourly_rate'] ?? null,
            'hours_per_week' => $validated['hours_per_week'] ?? 0,
            'status' => $validated['status'] ?? 'assigned',
            'assigned_date' => $validated['assigned_date'] ?? now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Teacher assigned to course successfully!');
    }

    public function unassignTeacher(Course $course, Employee $employee)
    {
        $course->teachers()->detach($employee->id);
        return redirect()->back()->with('success', 'Teacher removed from course.');
    }
}
