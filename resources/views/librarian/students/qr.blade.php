@extends('layouts.librarian')

@section('title', 'Student QR Code')
@section('page-title', 'Student QR Code')

@section('content')

<div class="mb-3">
    <a href="{{ route('librarian.students.index') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Students
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4 text-center">

                <h5 class="fw-bold mb-1">Student QR Code</h5>
                <p class="text-muted small mb-4">{{ $student->name }}</p>

                {{-- QR Code --}}
                <div class="d-inline-block p-3 border rounded-3 bg-white mb-3">
                    {!! DNS2D::getBarcodeSVG(
                        route('librarian.students.qr', $student),
                        'QRCODE',
                        5,
                        5
                    ) !!}
                </div>

                <div class="mt-3">
                    <div class="fw-bold">{{ $student->name }}</div>
                    <div class="text-muted small">{{ $student->student_id }}</div>
                    <div class="text-muted small">{{ $student->email }}</div>
                </div>

                <hr>

                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('librarian.students.idCard', $student) }}"
                       target="_blank"
                       class="btn btn-success">
                        <i class="bi bi-printer me-1"></i> Print ID Card
                    </a>
                    <a href="{{ route('librarian.students.index') }}" class="btn btn-light">
                        Back
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection