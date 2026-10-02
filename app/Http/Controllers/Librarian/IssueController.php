<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Issue;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{
    /**
     * List all issues with filters.
     */
    public function index(Request $request)
    {
        $query = Issue::with(['student', 'bookCopy.book', 'issuedBy']);

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'issued') {
                $query->whereNull('returned_at');
            } elseif ($request->status === 'returned') {
                $query->whereNotNull('returned_at');
            } elseif ($request->status === 'overdue') {
                $query->whereNull('returned_at')->where('due_date', '<', now());
            }
        }

        // Search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->whereHas('student', function ($q2) use ($s) {
                    $q2->where('name', 'like', "%{$s}%")
                       ->orWhere('student_id', 'like', "%{$s}%");
                })->orWhereHas('bookCopy', function ($q2) use ($s) {
                    $q2->where('accession_number', 'like', "%{$s}%");
                });
            });
        }

        $issues = $query->latest()->paginate(15)->withQueryString();

        return view('librarian.issues.index', compact('issues'));
    }

    /**
     * Show issue book form.
     */
    public function create()
    {
        $students = Student::where('status', 'active')->orderBy('name')->get();
        $books    = Book::orderBy('title')->get();

        return view('librarian.issues.create', compact('students', 'books'));
    }

    /**
     * Store a new issue (transaction-safe).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'   => 'required|exists:students,id',
            'book_copy_id' => 'required|exists:book_copies,id',
        ]);

        try {
            DB::transaction(function () use ($data) {
                // Lock the row so no two requests can issue it at the same time
                $copy = BookCopy::where('id', $data['book_copy_id'])
                                ->lockForUpdate()
                                ->first();

                if (!$copy) {
                    throw new \Exception('Book copy not found.');
                }

                if ($copy->status !== 'available') {
                    throw new \Exception("This copy is currently '{$copy->status}'. Only available copies can be issued.");
                }

                // Check if this student already has an active issue of this same book
                $alreadyIssued = Issue::where('student_id', $data['student_id'])
                                      ->whereHas('bookCopy', function ($q) use ($copy) {
                                          $q->where('book_id', $copy->book_id);
                                      })
                                      ->whereNull('returned_at')
                                      ->exists();

                if ($alreadyIssued) {
                    throw new \Exception('This student already has an active issue of this book.');
                }

                // Create the issue record
                Issue::create([
                    'student_id'   => $data['student_id'],
                    'book_copy_id' => $copy->id,
                    'issued_by'    => Auth::id(),
                    'issued_at'    => now(),
                    'due_date'     => now()->addDays(14),
                ]);

                // Mark the copy as issued
                $copy->update(['status' => 'issued']);
            });

            return redirect()->route('librarian.issues.index')
                             ->with('success', 'Book issued successfully.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * AJAX: get available copies for a specific book.
     */
    public function availableCopies(Book $book)
    {
        $copies = $book->copies()
                       ->where('status', 'available')
                       ->get(['id', 'accession_number']);

        return response()->json($copies);
    }

    /**
 * Show return confirmation page.
 */
public function showReturn(Issue $issue)
{
    if ($issue->isReturned()) {
        return redirect()->route('librarian.issues.index')
                         ->with('error', 'This book has already been returned.');
    }

    $issue->load(['student', 'bookCopy.book', 'issuedBy']);

    return view('librarian.issues.return', compact('issue'));
}

/**
 * Process the return (transaction-safe).
 */
public function returnBook(Issue $issue)
{
    if ($issue->isReturned()) {
        return redirect()->route('librarian.issues.index')
                         ->with('error', 'This book has already been returned.');
    }

    try {
        DB::transaction(function () use ($issue) {
            // Lock the copy so no concurrent operations happen
            $copy = BookCopy::where('id', $issue->book_copy_id)
                            ->lockForUpdate()
                            ->first();

            if (!$copy) {
                throw new \Exception('Book copy not found.');
            }

            // Mark issue as returned
            $issue->update([
                'returned_at' => now(),
                'returned_by' => Auth::id(),
            ]);

            // Make the copy available again
            $copy->update(['status' => 'available']);
        });

        return redirect()->route('librarian.issues.index')
                         ->with('success', 'Book returned successfully.');

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}
}