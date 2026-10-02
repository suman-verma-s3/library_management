@extends('layouts.reports')

@section('title', 'Student History')
@section('page-title', 'Student Borrowing History')

@section('content')

<div class="mb-3">
    <h5 class="fw-bold mb-1">Student Borrowing History</h5>
    <p class="text-muted small mb-0">
        Click any student to view their complete borrowing history.
    </p>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th class="text-center">Total Issues</th>
                    <th class="text-center">Active</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $s)
                    <tr>
                        <td>{{ $s->id }}</td>
                        <td><span class="badge bg-dark font-monospace">{{ $s->student_id }}</span></td>
                        <td class="fw-medium">{{ $s->name }}</td>
                        <td class="text-muted small">{{ $s->course ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                {{ $s->total_issues }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($s->active_issues > 0)
                                <span class="badge bg-warning text-dark">{{ $s->active_issues }}</span>
                            @else
                                <span class="badge bg-secondary">0</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('reports.studentHistory', $s) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-clock-history"></i> View History
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                            No students found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
        <div class="card-footer bg-white border-top">{{ $students->links() }}</div>
    @endif
</div>

@endsection