@extends('layouts.librarian')

@section('title', 'Issue Book')
@section('page-title', 'Issue Book')

@section('content')

<div class="mb-3">
    <a href="{{ route('librarian.issues.index') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Issued Books
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">Issue a Book</h5>
                <p class="text-muted small mb-4">
                    Select a student, then a book, then a specific copy to issue.
                    Due date will be <strong>14 days</strong> from today.
                </p>

                <form method="POST" action="{{ route('librarian.issues.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="student_id" class="form-label fw-medium">
                            Student <span class="text-danger">*</span>
                        </label>
                        <select id="student_id" name="student_id"
                                class="form-select @error('student_id') is-invalid @enderror" required>
                            <option value="">-- Select Student --</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }} ({{ $s->student_id }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="book_id" class="form-label fw-medium">
                            Book <span class="text-danger">*</span>
                        </label>
                        <select id="book_id" class="form-select" required>
                            <option value="">-- Select Book --</option>
                            @foreach($books as $b)
                                <option value="{{ $b->id }}">
                                    {{ $b->title }} — {{ $b->author }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Book select karne ke baad available copies load hongi.</small>
                    </div>

                    <div class="mb-4">
                        <label for="book_copy_id" class="form-label fw-medium">
                            Available Copy <span class="text-danger">*</span>
                        </label>
                        <select id="book_copy_id" name="book_copy_id"
                                class="form-select @error('book_copy_id') is-invalid @enderror"
                                required disabled>
                            <option value="">-- First select a book --</option>
                        </select>
                        @error('book_copy_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-1"></i>
                        <strong>Due Date:</strong> {{ now()->addDays(14)->format('d M Y') }}
                        (14 days from today)
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('librarian.issues.index') }}" class="btn btn-light">Cancel</a>
                        <button class="btn btn-success" id="submitBtn" disabled>
                            <i class="bi bi-check-lg me-1"></i> Issue Book
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const bookSelect  = document.getElementById('book_id');
    const copySelect  = document.getElementById('book_copy_id');
    const submitBtn   = document.getElementById('submitBtn');
    const baseUrl     = "{{ url('/librarian/books') }}";

    bookSelect.addEventListener('change', function () {
        const bookId = this.value;

        copySelect.innerHTML = '<option value="">Loading...</option>';
        copySelect.disabled  = true;
        submitBtn.disabled   = true;

        if (!bookId) {
            copySelect.innerHTML = '<option value="">-- First select a book --</option>';
            return;
        }

        fetch(`${baseUrl}/${bookId}/available-copies`)
            .then(res => res.json())
            .then(copies => {
                if (copies.length === 0) {
                    copySelect.innerHTML = '<option value="">No available copies</option>';
                    return;
                }
                let html = '<option value="">-- Select Copy --</option>';
                copies.forEach(c => {
                    html += `<option value="${c.id}">${c.accession_number}</option>`;
                });
                copySelect.innerHTML = html;
                copySelect.disabled = false;
            })
            .catch(() => {
                copySelect.innerHTML = '<option value="">Error loading copies</option>';
            });
    });

    copySelect.addEventListener('change', function () {
        submitBtn.disabled = !this.value;
    });
});
</script>

@endsection