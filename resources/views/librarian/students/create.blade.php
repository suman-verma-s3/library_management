@extends('layouts.librarian')

@section('title', 'Add Student')
@section('page-title', 'Add Student')

@section('content')

<div class="mb-3">
    <a href="{{ route('librarian.students.index') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Students
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">Add New Student</h5>
                <p class="text-muted small mb-4">Register a new library member</p>

                <form method="POST" action="{{ route('librarian.students.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="student_id" class="form-label fw-medium">
                                Student ID <span class="text-danger">*</span>
                            </label>
                            <input id="student_id" type="text" name="student_id"
                                   value="{{ old('student_id') }}"
                                   class="form-control font-monospace @error('student_id') is-invalid @enderror"
                                   placeholder="e.g., STU-2026-001" required autofocus>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label fw-medium">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <input id="name" type="text" name="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="e.g., Rahul Sharma" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-medium">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input id="email" type="email" name="email"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="student@example.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-medium">Phone</label>
                            <input id="phone" type="text" name="phone"
                                   value="{{ old('phone') }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="+91 98765 43210">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="course" class="form-label fw-medium">Course / Class</label>
                            <input id="course" type="text" name="course"
                                   value="{{ old('course') }}"
                                   class="form-control @error('course') is-invalid @enderror"
                                   placeholder="e.g., BCA, MCA, B.Tech">
                            @error('course')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label fw-medium">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active"   {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label fw-medium">Address</label>
                            <textarea id="address" name="address" rows="3"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="Optional">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('librarian.students.index') }}" class="btn btn-light">Cancel</a>
                        <button class="btn btn-success">
                            <i class="bi bi-check-lg me-1"></i> Save Student
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection