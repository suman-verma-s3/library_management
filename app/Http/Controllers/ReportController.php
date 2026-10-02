<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Issue;
use App\Models\Student;

class ReportController extends Controller
{
    /**
     * Currently issued books (not returned yet).
     */
    public function issued()
    {
        $issues = Issue::with(['student', 'bookCopy.book', 'issuedBy'])
                       ->whereNull('returned_at')
                       ->orderBy('due_date')
                       ->paginate(20);

        return view('reports.issued', compact('issues'));
    }

    /**
     * Overdue books.
     */
    public function overdue()
    {
        $issues = Issue::with(['student', 'bookCopy.book', 'issuedBy'])
                       ->whereNull('returned_at')
                       ->where('due_date', '<', now())
                       ->orderBy('due_date')
                       ->paginate(20);

        return view('reports.overdue', compact('issues'));
    }

    /**
     * Student list — pick a student to see their history.
     */
    public function students()
    {
        $students = Student::withCount([
                            'issues as total_issues',
                            'issues as active_issues' => function ($q) {
                                $q->whereNull('returned_at');
                            },
                        ])
                        ->orderBy('name')
                        ->paginate(20);

        return view('reports.students', compact('students'));
    }

    /**
     * One student's complete borrowing history.
     */
    public function studentHistory(Student $student)
    {
        $issues = Issue::with(['bookCopy.book', 'issuedBy', 'returnedBy'])
                       ->where('student_id', $student->id)
                       ->latest('issued_at')
                       ->get();

        return view('reports.student-history', compact('student', 'issues'));
    }

    /**
     * Inventory summary.
     */
    public function inventory()
    {
        $stats = [
            'total_books'      => Book::count(),
            'total_copies'     => BookCopy::count(),
            'available'        => BookCopy::where('status', 'available')->count(),
            'issued'           => BookCopy::where('status', 'issued')->count(),
            'damaged'          => BookCopy::where('status', 'damaged')->count(),
            'lost'             => BookCopy::where('status', 'lost')->count(),
            'total_students'   => Student::count(),
            'active_issues'    => Issue::whereNull('returned_at')->count(),
            'total_issues'     => Issue::count(),
            'overdue'          => Issue::whereNull('returned_at')
                                      ->where('due_date', '<', now())
                                      ->count(),
        ];

        // Books with their copy counts
        $books = Book::withCount([
                        'copies',
                        'copies as available_count' => fn($q) => $q->where('status', 'available'),
                        'copies as issued_count'    => fn($q) => $q->where('status', 'issued'),
                        'copies as damaged_count'   => fn($q) => $q->where('status', 'damaged'),
                        'copies as lost_count'      => fn($q) => $q->where('status', 'lost'),
                    ])
                    ->orderBy('title')
                    ->paginate(15);

        return view('reports.inventory', compact('stats', 'books'));
    }
}