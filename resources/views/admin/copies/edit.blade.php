@extends('layouts.admin')

@section('title', 'Edit Copy')
@section('page-title', 'Edit Copy')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.copies.index') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Copies
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">Edit Book Copy</h5>
                <p class="text-muted small mb-4">
                    Accession: <span class="badge bg-dark font-monospace">{{ $copy->accession_number }}</span>
                </p>

                <form method="POST" action="{{ route('admin.copies.update', $copy) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="book_id" class="form-label fw-medium">
                            Book <span class="text-danger">*</span>
                        </label>
                        <select id="book_id" name="book_id"
                                class="form-select @error('book_id') is-invalid @enderror" required>
                            @foreach($books as $b)
                                <option value="{{ $b->id }}"
                                    {{ old('book_id', $copy->book_id) == $b->id ? 'selected' : '' }}>
                                    {{ $b->title }} — {{ $b->author }}
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="accession_number" class="form-label fw-medium">
                            Accession Number <span class="text-danger">*</span>
                        </label>
                        <input id="accession_number" type="text" name="accession_number"
                               value="{{ old('accession_number', $copy->accession_number) }}"
                               class="form-control font-monospace @error('accession_number') is-invalid @enderror"
                               required>
                        @error('accession_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-medium">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select id="status" name="status"
                                class="form-select @error('status') is-invalid @enderror" required>
                            <option value="available" {{ old('status', $copy->status) === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="issued"    {{ old('status', $copy->status) === 'issued' ? 'selected' : '' }}>Issued</option>
                            <option value="damaged"   {{ old('status', $copy->status) === 'damaged' ? 'selected' : '' }}>Damaged</option>
                            <option value="lost"      {{ old('status', $copy->status) === 'lost' ? 'selected' : '' }}>Lost</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-medium">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $copy->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.copies.index') }}" class="btn btn-light">Cancel</a>
                        <button class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Copy
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection