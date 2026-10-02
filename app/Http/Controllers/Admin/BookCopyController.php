<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\Request;

class BookCopyController extends Controller
{
    public function index(Request $request)
    {
        $query = BookCopy::with('book');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by book
        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        // Search by accession number
        if ($request->filled('search')) {
            $query->where('accession_number', 'like', '%' . $request->search . '%');
        }

        $copies = $query->latest()->paginate(15)->withQueryString();
        $books  = Book::orderBy('title')->get();

        return view('admin.copies.index', compact('copies', 'books'));
    }

    public function create()
    {
        $books = Book::orderBy('title')->get();
        $nextAccessionNumber = $this->generateAccessionNumber();

        return view('admin.copies.create', compact('books', 'nextAccessionNumber'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id'          => 'required|exists:books,id',
            'accession_number' => 'required|string|max:50|unique:book_copies,accession_number',
            'status'           => 'required|in:available,issued,damaged,lost',
            'notes'            => 'nullable|string|max:500',
        ]);

        BookCopy::create($data);

        return redirect()->route('admin.copies.index')
                         ->with('success', 'Book copy added successfully.');
    }

    public function edit(BookCopy $copy)
    {
        $books = Book::orderBy('title')->get();
        return view('admin.copies.edit', compact('copy', 'books'));
    }

    public function update(Request $request, BookCopy $copy)
    {
        $data = $request->validate([
            'book_id'          => 'required|exists:books,id',
            'accession_number' => 'required|string|max:50|unique:book_copies,accession_number,' . $copy->id,
            'status'           => 'required|in:available,issued,damaged,lost',
            'notes'            => 'nullable|string|max:500',
        ]);

        $copy->update($data);

        return redirect()->route('admin.copies.index')
                         ->with('success', 'Book copy updated successfully.');
    }

    public function destroy(BookCopy $copy)
    {
        if ($copy->status === 'issued') {
            return back()->with('error', 'Cannot delete: this copy is currently issued.');
        }

        $copy->delete();

        return redirect()->route('admin.copies.index')
                         ->with('success', 'Book copy deleted successfully.');
    }

    /**
     * Generate next accession number like LIB-0001, LIB-0002, ...
     */
    private function generateAccessionNumber(): string
    {
        $last = BookCopy::orderByDesc('id')->first();
        $next = $last ? ((int) substr($last->accession_number, 4)) + 1 : 1;
        return 'LIB-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}