@extends('layouts.admin')

@section('title', 'Analytics')
@section('page-title', 'Analytics & Insights')

@section('content')

{{-- ═══════════ Overview Cards ═══════════ --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10 text-primary mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-book"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['total_books'] }}</h4>
            <small class="text-muted">Total Books</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-info bg-opacity-10 text-info mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-collection"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['total_copies'] }}</h4>
            <small class="text-muted">Physical Copies</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-success bg-opacity-10 text-success mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-people"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['total_students'] }}</h4>
            <small class="text-muted">Students</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-warning bg-opacity-10 text-warning mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-journal-arrow-up"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['active_issues'] }}</h4>
            <small class="text-muted">Currently Issued</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-danger bg-opacity-10 text-danger mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['overdue'] }}</h4>
            <small class="text-muted">Overdue</small>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
            <div class="d-flex align-items-center justify-content-center rounded-3 bg-secondary bg-opacity-10 text-secondary mb-2"
                 style="width:44px;height:44px;font-size:1.2rem;">
                <i class="bi bi-check2-circle"></i>
            </div>
            <h4 class="fw-bold mb-0">{{ $stats['available'] }}</h4>
            <small class="text-muted">Available</small>
        </div>
    </div>

</div>

{{-- ═══════════ Row 1: Bar + Doughnut ═══════════ --}}
<div class="row g-3 mb-4">

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-bar-chart me-2 text-primary"></i>
                    Books Issued — Last 6 Months
                </h6>
            </div>
            <div class="card-body">
                <canvas id="monthlyIssuesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-pie-chart me-2 text-info"></i>
                    Copy Status
                </h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="copyStatusChart" style="max-height: 260px;"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════ Row 2: Line + Category Doughnut ═══════════ --}}
<div class="row g-3 mb-4">

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-graph-up me-2 text-success"></i>
                    Students Joined — Last 6 Months
                </h6>
            </div>
            <div class="card-body">
                <canvas id="studentsChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-diagram-3 me-2 text-warning"></i>
                    Books per Category (Top 8)
                </h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="categoryChart" style="max-height: 260px;"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════ Row 3: Top Books + Top Students ═══════════ --}}
<div class="row g-3">

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-trophy me-2 text-primary"></i>
                    Top 5 Most Issued Books
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Book</th>
                            <th class="text-center">Issues</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topBooks as $i => $book)
                            <tr>
                                <td><span class="badge bg-primary">{{ $i + 1 }}</span></td>
                                <td>
                                    <div class="fw-medium">{{ $book->title }}</div>
                                    <small class="text-muted">{{ $book->author }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary fs-6">
                                        {{ $book->total_issues }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No data yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-person-star me-2 text-success"></i>
                    Top 5 Active Students
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Student</th>
                            <th class="text-center">Issues</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topStudents as $i => $student)
                            <tr>
                                <td><span class="badge bg-success">{{ $i + 1 }}</span></td>
                                <td>
                                    <div class="fw-medium">{{ $student->name }}</div>
                                    <small class="text-muted">{{ $student->student_id }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success fs-6">
                                        {{ $student->issues_count }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No data yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════ Chart.js ═══════════ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1. Monthly Issues — Bar
    new Chart(document.getElementById('monthlyIssuesChart'), {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Books Issued',
                data: @json($issueCounts),
                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    // 2. Copy Status — Doughnut
    new Chart(document.getElementById('copyStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Issued', 'Damaged', 'Lost'],
            datasets: [{
                data: [
                    {{ $copyStatus['available'] }},
                    {{ $copyStatus['issued'] }},
                    {{ $copyStatus['damaged'] }},
                    {{ $copyStatus['lost'] }}
                ],
                backgroundColor: ['#10b981', '#f59e0b', '#64748b', '#ef4444'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // 3. Students Joined — Line
    new Chart(document.getElementById('studentsChart'), {
        type: 'line',
        data: {
            labels: @json($studentMonths),
            datasets: [{
                label: 'Students Joined',
                data: @json($studentCounts),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.3,
                fill: true,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    // 4. Category Breakdown — Doughnut
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($categoryNames),
            datasets: [{
                data: @json($categoryCounts),
                backgroundColor: [
                    '#4f46e5', '#10b981', '#f59e0b', '#ef4444',
                    '#0ea5e9', '#8b5cf6', '#ec4899', '#64748b'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

});
</script>

@endsection