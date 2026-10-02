@extends('layouts.librarian')

@section('title', 'Issued Books')
@section('page-title', 'Issued Books')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-1">Issued Books</h5>
        <p class="text-muted small mb-0">Track all book issues and returns</p>
    </div>
    <a href="{{ route('librarian.issues.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Issue Book
    </a>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm rounded-3 mb-3">
    <div class="card-body p-3">
        <form method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm"
                       placeholder="Search student name, ID, or accession no...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- All --</option>
                    <option value="issued"   {{ request('status') === 'issued' ? 'selected' : '' }}>Currently Issued</option>
                    <option value="overdue"  {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                    <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-sm btn-success flex-grow-1">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('librarian.issues.index') }}" class="btn btn-sm btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Student</th>
                    <th>Book</th>
                    <th>Accession No</th>
                    <th>Issued</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th style="width:140px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($issues as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td>
                            <div class="fw-medium">{{ $issue->student->name ?? '—' }}</div>
                            <small class="text-muted">{{ $issue->student->student_id ?? '' }}</small>
                        </td>
                        <td>
                            <div class="fw-medium">{{ $issue->bookCopy->book->title ?? '—' }}</div>
                            <small class="text-muted">{{ $issue->bookCopy->book->author ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-dark font-monospace">
                                {{ $issue->bookCopy->accession_number ?? '—' }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $issue->issued_at?->format('d M Y') ?? '—' }}</td>
                        <td class="text-muted small">{{ $issue->due_date?->format('d M Y') ?? '—' }}</td>
                        <td>
                            <span class="badge bg-{{ $issue->statusColor() }}">
                                {{ $issue->statusLabel() }}
                            </span>
                        </td>
                       <td class="text-end">
    @if(!$issue->isReturned())
        <a href="{{ route('librarian.issues.showReturn', $issue) }}"
           class="btn btn-sm btn-outline-success">
            <i class="bi bi-arrow-return-left"></i> Return
        </a>
    @else
        <small class="text-muted">
            Returned {{ $issue->returned_at?->format('d M Y') }}
        </small>
    @endif
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                            No issues found. Click "Issue Book" to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($issues->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $issues->links() }}
        </div>
    @endif
</div>

@endsection