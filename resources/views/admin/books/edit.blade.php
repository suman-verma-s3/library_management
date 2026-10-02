@extends('layouts.admin')

@section('title', 'Edit Book')
@section('page-title', 'Edit Book')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.books.index') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Books
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">Edit Book</h5>
                <p class="text-muted small mb-4">Update the details below</p>

                <form method="POST" action="{{ route('admin.books.update', $book) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="category_id" class="form-label fw-medium">
                                Category <span class="text-danger">*</span>
                            </label>
                            <select id="category_id" name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="publication_year" class="form-label fw-medium">Publication Year</label>
                            <input id="publication_year" type="number" name="publication_year"
                                   value="{{ old('publication_year', $book->publication_year) }}"
                                   class="form-control @error('publication_year') is-invalid @enderror"
                                   min="1000" max="{{ date('Y') }}">
                            @error('publication_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="title" class="form-label fw-medium">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input id="title" type="text" name="title"
                                   value="{{ old('title', $book->title) }}"
                                   class="form-control @error('title') is-invalid @enderror"
                                   required autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="author" class="form-label fw-medium">
                                Author <span class="text-danger">*</span>
                            </label>
                            <input id="author" type="text" name="author"
                                   value="{{ old('author', $book->author) }}"
                                   class="form-control @error('author') is-invalid @enderror"
                                   required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="isbn" class="form-label fw-medium">ISBN</label>
                            <input id="isbn" type="text" name="isbn"
                                   value="{{ old('isbn', $book->isbn) }}"
                                   class="form-control @error('isbn') is-invalid @enderror">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="publisher" class="form-label fw-medium">Publisher</label>
                            <input id="publisher" type="text" name="publisher"
                                   value="{{ old('publisher', $book->publisher) }}"
                                   class="form-control @error('publisher') is-invalid @enderror">
                            @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-medium">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                        <button class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Book
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection