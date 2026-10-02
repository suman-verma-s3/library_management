<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Issue;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'books'     => Book::count(),
            'copies'    => BookCopy::count(),
            'students'  => Student::count(),
            'issued'    => Issue::whereNull('returned_at')->count(),
            'overdue'   => Issue::whereNull('returned_at')
                                ->where('due_date', '<', now())->count(),
            'available' => BookCopy::where('status', 'available')->count(),
        ];

        $recentIssues = Issue::with(['student', 'bookCopy.book'])
                             ->latest()
                             ->take(5)
                             ->get();

        return view('admin.dashboard', compact('stats', 'recentIssues'));
    }
}