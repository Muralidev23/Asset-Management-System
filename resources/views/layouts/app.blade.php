<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AssetFlow') }} — Employee & Asset Management</title>
    <meta name="description" content="Professional Employee and Asset Management System — track employees, assets, and assignment history.">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary:       #6366f1;
            --primary-dark:  #4f46e5;
            --primary-light: #a5b4fc;
            --accent:        #06b6d4;
            --success:       #10b981;
            --warning:       #f59e0b;
            --danger:        #ef4444;
            --sidebar-bg:    #0f172a;
            --sidebar-w:     260px;
            --topbar-h:      64px;
            --body-bg:       #f1f5f9;
            --card-bg:       #ffffff;
            --text-main:     #1e293b;
            --text-muted:    #64748b;
            --border:        #e2e8f0;
            --radius:        14px;
            --shadow:        0 4px 24px rgba(0,0,0,.07);
            --shadow-lg:     0 8px 40px rgba(0,0,0,.12);
            --transition:    .22s cubic-bezier(.4,0,.2,1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--body-bg);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ─── SIDEBAR ─────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: transform var(--transition);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 22px 24px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            text-decoration: none;
        }
        .sidebar-brand .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff;
            box-shadow: 0 4px 12px rgba(99,102,241,.4);
        }
        .sidebar-brand .brand-text {
            font-size: 1.15rem;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: -.3px;
        }
        .sidebar-brand .brand-sub {
            font-size: .65rem;
            color: #94a3b8;
            font-weight: 400;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }
        .nav-section-label {
            font-size: .62rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #475569;
            padding: 12px 24px 6px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            color: #94a3b8;
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            border-radius: 0;
            transition: all var(--transition);
            position: relative;
        }
        .sidebar-link:hover {
            color: #f1f5f9;
            background: rgba(255,255,255,.06);
        }
        .sidebar-link.active {
            color: #ffffff;
            background: rgba(99,102,241,.18);
        }
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 4px; bottom: 4px;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: linear-gradient(180deg, var(--primary), var(--accent));
        }
        .sidebar-link .link-icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem;
            background: rgba(255,255,255,.06);
            flex-shrink: 0;
            transition: background var(--transition);
        }
        .sidebar-link.active .link-icon {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
        }
        .sidebar-link:hover .link-icon {
            background: rgba(255,255,255,.1);
        }

        .sidebar-footer {
            border-top: 1px solid rgba(255,255,255,.07);
            padding: 16px 24px;
        }
        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .user-info .user-name  { font-size: .82rem; font-weight: 600; color: #f1f5f9; }
        .user-info .user-role  { font-size: .68rem; color: #64748b; }
        .btn-logout {
            margin-left: auto;
            background: transparent;
            border: none;
            color: #475569;
            font-size: .85rem;
            cursor: pointer;
            transition: color var(--transition);
            padding: 4px 6px;
        }
        .btn-logout:hover { color: var(--danger); }

        /* ─── MAIN CONTENT ────────────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Bar */
        .topbar {
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            position: sticky;
            top: 0; z-index: 900;
            box-shadow: 0 1px 8px rgba(0,0,0,.04);
        }
        .topbar-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-main);
        }
        .topbar-breadcrumb {
            font-size: .78rem;
            color: var(--text-muted);
            margin-top: 1px;
        }
        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar-badge {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            font-size: .7rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        /* Page Content */
        .page-content {
            flex: 1;
            padding: 28px;
        }

        /* ─── CARDS ───────────────────────────────── */
        .card {
            background: var(--card-bg);
            border: none;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 18px 24px;
            font-weight: 600;
            font-size: .95rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-body { padding: 24px; }

        /* Stat Cards */
        .stat-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: transform var(--transition), box-shadow var(--transition);
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
        .stat-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .stat-icon.purple { background: rgba(99,102,241,.12); color: var(--primary); }
        .stat-icon.teal   { background: rgba(6,182,212,.12);  color: var(--accent); }
        .stat-icon.green  { background: rgba(16,185,129,.12); color: var(--success); }
        .stat-icon.amber  { background: rgba(245,158,11,.12); color: var(--warning); }
        .stat-label { font-size: .75rem; font-weight: 500; color: var(--text-muted); text-transform: uppercase; letter-spacing: .06em; }
        .stat-value { font-size: 1.9rem; font-weight: 700; color: var(--text-main); line-height: 1; margin-top: 4px; }
        .stat-link { font-size: .75rem; color: var(--primary); text-decoration: none; margin-top: 6px; display: inline-block; font-weight: 500; }
        .stat-link:hover { text-decoration: underline; }

        /* ─── TABLES ──────────────────────────────── */
        .table-card { border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); }
        .table { margin: 0; vertical-align: middle; }
        .table thead th {
            background: #f8fafc;
            font-size: .72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            padding: 14px 16px;
            white-space: nowrap;
        }
        .table tbody td {
            font-size: .875rem;
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-main);
        }
        .table tbody tr:last-child td { border-bottom: none; }
        .table-hover tbody tr:hover { background: #f8fafc; }
        .table tbody tr { transition: background var(--transition); }

        /* ─── BADGES ──────────────────────────────── */
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .03em;
        }
        .badge-available { background: rgba(16,185,129,.12); color: #065f46; }
        .badge-assigned  { background: rgba(99,102,241,.12); color: #3730a3; }
        .badge-admin     { background: rgba(245,158,11,.12); color: #92400e; }
        .badge-employee  { background: rgba(6,182,212,.12);  color: #164e63; }

        /* ─── BUTTONS ─────────────────────────────── */
        .btn {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: .85rem;
            border-radius: 9px;
            transition: all var(--transition);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color: #fff;
            box-shadow: 0 4px 12px rgba(99,102,241,.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), #3730a3);
            box-shadow: 0 6px 18px rgba(99,102,241,.4);
            transform: translateY(-1px);
        }
        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
        }
        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
        }
        .btn-success {
            background: linear-gradient(135deg, var(--success), #059669);
            border: none;
            color: #fff;
        }
        .btn-success:hover { background: linear-gradient(135deg, #059669, #047857); transform: translateY(-1px); }
        .btn-outline-danger { border-color: var(--danger); color: var(--danger); }
        .btn-outline-danger:hover { background: var(--danger); border-color: var(--danger); }
        .btn-outline-info { border-color: var(--accent); color: var(--accent); }
        .btn-outline-info:hover { background: var(--accent); border-color: var(--accent); color: #fff; }
        .btn-outline-warning { border-color: var(--warning); color: var(--warning); }
        .btn-outline-warning:hover { background: var(--warning); border-color: var(--warning); color: #fff; }
        .btn-ghost {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-muted);
        }
        .btn-ghost:hover { background: var(--body-bg); color: var(--text-main); }

        .btn-sm { font-size: .78rem; padding: .3rem .65rem; border-radius: 7px; }
        .btn-lg { font-size: .95rem; padding: .75rem 1.75rem; border-radius: 11px; }

        /* ─── FORMS ───────────────────────────────── */
        .form-label { font-size: .82rem; font-weight: 500; color: var(--text-main); margin-bottom: 6px; }
        .form-control, .form-select {
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-size: .875rem;
            font-family: 'Poppins', sans-serif;
            padding: .55rem .85rem;
            transition: border-color var(--transition), box-shadow var(--transition);
            color: var(--text-main);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99,102,241,.15);
            outline: none;
        }
        .input-group-text {
            background: #f8fafc;
            border: 1.5px solid var(--border);
            border-radius: 9px 0 0 9px;
            color: var(--text-muted);
        }
        .input-group .form-control { border-radius: 0 9px 9px 0; }

        /* ─── PAGE HEADER ─────────────────────────── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -.3px;
            margin: 0;
        }
        .page-header p { font-size: .85rem; color: var(--text-muted); margin: 4px 0 0; }

        /* ─── ALERTS ──────────────────────────────── */
        .alert {
            border: none;
            border-radius: 10px;
            font-size: .875rem;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: rgba(16,185,129,.1); color: #065f46; }
        .alert-danger  { background: rgba(239,68,68,.08);  color: #991b1b; }
        .alert-warning { background: rgba(245,158,11,.1);  color: #92400e; }

        /* ─── EMPTY STATE ─────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state .empty-icon {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: var(--body-bg);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--text-muted);
        }
        .empty-state h5 { font-size: 1rem; font-weight: 600; margin-bottom: 6px; }
        .empty-state p  { font-size: .85rem; color: var(--text-muted); max-width: 340px; margin: 0 auto 20px; }

        /* ─── MOBILE OVERLAY ──────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 999;
        }
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.25rem;
            color: var(--text-main);
            margin-right: 4px;
        }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay { display: block; opacity: 0; pointer-events: none; transition: opacity .25s; }
            .sidebar-overlay.open { opacity: 1; pointer-events: all; }
            .main-wrapper { margin-left: 0; }
            .mobile-toggle { display: block; }
            .page-content { padding: 18px; }
        }

        /* ─── MISC ────────────────────────────────── */
        .text-primary { color: var(--primary) !important; }
        .text-accent  { color: var(--accent)  !important; }
        .fw-semibold  { font-weight: 600; }
        .rounded-pill-custom { border-radius: 20px; }
        code { background: #f1f5f9; padding: 2px 7px; border-radius: 5px; font-size: .8rem; color: #4f46e5; }

        /* Scrollbar */
        ::-webkit-scrollbar       { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        /* Fade-in animation */
        @keyframes fadeUp { from { opacity:0; transform: translateY(16px); } to { opacity:1; transform: none; } }
        .fade-up { animation: fadeUp .4s ease forwards; }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- ─── SIDEBAR ──────────────────────────── -->
    <aside class="sidebar" id="sidebar">
        <a class="sidebar-brand" href="{{ url('/') }}">
            <div class="brand-icon"><i class="fa-solid fa-layer-group"></i></div>
            <div>
                <div class="brand-text">AssetFlow</div>
                <div class="brand-sub">Management System</div>
            </div>
        </a>

        <nav class="sidebar-nav">
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="nav-section-label">Overview</div>
                    <a href="{{ route('admin.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="link-icon"><i class="fa-solid fa-chart-pie"></i></span>
                        Dashboard
                    </a>

                    <div class="nav-section-label">Employees</div>
                    <a href="{{ route('employees.index') }}"
                       class="sidebar-link {{ request()->routeIs('employees.index') || request()->routeIs('employees.show') || request()->routeIs('employees.edit') || request()->routeIs('employees.create') ? 'active' : '' }}">
                        <span class="link-icon"><i class="fa-solid fa-users"></i></span>
                        All Employees
                    </a>
                    <a href="{{ route('employees.upload') }}"
                       class="sidebar-link {{ request()->routeIs('employees.upload') ? 'active' : '' }}">
                        <span class="link-icon"><i class="fa-solid fa-file-arrow-up"></i></span>
                        Bulk Upload
                    </a>

                    <div class="nav-section-label">Assets</div>
                    <a href="{{ route('assets.index') }}"
                       class="sidebar-link {{ request()->routeIs('assets.*') ? 'active' : '' }}">
                        <span class="link-icon"><i class="fa-solid fa-laptop"></i></span>
                        Assets Inventory
                    </a>
                @else
                    <div class="nav-section-label">Overview</div>
                    <a href="{{ route('employee.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                        <span class="link-icon"><i class="fa-solid fa-house"></i></span>
                        My Dashboard
                    </a>
                @endif
            @endauth
        </nav>

        @auth
        <div class="sidebar-footer">
            <div class="user-pill">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-logout" title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </aside>

    <!-- ─── MAIN ────────────────────────────────── -->
    <div class="main-wrapper">

        <!-- Top Bar -->
        <header class="topbar">
            <button class="mobile-toggle" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-breadcrumb">@yield('breadcrumb', 'Home')</div>
            </div>
            <div class="topbar-right">
                @auth
                <span class="topbar-badge">{{ ucfirst(Auth::user()->role) }}</span>
                @endauth
            </div>
        </header>

        <!-- Content -->
        <main class="page-content fade-up">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible mb-4" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('open');
        }
    </script>
    @stack('scripts')
</body>
</html>
