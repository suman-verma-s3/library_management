<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students'        => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'issued'          => Issue::whereNull('returned_at')->count(),
            'overdue'         => Issue::whereNull('returned_at')
                                      ->where('due_date', '<', now())
                                      ->count(),
        ];

        $recentIssues = Issue::with(['student', 'bookCopy.book'])
                             ->latest()
                             ->take(5)
                             ->get();

        return view('librarian.dashboard', compact('stats', 'recentIssues'));
    }
}