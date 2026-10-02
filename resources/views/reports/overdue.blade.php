@extends('layouts.reports')

@section('title', 'Overdue Books')
@section('page-title', 'Overdue Books')

@section('content')

<div class="mb-3">
    <h5 class="fw-bold mb-1">Overdue Books</h5>
    <p class="text-muted small mb-0">
        Total: <strong class="text-danger">{{ $issues->total() }}</strong> overdue books
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
                    <th class="text-center">Days Overdue</th>
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
                        <td class="text-center">
                            <span class="badge bg-danger">
                                {{ $issue->due_date->diffInDays(now()) }} days
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-success">
                            <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                            No overdue books. 
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