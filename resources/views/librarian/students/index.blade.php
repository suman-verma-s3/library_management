@extends('layouts.librarian')

@section('title', 'Students')
@section('page-title', 'Students')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-1">All Students</h5>
        <p class="text-muted small mb-0">Manage library members</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-success"
                data-bs-toggle="modal"
                data-bs-target="#importModal">
            <i class="bi bi-upload me-1"></i> Import Excel
        </button>
        <a href="{{ route('librarian.students.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Add Student
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm rounded-3 mb-3">
    <div class="card-body p-3">
        <form method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm"
                       placeholder="Search name, ID, or email...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- All Status --</option>
                    <option value="active"   {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-sm btn-success flex-grow-1">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('librarian.students.index') }}" class="btn btn-sm btn-light">Reset</a>
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
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th style="width:180px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $s)
                    <tr>
                        <td>{{ $s->id }}</td>
                        <td><span class="badge bg-dark font-monospace">{{ $s->student_id }}</span></td>
                        <td class="fw-medium">{{ $s->name }}</td>
                        <td class="text-muted small">{{ $s->email }}</td>
                        <td class="text-muted small">{{ $s->phone ?? '—' }}</td>
                        <td class="text-muted small">{{ $s->course ?? '—' }}</td>
                        <td>
                            <span class="badge bg-{{ $s->statusColor() }}">
                                {{ ucfirst($s->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('librarian.students.edit', $s) }}"
                               class="btn btn-sm btn-outline-success">
                                <i class="bi bi-pencil"></i>
                            </a>
                             <a href="{{ route('librarian.students.qr', $s) }}"
       class="btn btn-sm btn-outline-info"
       title="View QR Code">
        <i class="bi bi-qr-code"></i>
    </a>
    <a href="{{ route('librarian.students.idCard', $s) }}"
       target="_blank"
       class="btn btn-sm btn-outline-secondary"
       title="Print ID Card">
        <i class="bi bi-person-vcard"></i>
    </a>
                            <form action="{{ route('librarian.students.destroy', $s) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this student?')">
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
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                            No students found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $students->links() }}
        </div>
    @endif
</div>

{{-- Import Modal --}}
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST"
                  action="{{ route('librarian.students.import') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Import Students from Excel</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="file" class="form-label fw-medium">
                            Excel File <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               id="file"
                               name="file"
                               class="form-control @error('file') is-invalid @enderror"
                               accept=".xlsx,.xls,.csv"
                               required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">
                            Allowed: .xlsx, .xls, .csv (max 2 MB)
                        </small>
                    </div>

                    <div class="alert alert-info small mb-0">
                        <strong>Required columns:</strong>
                        <code>student_id</code>, <code>name</code>, <code>email</code><br>
                        <strong>Optional:</strong>
                        <code>phone</code>, <code>course</code>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload me-1"></i> Import
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection