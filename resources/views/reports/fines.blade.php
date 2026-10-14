@extends('layouts.reports')

@section('title', 'Fines Report')
@section('page-title', 'Fines Report')

@section('content')

<div class="mb-4">
    <h5 class="fw-bold mb-1">Fines Report</h5>
    <p class="text-muted small mb-0">Track all late fees and payments</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10 text-primary mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-cash-stack"></i>
            </div>
            <h4 class="fw-bold mb-0">₹{{ number_format($stats['total_fines'], 2) }}</h4>
            <small class="text-muted">Total Fines</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-success bg-opacity-10 text-success mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-check-circle"></i>
            </div>
            <h4 class="fw-bold mb-0 text-success">₹{{ number_format($stats['collected'], 2) }}</h4>
            <small class="text-muted">Collected</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-danger bg-opacity-10 text-danger mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-exclamation-circle"></i>
            </div>
            <h4 class="fw-bold mb-0 text-danger">₹{{ number_format($stats['pending'], 2) }}</h4>
            <small class="text-muted">Pending</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-warning bg-opacity-10 text-warning mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-list-check"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['total_records'] }}</h4>
            <small class="text-muted">Total Records</small>
        </div>
    </div>

</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm rounded-3 mb-3">
    <div class="card-body p-3">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- All Fines --</option>
                    <option value="paid"   {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-sm btn-primary flex-grow-1">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('reports.fines') }}" class="btn btn-sm btn-light">Reset</a>
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
                    <th>Due Date</th>
                    <th>Returned</th>
                    <th class="text-center">Days Late</th>
                    <th class="text-center">Fine</th>
                    <th class="text-center">Status</th>
                    <th style="width:120px;" class="text-end">Actions</th>  
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
                        <td class="text-muted small">{{ $issue->due_date->format('d M Y') }}</td>
                        <td class="text-muted small">
                            {{ $issue->returned_at?->format('d M Y') ?? '—' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning text-dark">
                                {{ $issue->daysLate() }} days
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger fs-6">
                                ₹{{ number_format($issue->fine_amount, 2) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($issue->fine_paid)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Paid
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-clock"></i> Unpaid
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
    @if(!$issue->fine_paid)
        <form action="{{ route('librarian.issues.markPaid', $issue) }}"
              method="POST" class="d-inline"
              onsubmit="return confirm('Mark this fine as paid?')">
            @csrf
            @method('PUT')
            <button class="btn btn-sm btn-success" title="Mark as paid">
                <i class="bi bi-cash-coin"></i> Mark Paid
            </button>
        </form>
    @else
        <span class="text-success small">
            <i class="bi bi-check-circle-fill"></i> Settled
        </span>
    @endif
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-5 text-muted">
                            <i class="bi bi-cash fs-1 d-block mb-2"></i>
                            No fines recorded.
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