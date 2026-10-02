@extends('layouts.librarian')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Welcome --}}
<div class="mb-4">
    <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }} 👋</h4>
    <p class="text-muted small mb-0">Here's your librarian overview for today.</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-success bg-opacity-10 text-success mb-2"
                 style="width:48px;height:48px;font-size:1.4rem;">
                <i class="bi bi-people"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['students'] }}</h3>
            <small class="text-muted">Total Students</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10 text-primary mb-2"
                 style="width:48px;height:48px;font-size:1.4rem;">
                <i class="bi bi-person-check"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['active_students'] }}</h3>
            <small class="text-muted">Active Students</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-warning bg-opacity-10 text-warning mb-2"
                 style="width:48px;height:48px;font-size:1.4rem;">
                <i class="bi bi-journal-arrow-up"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['issued'] }}</h3>
            <small class="text-muted">Issued Now</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-danger bg-opacity-10 text-danger mb-2"
                 style="width:48px;height:48px;font-size:1.4rem;">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['overdue'] }}</h3>
            <small class="text-muted">Overdue</small>
        </div>
    </div>

</div>

{{-- Quick Actions + Recent Activity --}}
<div class="row g-3">

    {{-- Quick Actions --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 p-4 h-100">
            <h6 class="fw-bold mb-3">Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('librarian.students.index') }}"
                   class="btn btn-outline-success text-start">
                    <i class="bi bi-people me-2"></i> Manage Students
                </a>
                <a href="{{ route('librarian.issues.create') }}"
                   class="btn btn-outline-success text-start">
                    <i class="bi bi-journal-arrow-up me-2"></i> Issue Book
                </a>
                <a href="{{ route('librarian.issues.index', ['status' => 'issued']) }}"
                   class="btn btn-outline-success text-start">
                    <i class="bi bi-journal-arrow-down me-2"></i> Return Book
                </a>
                <a href="{{ route('reports.students') }}"
                   class="btn btn-outline-secondary text-start">
                    <i class="bi bi-clock-history me-2"></i> View History
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Recent Activity</h6>
                <a href="{{ route('librarian.issues.index') }}"
                   class="text-success small text-decoration-none">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Book</th>
                            <th>Issued</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentIssues as $issue)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $issue->student->name ?? '—' }}</div>
                                    <small class="text-muted">{{ $issue->student->student_id ?? '' }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $issue->bookCopy->book->title ?? '—' }}</div>
                                    <small class="text-muted">{{ $issue->bookCopy->accession_number ?? '' }}</small>
                                </td>
                                <td class="text-muted small">
                                    {{ $issue->issued_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td>
                                    @if($issue->returned_at)
                                        <span class="badge bg-success">Returned</span>
                                    @elseif($issue->due_date && $issue->due_date < now())
                                        <span class="badge bg-danger">Overdue</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Issued</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No recent activity yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection