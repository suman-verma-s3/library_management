@extends('layouts.admin')

@section('title', 'Books')
@section('page-title', 'Books')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-1">All Books</h5>
            <p class="text-muted small mb-0">Manage library books</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Book
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>ISBN</th>
                        <th>Year</th>
                        <th class="text-center">Copies</th>
                        <th style="width:140px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td class="fw-medium">{{ $book->title }}</td>
                            <td class="text-muted small">{{ $book->author }}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $book->category->name ?? '—' }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $book->isbn ?? '—' }}</td>
                            <td class="text-muted small">{{ $book->publication_year ?? '—' }}</td>
                            <td class="text-center"> {{-- 👈 NEW --}}
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    {{ $book->copies->count() }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this book?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                No books yet. Click "Add Book" to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($books->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $books->links() }}
            </div>
        @endif
    </div>

@endsection
