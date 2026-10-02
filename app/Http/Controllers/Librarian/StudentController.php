<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        // Search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('student_id', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        return view('librarian.students.index', compact('students'));
    }

    public function create()
    {
        return view('librarian.students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|string|max:50|unique:students,student_id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:students,email',
            'phone'      => 'nullable|string|max:20',
            'course'     => 'nullable|string|max:100',
            'address'    => 'nullable|string|max:500',
            'status'     => 'required|in:active,inactive',
        ]);

        Student::create($data);

        return redirect()->route('librarian.students.index')
                         ->with('success', 'Student added successfully.');
    }

    public function edit(Student $student)
    {
        return view('librarian.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'student_id' => 'required|string|max:50|unique:students,student_id,' . $student->id,
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:students,email,' . $student->id,
            'phone'      => 'nullable|string|max:20',
            'course'     => 'nullable|string|max:100',
            'address'    => 'nullable|string|max:500',
            'status'     => 'required|in:active,inactive',
        ]);

        $student->update($data);

        return redirect()->route('librarian.students.index')
                         ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('librarian.students.index')
                         ->with('success', 'Student deleted successfully.');
    }
}