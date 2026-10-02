<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Library MS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f1f5f9;
            font-family: system-ui, sans-serif;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1e293b;
            color: #cbd5e1;
            position: fixed;
            top: 0;
            left: 0;
            transition: transform .25s ease;
            z-index: 1040;
        }

        .sidebar .brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #334155;
            font-weight: 700;
            color: #fff;
            font-size: 1.15rem;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: .75rem 1.5rem;
            border-left: 3px solid transparent;
            font-size: .95rem;
        }

        .sidebar .nav-link:hover {
            background: #334155;
            color: #fff;
        }

        .sidebar .nav-link.active {
            background: #334155;
            color: #fff;
            border-left-color: #6366f1;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .sidebar .section-label {
            padding: 1rem 1.5rem .35rem;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
        }

        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .content {
            padding: 1.5rem;
        }

        .stat-card {
            border: none;
            border-radius: .75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
            transition: transform .15s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }
        }

        .backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            z-index: 1030;
        }

        .backdrop.show {
            display: block;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="brand d-flex justify-content-between align-items-center">
            <span>📚 Library MS</span>
            <button type="button" class="btn btn-sm text-white d-lg-none p-1" id="sidebarClose"
                aria-label="Close sidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="section-label">Main Menu</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                href="{{ route('admin.categories.index') }}">
                <i class="bi bi-tags"></i> Categories
            </a>
            <a class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}"
                href="{{ route('admin.books.index') }}">
                <i class="bi bi-book"></i> Books
            </a>
            <a class="nav-link {{ request()->routeIs('admin.copies.*') ? 'active' : '' }}"
                href="{{ route('admin.copies.index') }}">
                <i class="bi bi-collection"></i> Physical Copies
            </a>
        </nav>

        <div class="section-label">Reports</div>
<nav class="nav flex-column">
    <a class="nav-link {{ request()->routeIs('reports.issued') ? 'active' : '' }}"
       href="{{ route('reports.issued') }}">
        <i class="bi bi-journal-arrow-up"></i> Issued
    </a>
    <a class="nav-link {{ request()->routeIs('reports.overdue') ? 'active' : '' }}"
       href="{{ route('reports.overdue') }}">
        <i class="bi bi-exclamation-triangle"></i> Overdue
    </a>
    <a class="nav-link {{ request()->routeIs('reports.students') || request()->routeIs('reports.studentHistory') ? 'active' : '' }}"
       href="{{ route('reports.students') }}">
        <i class="bi bi-clock-history"></i> Students
    </a>
    <a class="nav-link {{ request()->routeIs('reports.inventory') ? 'active' : '' }}"
       href="{{ route('reports.inventory') }}">
        <i class="bi bi-box-seam"></i> Inventory
    </a>
</nav>

        <div class="section-label">Account</div>
        <nav class="nav flex-column mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-link btn btn-link text-start w-100 border-0">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    <div class="backdrop" id="backdrop"></div>

    <!-- Main -->
    <div class="main">
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small d-none d-md-inline">
                    {{ auth()->user()->name }}
                </span>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                    style="width:36px;height:36px;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('backdrop');
        const toggle = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        toggle?.addEventListener('click', () => {
            sidebar.classList.add('show');
            backdrop.classList.add('show');
        });

        backdrop.addEventListener('click', () => {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
        });

        closeBtn?.addEventListener('click', () => {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
        });
    </script>
</body>

</html>
