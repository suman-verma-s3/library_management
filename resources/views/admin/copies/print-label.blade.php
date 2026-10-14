<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Label - {{ $copy->accession_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            text-align: center;
            padding: 40px 20px;
            font-family: system-ui, sans-serif;
            background: #f8fafc;
        }
        .label {
            border: 2px dashed #cbd5e1;
            padding: 30px 40px;
            display: inline-block;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,.05);
        }
        .label .title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1e293b;
        }
        .label .author {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 15px;
        }
        .label .accession {
            font-size: 16px;
            margin-top: 15px;
            font-family: monospace;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: 1px;
        }
        .label svg {
            max-width: 100%;
            height: auto;
        }
        @media print {
            body { background: #fff; padding: 0; }
            .no-print { display: none !important; }
            .label {
                border: none;
                box-shadow: none;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <div class="label">
        <div class="title">{{ $copy->book->title }}</div>
        <div class="author">by {{ $copy->book->author }}</div>

        {{-- Barcode SVG --}}
        <div>
            {!! DNS1D::getBarcodeSVG($copy->accession_number, 'C128', 3, 80) !!}
        </div>

        <div class="accession">{{ $copy->accession_number }}</div>
    </div>

    <div class="no-print mt-4">
        <button onclick="window.print()" class="btn btn-primary">
            🖨️ Print Label
        </button>
        <a href="{{ route('admin.copies.index') }}" class="btn btn-light">
            ← Back to List
        </a>
    </div>

</body>
</html>