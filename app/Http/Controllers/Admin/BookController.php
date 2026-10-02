<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
   public function index()
{
    $books = Book::with(['category', 'copies'])->latest()->paginate(10);
    return view('admin.books.index', compact('books'));
}

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'isbn'             => 'nullable|string|max:50|unique:books,isbn',
            'publisher'        => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'description'      => 'nullable|string|max:1000',
        ]);

        Book::create($data);

        return redirect()->route('admin.books.index')
                         ->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'isbn'             => 'nullable|string|max:50|unique:books,isbn,' . $book->id,
            'publisher'        => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'description'      => 'nullable|string|max:1000',
        ]);

        $book->update($data);

        return redirect()->route('admin.books.index')
                         ->with('success', 'Book updated successfully.');
    }

   public function destroy(Book $book)
{
    if ($book->copies()->count() > 0) {
        return redirect()->route('admin.books.index')
                         ->with('error', 'Cannot delete: this book has physical copies.');
    }

    $book->delete();

    return redirect()->route('admin.books.index')
                     ->with('success', 'Book deleted successfully.');
}
}