@extends('layouts.reports')

@section('title', 'Currently Issued')
@section('page-title', 'Currently Issued Books')

@section('content')

<div class="mb-3">
    <h5 class="fw-bold mb-1">Currently Issued Books</h5>
    <p class="text-muted small mb-0">
        Total: <strong>{{ $issues->total() }}</strong> books currently issued
    </p>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Book</th>
                    <th>Accession No</th>
                    <th>Issued</th>
                    <th>Due</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($issues as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td>
                            <div class="fw-medium">{{ $issue->student->name }}</div>
                            <small class="text-muted">{{ $issue->student->student_id }}</small>
                        </td>
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
                        <td>
                            <span class="badge bg-{{ $issue->statusColor() }}">
                                {{ $issue->statusLabel() }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-check fs-1 d-block mb-2"></i>
                            No books currently issued.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($issues->hasPages())
        <div class="card-footer bg-white border-top">{{ $issues->links() }}</div>
    @endif
</div>

@endsection