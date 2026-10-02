@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Welcome --}}
<div class="mb-4">
    <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }} 👋</h4>
    <p class="text-muted small mb-0">Here's what's happening in your library today.</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="stat-icon bg-primary bg-opacity-10 text-primary mb-2">
                <i class="bi bi-book"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['books'] }}</h3>
            <small class="text-muted">Total Books</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="stat-icon bg-info bg-opacity-10 text-info mb-2">
                <i class="bi bi-collection"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['copies'] }}</h3>
            <small class="text-muted">Physical Copies</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="stat-icon bg-success bg-opacity-10 text-success mb-2">
                <i class="bi bi-people"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['students'] }}</h3>
            <small class="text-muted">Students</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="stat-icon bg-warning bg-opacity-10 text-warning mb-2">
                <i class="bi bi-journal-arrow-up"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['issued'] }}</h3>
            <small class="text-muted">Issued Now</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="stat-icon bg-danger bg-opacity-10 text-danger mb-2">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['overdue'] }}</h3>
            <small class="text-muted">Overdue</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="stat-icon bg-secondary bg-opacity-10 text-secondary mb-2">
                <i class="bi bi-check2-circle"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $stats['available'] }}</h3>
            <small class="text-muted">Available</small>
        </div>
    </div>

</div>

{{-- Quick Actions + Recent Activity --}}
<div class="row g-3">

    {{-- Quick Actions --}}
    <div class="col-lg-4">
        <div class="card stat-card p-4 h-100">
            <h6 class="fw-bold mb-3">Quick Actions</h6>

            <div class="d-grid gap-2">
                <a href="{{ route('admin.categories.create') }}"
                   class="btn btn-outline-primary text-start">
                    <i class="bi bi-plus-circle me-2"></i> Add Category
                </a>
                <a href="{{ route('admin.books.create') }}"
                   class="btn btn-outline-primary text-start">
                    <i class="bi bi-plus-circle me-2"></i> Add Book
                </a>
                <a href="{{ route('admin.copies.create') }}"
                   class="btn btn-outline-primary text-start">
                    <i class="bi bi-plus-circle me-2"></i> Add Physical Copy
                </a>
                <a href="{{ route('reports.inventory') }}"
                   class="btn btn-outline-secondary text-start">
                    <i class="bi bi-bar-chart me-2"></i> View Reports
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="col-lg-8">
        <div class="card stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Recent Activity</h6>
                <a href="{{ route('reports.issued') }}"
                   class="text-primary small text-decoration-none">
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
                                <td colspan="4" class="text-center text-muted py-4">
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