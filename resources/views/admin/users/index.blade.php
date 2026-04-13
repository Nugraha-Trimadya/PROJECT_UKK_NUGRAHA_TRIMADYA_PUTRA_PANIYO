@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .user-front {
        margin: 0 -1.5rem;
        min-height: 100vh;
        background: #e6e6e6;
    }

    .user-hero {
        min-height: 260px;
        padding: 26px 34px;
        color: #fff;
        background-image:
            linear-gradient(0deg, rgba(0, 0, 0, 0.42), rgba(0, 0, 0, 0.42)),
            url('https://images.unsplash.com/photo-1464822759844-d150ad6d1fa0?auto=format&fit=crop&w=1800&q=80');
        background-size: cover;
        background-position: center;
    }

    .user-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .user-hero-title {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .user-date-title {
        font-size: 2.15rem;
        font-weight: 700;
    }

    .user-notice-card {
        background: #f8fafc;
        color: #22334a;
        border-radius: 0;
        padding: 22px 28px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .user-notice-text {
        font-size: 1.9rem;
        font-weight: 700;
        margin: 0;
    }

    .user-user-drop {
        border: none;
        background: transparent;
        color: #26384d;
        font-size: 1.55rem;
        font-weight: 600;
    }

    .user-content {
        padding: 28px 40px 30px;
    }

    .user-section-title {
        margin: 0;
        color: #1f3147;
        font-weight: 700;
    }

    .user-subtitle {
        margin: 6px 0 0;
        color: #7b8797;
        font-size: 1.45rem;
    }

    .user-subtitle .accent {
        color: #c98eaa;
    }

    .btn-export {
        background: #6c43c1;
        color: #fff;
        border: 0;
        font-size: 1.3rem;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 20px;
        text-decoration: none;
    }

    .btn-add {
        background: #12d18d;
        color: #0f1f14;
        border: 0;
        font-size: 1.3rem;
        font-weight: 700;
        border-radius: 8px;
        padding: 10px 20px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .user-table-wrap {
        margin-top: 24px;
        border: 1px solid #d8dce2;
        background: #fff;
    }

    .user-table th,
    .user-table td {
        border-color: #dee2e6;
        vertical-align: middle;
        font-size: 1.25rem;
        padding: 18px;
    }

    .btn-edit {
        background: #6c43c1;
        border: 0;
        color: #fff;
        font-size: 1.2rem;
        padding: 9px 22px;
        border-radius: 6px;
        text-decoration: none;
    }

    .btn-delete {
        background: #ff3b30;
        border: 0;
        color: #fff;
        font-size: 1.2rem;
        padding: 9px 22px;
        border-radius: 6px;
    }

    .btn-reset {
        background: #6c757d;
        border: 0;
        color: #fff;
        font-size: 0.95rem;
        padding: 6px 12px;
        border-radius: 6px;
        line-height: 1.2;
        white-space: nowrap;
    }
</style>
@endpush

@section('content')
<div class="user-front">
    <div class="user-hero">
        <div class="user-hero-top">
            <div class="user-hero-title">
                <i class="bi bi-list"></i>
                <span>Welcome Back, {{ auth()->user()->name }}</span>
            </div>
            <div class="user-date-title">{{ now()->format('d F, Y') }}</div>
        </div>

        <div class="user-notice-card">
            <p class="user-notice-text">Check menu in sidebar</p>
            <div class="dropdown">
                <button class="user-user-drop dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <div class="user-content">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="user-section-title">{{ $role === 'admin' ? 'Admin Accounts Table' : 'Staff/Operator Accounts Table' }}</h3>
                <p class="user-subtitle">
                    Add, update, export <span class="accent">.{{ $role === 'admin' ? 'admin-accounts' : 'staff-accounts' }}</span><br>
                    p.s password <strong>4 character of email and nomor.</strong>
                </p>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ $role === 'admin' ? route('admin.users.export-admin') : route('admin.users.export-operator') }}" class="btn-export">Export Excel</a>
                <a href="{{ route('admin.users.create', ['role' => $role]) }}" class="btn-add"><i class="bi bi-file-earmark-plus-fill"></i> Add</a>
            </div>
        </div>

        <div class="table-responsive user-table-wrap">
            <table class="table mb-0 user-table">
                <thead>
                    <tr>
                        <th style="width: 70px;" class="text-center">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th style="width: 310px;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="text-center">{{ $users->firstItem() + $loop->index }}</td>
                        <td>{{ strtolower($user->name) }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-2 align-items-center">
                                <a class="btn-edit" href="{{ route('admin.users.edit', $user) }}">Edit</a>

                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-delete">Delete</button>
                                </form>

                                @if($role === 'operator')
                                    <form method="POST" action="{{ route('admin.users.reset-password', $user) }}">
                                        @csrf
                                        <button class="btn-reset">Reset Password</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Belum ada data user</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $users->links() }}</div>
    </div>
</div>
@endsection
