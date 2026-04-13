@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .admin-front {
        margin: 0 -1.5rem;
        min-height: 100vh;
        background: #e6e6e6;
    }

    .admin-hero {
        min-height: 390px;
        padding: 34px;
        color: #fff;
        background-image:
            linear-gradient(0deg, rgba(0, 0, 0, 0.42), rgba(0, 0, 0, 0.42)),
            url('https://images.unsplash.com/photo-1464822759844-d150ad6d1fa0?auto=format&fit=crop&w=1800&q=80');
        background-size: cover;
        background-position: center;
    }

    .admin-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 56px;
    }

    .admin-hero-title {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 2.65rem;
        font-weight: 700;
    }

    .menu-icon {
        font-size: 2rem;
    }

    .date-title {
        font-size: 2.15rem;
        font-weight: 700;
    }

    .notice-card {
        background: #f8fafc;
        color: #22334a;
        border-radius: 0;
        padding: 28px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notice-text {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .user-drop {
        border: none;
        background: transparent;
        color: #26384d;
        font-size: 1.7rem;
        font-weight: 600;
    }

    .user-drop i {
        font-size: 1.8rem;
    }

    .stat-strip {
        margin-top: 22px;
    }

    .stat-card {
        border: none;
        border-radius: 0;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
    }

    .stat-card .card-body {
        padding: 20px;
    }
</style>
@endpush

@section('content')
<div class="admin-front">
    <div class="admin-hero">
        <div class="admin-hero-top">
            <div class="admin-hero-title">
                <i class="bi bi-list menu-icon"></i>
                <span>Welcome Back, {{ auth()->user()->name }}</span>
            </div>
            <div class="date-title">{{ now()->format('d F, Y') }}</div>
        </div>

        <div class="notice-card">
            <p class="notice-text">Check menu in sidebar</p>
            <div class="dropdown">
                <button class="user-drop dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2"></i>
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end p-3" style="min-width: 220px;">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item fs-5"><i class="bi bi-box-arrow-right me-2 text-primary"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4 stat-strip">
        <div class="row g-3 pb-4">
            <div class="col-md-3"><div class="card stat-card"><div class="card-body"><h6>Total Users</h6><h3>{{ $totalUsers }}</h3></div></div></div>
            <div class="col-md-3"><div class="card stat-card"><div class="card-body"><h6>Total Categories</h6><h3>{{ $totalCategories }}</h3></div></div></div>
            <div class="col-md-3"><div class="card stat-card"><div class="card-body"><h6>Total Items</h6><h3>{{ $totalItems }}</h3></div></div></div>
            <div class="col-md-3"><div class="card stat-card"><div class="card-body"><h6>Active Lending</h6><h3>{{ $activeLendings }}</h3></div></div></div>
        </div>
    </div>
</div>
@endsection
