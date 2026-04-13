<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventaris') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        :root {
            --app-bg: #f4f6fa;
            --surface: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --line: #e5e7eb;
            --nav-bg: #253b8f;
            --nav-bg-hover: #1d327e;
            --radius: 12px;
        }

        body {
            background: var(--app-bg);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
        }

        main {
            padding-top: 1.25rem;
        }

        .sidebar {
            min-height: 100vh;
            background: #0f172a;
            color: #e2e8f0;
        }
        .sidebar .nav-link { color: #cbd5e1; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { color: #fff; background: #1e293b; border-radius: .5rem; }
        .brand { color: #fff; font-weight: 700; letter-spacing: .04em; }
        .topbar { background: white; border-bottom: 1px solid #e5e7eb; }

        .admin-sidebar {
            background: var(--nav-bg);
            color: #fff;
            padding: 0;
        }

        .admin-sidebar .sidebar-title {
            padding: 22px 24px 10px;
            font-size: 1.9rem;
            font-weight: 700;
            letter-spacing: .05em;
        }

        .admin-sidebar .section-label {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.88rem;
            padding: 16px 20px 8px;
        }

        .admin-sidebar .nav-link {
            border-radius: 0;
            padding: 11px 18px;
            color: #fff;
            font-size: 0.98rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-sidebar .nav-link.active,
        .admin-sidebar .nav-link:hover {
            background: var(--nav-bg-hover);
            color: #fff;
        }

        .card,
        .table-responsive,
        .alert,
        .dropdown-menu {
            border-radius: var(--radius);
            border-color: var(--line);
        }

        .table {
            --bs-table-bg: transparent;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        input.form-control,
        select.form-select {
            min-height: 42px;
            font-size: 0.95rem;
        }

        textarea.form-control {
            min-height: 110px;
            font-size: 0.95rem;
        }

        /* Global simplification for old oversized page styles */
        [class*='-front'] {
            margin: 0 !important;
            min-height: auto !important;
            background: transparent !important;
        }

        [class*='-hero'] {
            min-height: auto !important;
            padding: 16px 20px !important;
            color: var(--text-main) !important;
            background: var(--surface) !important;
            background-image: none !important;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            margin-bottom: 14px;
        }

        [class*='-hero-top'] {
            margin-bottom: 14px !important;
            gap: 12px;
            flex-wrap: wrap;
        }

        [class*='-hero-title'],
        [class*='-date-title'],
        .date-title {
            font-size: 1.2rem !important;
            font-weight: 700 !important;
            color: var(--text-main) !important;
        }

        [class*='menu-icon'],
        .menu-icon {
            font-size: 1.05rem !important;
        }

        [class*='-notice-card'],
        .notice-card {
            background: #f9fafb !important;
            border: 1px solid var(--line);
            border-radius: 10px !important;
            padding: 12px 14px !important;
            box-shadow: none !important;
        }

        [class*='-notice-text'],
        .notice-text {
            font-size: 0.98rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
            color: var(--text-main) !important;
        }

        [class*='-user-drop'],
        .user-drop {
            font-size: 0.95rem !important;
            color: var(--text-main) !important;
        }

        [class*='-content'] {
            padding: 10px 2px 18px !important;
        }

        [class*='-section-title'] {
            font-size: 1.35rem !important;
            font-weight: 700 !important;
            color: var(--text-main) !important;
        }

        [class*='-subtitle'] {
            font-size: 0.95rem !important;
            color: var(--text-muted) !important;
        }

        .btn-export,
        .btn-add,
        .btn-submit-user,
        .btn-cancel-user,
        .btn-edit,
        .btn-delete,
        .btn-returned {
            font-size: 0.92rem !important;
            padding: 0.5rem 0.9rem !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
        }

        .op-lending-table th,
        .op-lending-table td,
        .item-table th,
        .item-table td,
        .cat-table th,
        .cat-table td,
        .user-table th,
        .user-table td {
            font-size: 0.95rem !important;
            padding: 0.75rem !important;
        }

        .badge {
            font-weight: 600;
            font-size: 0.8rem;
        }

        @media (max-width: 992px) {
            .admin-sidebar .nav-link {
                padding: 10px 14px;
                font-size: 0.92rem;
            }

            .admin-sidebar .sidebar-title {
                font-size: 1.35rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
@php
    $hideTopbar = trim($__env->yieldContent('hideTopbar')) === '1';
@endphp
<div class="container-fluid">
    <div class="row">
        @auth
            <aside class="col-md-3 col-lg-2 d-md-block sidebar {{ auth()->user()->isAdmin() || auth()->user()->isOperator() ? 'admin-sidebar' : 'p-3' }}">
                @if(auth()->user()->isAdmin())
                    <div class="sidebar-title">Menu</div>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    </ul>

                    <div class="section-label">Items Data</div>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-list-stars"></i> Categories</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.items.*') ? 'active' : '' }}" href="{{ route('admin.items.index') }}"><i class="bi bi-pie-chart-fill"></i> Items</a></li>
                    </ul>

                    <div class="section-label">Accounts</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.admin') || request()->routeIs('admin.users.operator') ? 'active' : '' }}"
                               data-bs-toggle="collapse"
                               href="#usersSubmenu"
                               role="button"
                               aria-expanded="{{ request()->routeIs('admin.users.admin') || request()->routeIs('admin.users.operator') ? 'true' : 'false' }}"
                               aria-controls="usersSubmenu">
                                <i class="bi bi-person-fill"></i> Users
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>

                            <div class="collapse {{ request()->routeIs('admin.users.admin') || request()->routeIs('admin.users.operator') ? 'show' : '' }}" id="usersSubmenu">
                                <ul class="nav flex-column ps-4 pb-2">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.users.admin') ? 'active' : '' }}" href="{{ route('admin.users.admin') }}">
                                            <i class="bi bi-dot"></i> Admin
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.users.operator') ? 'active' : '' }}" href="{{ route('admin.users.operator') }}">
                                            <i class="bi bi-dot"></i> Operator
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                @elseif(auth()->user()->isOperator())
                    <div class="sidebar-title">Menu</div>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}" href="{{ route('operator.dashboard') }}"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    </ul>

                    <div class="section-label">Items Data</div>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('operator.items.*') ? 'active' : '' }}" href="{{ route('operator.items.index') }}"><i class="bi bi-pie-chart-fill"></i> Items</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('operator.lendings.*') ? 'active' : '' }}" href="{{ route('operator.lendings.index') }}"><i class="bi bi-arrow-repeat"></i> Lending</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('operator.users.edit') ? 'active' : '' }}" href="{{ route('operator.users.edit', auth()->id()) }}"><i class="bi bi-person-fill"></i> Users <i class="bi bi-chevron-right ms-auto"></i></a></li>
                    </ul>
                @else
                    <div class="brand mb-4">INVENTARIS APP</div>
                    <ul class="nav flex-column gap-1">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}" href="{{ route('operator.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('operator.lendings.*') ? 'active' : '' }}" href="{{ route('operator.lendings.index') }}">Lending</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('operator.items.*') ? 'active' : '' }}" href="{{ route('operator.items.index') }}">Items</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('operator.users.edit') ? 'active' : '' }}" href="{{ route('operator.users.edit', auth()->id()) }}">Users</a></li>
                    </ul>
                @endif
            </aside>
        @endauth

        <main class="@auth col-md-9 ms-sm-auto col-lg-10 @else col-12 @endauth px-md-4 pb-4">
            @if (!$hideTopbar)
                <div class="topbar py-3 mb-4 d-flex justify-content-between align-items-center px-2 px-md-3">
                    <div>
                        <strong>{{ auth()->check() ? strtoupper(auth()->user()->role) : 'GUEST' }}</strong>
                    </div>
                    @auth
                        <div class="d-flex align-items-center gap-2">
                            <span>{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger">Logout</button>
                            </form>
                        </div>
                    @endauth
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('generated_password'))
                <div class="alert alert-warning">{{ session('generated_password') }}</div>
                <script>
                    alert(@json(session('generated_password')));
                </script>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stack('scripts')
</body>
</html>
