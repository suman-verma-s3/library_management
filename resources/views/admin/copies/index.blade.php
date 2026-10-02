@extends('layouts.admin')

@section('title', 'Physical Copies')
@section('page-title', 'Physical Copies')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-1">All Book Copies</h5>
        <p class="text-muted small mb-0">Manage physical copies with accession numbers</p>
    </div>
    <a href="{{ route('admin.copies.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Copy
    </a>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm rounded-3 mb-3">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.copies.index') }}" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Accession no...">
            </div>
            <div class="col-md-3">
                <select name="book_id" class="form-select form-select-sm">
                    <option value="">-- All Books --</option>
                    @foreach($books as $b)
                        <option value="{{ $b->id }}" {{ request('book_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- All Status --</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="issued"    {{ request('status') === 'issued' ? 'selected' : '' }}>Issued</option>
                    <option value="damaged"   {{ request('status') === 'damaged' ? 'selected' : '' }}>Damaged</option>
                    <option value="lost"      {{ request('status') === 'lost' ? 'selected' : '' }}>Lost</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-sm btn-primary flex-grow-1">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('admin.copies.index') }}" class="btn btn-sm btn-light">
                    Reset
                </a>
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
                    <th>Accession No</th>
                    <th>Book</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th style="width:140px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($copies as $copy)
                    <tr>
                        <td>{{ $copy->id }}</td>
                        <td>
                            <span class="badge bg-dark font-monospace">{{ $copy->accession_number }}</span>
                        </td>
                        <td>
                            <div class="fw-medium">{{ $copy->book->title ?? '—' }}</div>
                            <small class="text-muted">{{ $copy->book->author ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-{{ $copy->statusColor() }}">
                                {{ ucfirst($copy->status) }}
                            </span>
                        </td>
                        <td class="text-muted small">
                            {{ $copy->notes ? Str::limit($copy->notes, 40) : '—' }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.copies.edit', $copy) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.copies.destroy', $copy) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this copy?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inboxes fs-1 d-block mb-2"></i>
                            No copies found. Click "Add Copy" to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($copies->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $copies->links() }}
        </div>
    @endif
</div>

@endsection