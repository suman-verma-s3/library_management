@extends('layouts.librarian')

@section('title', 'Return Book')
@section('page-title', 'Return Book')

@section('content')

<div class="mb-3">
    <a href="{{ route('librarian.issues.index') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Issued Books
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">Return Book</h5>
                <p class="text-muted small mb-4">Confirm the return of this book copy.</p>

                {{-- Overdue Warning --}}
                @if($issue->isOverdue())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <strong>Overdue!</strong>
                        This book was due on
                        <strong>{{ $issue->due_date->format('d M Y') }}</strong>
                        ({{ $issue->due_date->diffInDays(now()) }} days ago).
                    </div>
                @endif

                {{-- Issue Details --}}
                <div class="border rounded-3 p-3 mb-4 bg-light">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Student</small>
                            <div class="fw-medium">{{ $issue->student->name }}</div>
                            <small class="text-muted">{{ $issue->student->student_id }}</small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Book</small>
                            <div class="fw-medium">{{ $issue->bookCopy->book->title }}</div>
                            <small class="text-muted">{{ $issue->bookCopy->book->author }}</small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Accession No</small>
                            <span class="badge bg-dark font-monospace">
                                {{ $issue->bookCopy->accession_number }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Issued On</small>
                            <div class="fw-medium">{{ $issue->issued_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Due Date</small>
                            <div class="fw-medium">{{ $issue->due_date->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Issued By</small>
                            <div class="fw-medium">{{ $issue->issuedBy->name ?? '—' }}</div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('librarian.issues.return', $issue) }}">
                    @csrf
                    @method('PUT')

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('librarian.issues.index') }}" class="btn btn-light">Cancel</a>
                        <button class="btn btn-success">
                            <i class="bi bi-check-lg me-1"></i> Confirm Return
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection