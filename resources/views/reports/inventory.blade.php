@extends('layouts.reports')

@section('title', 'Inventory Summary')
@section('page-title', 'Inventory Summary')

@section('content')

<div class="mb-4">
    <h5 class="fw-bold mb-1">Inventory Summary</h5>
    <p class="text-muted small mb-0">Complete library inventory overview</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10 text-primary mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-book"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['total_books'] }}</h4>
            <small class="text-muted">Total Books</small>
        </div>
    </div>

    <div class="col-6 col-md-3 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-info bg-opacity-10 text-info mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-collection"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['total_copies'] }}</h4>
            <small class="text-muted">Physical Copies</small>
        </div>
    </div>

    <div class="col-6 col-md-3 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-success bg-opacity-10 text-success mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-check-circle"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['available'] }}</h4>
            <small class="text-muted">Available</small>
        </div>
    </div>

    <div class="col-6 col-md-3 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-warning bg-opacity-10 text-warning mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-journal-arrow-up"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['issued'] }}</h4>
            <small class="text-muted">Issued</small>
        </div>
    </div>

    <div class="col-6 col-md-3 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-secondary bg-opacity-10 text-secondary mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-tools"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['damaged'] }}</h4>
            <small class="text-muted">Damaged</small>
        </div>
    </div>

    <div class="col-6 col-md-3 col-xl-2">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-danger bg-opacity-10 text-danger mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-x-circle"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['lost'] }}</h4>
            <small class="text-muted">Lost</small>
        </div>
    </div>
</div>

{{-- Secondary Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card p-3">
            <small class="text-muted">Total Students</small>
            <h4 class="fw-bold mb-0">{{ $stats['total_students'] }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-3">
            <small class="text-muted">Active Issues</small>
            <h4 class="fw-bold mb-0 text-warning">{{ $stats['active_issues'] }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-3">
            <small class="text-muted">Total Issues (all-time)</small>
            <h4 class="fw-bold mb-0">{{ $stats['total_issues'] }}</h4>
        </div>
    </div>
</div>

{{-- Books Table --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="fw-bold mb-0">Books Inventory Breakdown</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Available</th>
                    <th class="text-center">Issued</th>
                    <th class="text-center">Damaged</th>
                    <th class="text-center">Lost</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td class="fw-medium">{{ $book->title }}</td>
                        <td class="text-muted small">{{ $book->author }}</td>
                        <td class="text-center fw-medium">{{ $book->copies_count }}</td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ $book->available_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning text-dark">{{ $book->issued_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $book->damaged_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger">{{ $book->lost_count }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inboxes fs-1 d-block mb-2"></i>
                            No books in inventory.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
        <div class="card-footer bg-white border-top">{{ $books->links() }}</div>
    @endif
</div>

@endsection