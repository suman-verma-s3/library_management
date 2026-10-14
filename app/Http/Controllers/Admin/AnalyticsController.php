<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use App\Models\Issue;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // ─── Overview Stats ────────────────────────
        $stats = [
            'total_books'      => Book::count(),
            'total_copies'     => BookCopy::count(),
            'total_students'   => Student::count(),
            'active_issues'    => Issue::whereNull('returned_at')->count(),
            'overdue'          => Issue::whereNull('returned_at')
                                      ->where('due_date', '<', now())->count(),
            'available'        => BookCopy::where('status', 'available')->count(),
        ];

        // ─── Copy Status (for Doughnut) ────────────
        $copyStatus = [
            'available' => BookCopy::where('status', 'available')->count(),
            'issued'    => BookCopy::where('status', 'issued')->count(),
            'damaged'   => BookCopy::where('status', 'damaged')->count(),
            'lost'      => BookCopy::where('status', 'lost')->count(),
        ];

        // ─── Monthly Issues (last 6 months) ────────
        $monthlyIssues = Issue::select(
                DB::raw("DATE_FORMAT(issued_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('issued_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months      = [];
        $issueCounts = [];
        foreach ($monthlyIssues as $row) {
            $months[]      = date('M Y', strtotime($row->month . '-01'));
            $issueCounts[] = $row->total;
        }

        // ─── Monthly Students (last 6 months) ──────
        $monthlyStudents = Student::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $studentMonths = [];
        $studentCounts = [];
        foreach ($monthlyStudents as $row) {
            $studentMonths[] = date('M Y', strtotime($row->month . '-01'));
            $studentCounts[] = $row->total;
        }

        // ─── Category Breakdown ────────────────────
        $categoryData = Category::withCount('books')
            ->orderByDesc('books_count')
            ->take(8)
            ->get();

        $categoryNames  = $categoryData->pluck('name')->toArray();
        $categoryCounts = $categoryData->pluck('books_count')->toArray();

        // ─── Top 5 Most Issued Books ───────────────
        $topBooks = Book::withCount(['copies as total_issues' => function ($q) {
                $q->join('issues', 'issues.book_copy_id', '=', 'book_copies.id');
            }])
            ->orderByDesc('total_issues')
            ->take(5)
            ->get();

        // ─── Top 5 Active Students ─────────────────
        $topStudents = Student::withCount('issues')
            ->orderByDesc('issues_count')
            ->take(5)
            ->get();

        return view('admin.analytics.index', compact(
            'stats',
            'copyStatus',
            'months',
            'issueCounts',
            'studentMonths',
            'studentCounts',
            'categoryNames',
            'categoryCounts',
            'topBooks',
            'topStudents'
        ));
    }
}