@extends('layouts.reports')

@section('title', 'Student History')
@section('page-title', 'Student Borrowing History')

@section('content')

<div class="mb-3">
    <a href="{{ route('reports.students') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Students
    </a>
</div>

{{-- Student Info Card --}}
<div class="card border-0 shadow-sm rounded-3 mb-3">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <small class="text-muted d-block">Student Name</small>
                <h5 class="fw-bold mb-0">{{ $student->name }}</h5>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Student ID</small>
                <span class="badge bg-dark font-monospace">{{ $student->student_id }}</span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Status</small>
                <span class="badge bg-{{ $student->statusColor() }}">
                    {{ ucfirst($student->status) }}
                </span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Email</small>
                <div class="fw-medium">{{ $student->email }}</div>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Course</small>
                <div class="fw-medium">{{ $student->course ?? '—' }}</div>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Phone</small>
                <div class="fw-medium">{{ $student->phone ?? '—' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Summary Badges --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <small class="text-muted">Total Issues</small>
            <h4 class="fw-bold mb-0">{{ $issues->count() }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <small class="text-muted">Active</small>
            <h4 class="fw-bold mb-0 text-warning">
                {{ $issues->whereNull('returned_at')->count() }}
            </h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <small class="text-muted">Returned</small>
            <h4 class="fw-bold mb-0 text-success">
                {{ $issues->whereNotNull('returned_at')->count() }}
            </h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <small class="text-muted">Overdue</small>
            <h4 class="fw-bold mb-0 text-danger">
                {{ $issues->filter(fn($i) => $i->isOverdue())->count() }}
            </h4>
        </div>
    </div>
</div>

{{-- History Table --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Book</th>
                    <th>Accession No</th>
                    <th>Issued On</th>
                    <th>Due Date</th>
                    <th>Returned On</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($issues as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td>
                            <div class="fw-medium">{{ $issue->bookCopy->book->title }}</div>
                            <small class="text-muted">{{ $issue->bookCopy->book->author }}</small>
                        </td>
                        <td>
                            <span class="badge bg-dark font-monospace">
                                {{ $issue->bookCopy->accession_number }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $issue->issued_at->format('d M Y') }}</td>
                        <td class="text-muted small">{{ $issue->due_date->format('d M Y') }}</td>
                        <td class="text-muted small">
                            {{ $issue->returned_at?->format('d M Y') ?? '—' }}
                        </td>
                        <td>
                            <span class="badge bg-{{ $issue->statusColor() }}">
                                {{ $issue->statusLabel() }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-clock-history fs-1 d-block mb-2"></i>
                            This student has no borrowing history yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection