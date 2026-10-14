<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student ID Card - {{ $student->student_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
            padding: 40px 20px;
            font-family: system-ui, sans-serif;
        }
        .id-card {
            width: 340px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,.1);
            margin: 0 auto;
        }
        .id-card-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .id-card-header .brand {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .id-card-header .subtitle {
            font-size: 0.75rem;
            opacity: .85;
        }
        .id-card-body {
            padding: 24px 20px;
            text-align: center;
        }
        .id-card-body .qr-wrapper {
            display: inline-block;
            padding: 10px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            margin-bottom: 16px;
        }
        .id-card-body .name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }
        .id-card-body .student-id {
            font-family: monospace;
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 12px;
        }
        .id-card-body .info-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.8rem;
            text-align: left;
        }
        .id-card-body .info-row:last-child {
            border-bottom: none;
        }
        .id-card-body .info-row .label {
            color: #64748b;
            font-weight: 500;
        }
        .id-card-body .info-row .value {
            color: #1e293b;
            font-weight: 600;
            text-align: right;
        }
        .id-card-footer {
            background: #f8fafc;
            padding: 12px;
            text-align: center;
            font-size: 0.7rem;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .no-print { display: none !important; }
            .id-card {
                box-shadow: none;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <div class="id-card">

        <div class="id-card-header">
            <div class="brand">📚 Library MS</div>
            <div class="subtitle">Student ID Card</div>
        </div>

        <div class="id-card-body">

            <div class="qr-wrapper">
                {!! DNS2D::getBarcodeSVG(
                    route('librarian.students.qr', $student),
                    'QRCODE',
                    4,
                    4
                ) !!}
            </div>

            <div class="name">{{ $student->name }}</div>
            <div class="student-id">{{ $student->student_id }}</div>

            <div class="info-row">
                <span class="label">Email</span>
                <span class="value">{{ $student->email }}</span>
            </div>
            @if($student->phone)
                <div class="info-row">
                    <span class="label">Phone</span>
                    <span class="value">{{ $student->phone }}</span>
                </div>
            @endif
            @if($student->course)
                <div class="info-row">
                    <span class="label">Course</span>
                    <span class="value">{{ $student->course }}</span>
                </div>
            @endif
            <div class="info-row">
                <span class="label">Status</span>
                <span class="value">{{ ucfirst($student->status) }}</span>
            </div>

        </div>

        <div class="id-card-footer">
            © {{ date('Y') }} Library Management System
        </div>

    </div>

    <div class="no-print text-center mt-4">
        <button onclick="window.print()" class="btn btn-success">
            <i class="bi bi-printer me-1"></i> Print ID Card
        </button>
        <a href="{{ route('librarian.students.index') }}" class="btn btn-light">
            Back
        </a>
    </div>

</body>
</html>