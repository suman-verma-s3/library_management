@extends('layouts.admin')

@section('title', 'Add Book')
@section('page-title', 'Add Book')

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

                <h5 class="fw-bold mb-1">Add New Book</h5>
                <p class="text-muted small mb-4">Fill the details below</p>

                <form method="POST" action="{{ route('admin.books.store') }}">
                    @csrf

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
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                                   value="{{ old('publication_year') }}"
                                   class="form-control @error('publication_year') is-invalid @enderror"
                                   placeholder="e.g., 2023"
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
                                   value="{{ old('title') }}"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="e.g., Laravel: Up & Running"
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
                                   value="{{ old('author') }}"
                                   class="form-control @error('author') is-invalid @enderror"
                                   placeholder="e.g., Matt Stauffer"
                                   required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="isbn" class="form-label fw-medium">ISBN</label>
                            <input id="isbn" type="text" name="isbn"
                                   value="{{ old('isbn') }}"
                                   class="form-control @error('isbn') is-invalid @enderror"
                                   placeholder="e.g., 978-1492052172">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="publisher" class="form-label fw-medium">Publisher</label>
                            <input id="publisher" type="text" name="publisher"
                                   value="{{ old('publisher') }}"
                                   class="form-control @error('publisher') is-invalid @enderror"
                                   placeholder="e.g., O'Reilly Media">
                            @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-medium">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Optional short description">{{ old('description') }}</textarea>
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
                            <i class="bi bi-check-lg me-1"></i> Save Book
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection