@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .cat-front {
        margin: 0 -1.5rem;
        min-height: 100vh;
        background: #e6e6e6;
    }

    .cat-hero {
        min-height: 390px;
        padding: 34px;
        color: #fff;
        background-image:
            linear-gradient(0deg, rgba(0, 0, 0, 0.42), rgba(0, 0, 0, 0.42)),
            url('https://images.unsplash.com/photo-1464822759844-d150ad6d1fa0?auto=format&fit=crop&w=1800&q=80');
        background-size: cover;
        background-position: center;
    }

    .cat-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 56px;
    }

    .cat-hero-title {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 2.65rem;
        font-weight: 700;
    }

    .cat-menu-icon {
        font-size: 2rem;
    }

    .cat-date-title {
        font-size: 2.15rem;
        font-weight: 700;
    }

    .cat-notice-card {
        background: #f8fafc;
        color: #22334a;
        border-radius: 0;
        padding: 28px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cat-notice-text {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .cat-user-drop {
        border: none;
        background: transparent;
        color: #26384d;
        font-size: 1.7rem;
        font-weight: 600;
    }

    .cat-user-drop i {
        font-size: 1.8rem;
    }

    .cat-content {
        padding: 26px 40px 30px;
    }

    .cat-section-title {
        margin: 0;
        color: #1f3147;
        font-weight: 700;
    }

    .cat-subtitle {
        margin: 6px 0 0;
        color: #7b8797;
        font-size: 1.45rem;
    }

    .cat-subtitle .accent {
        color: #c98eaa;
    }

    .btn-add {
        background: #12d18d;
        color: #0f1f14;
        border: 0;
        font-size: 1.6rem;
        font-weight: 700;
        border-radius: 8px;
        padding: 10px 26px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-export {
        background: #6c43c1;
        color: #fff;
        border: 0;
        font-size: 1.6rem;
        font-weight: 700;
        border-radius: 8px;
        padding: 10px 26px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .cat-table-wrap {
        margin-top: 24px;
        border: 1px solid #d8dce2;
        background: #fff;
    }

    .cat-table th,
    .cat-table td {
        border-color: #dee2e6;
        vertical-align: middle;
        font-size: 1.35rem;
        padding: 20px;
    }

    .btn-edit {
        background: #6c43c1;
        border: 0;
        color: #fff;
        font-size: 1.3rem;
        padding: 10px 26px;
        border-radius: 6px;
        text-decoration: none;
    }

    .btn-delete {
        background: #ff3b30;
        border: 0;
        color: #fff;
        font-size: 1.3rem;
        padding: 10px 26px;
        border-radius: 6px;
    }
</style>
@endpush

@section('content')
<div class="cat-front">
    <div class="cat-hero">
        <div class="cat-hero-top">
            <div class="cat-hero-title">
                <i class="bi bi-list cat-menu-icon"></i>
                <span>Welcome Back, {{ auth()->user()->name }}</span>
            </div>
        </div>

        <div class="cat-notice-card">
            <p class="cat-notice-text">Check menu in sidebar</p>
            <div class="dropdown">
                <button class="cat-user-drop dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <div class="cat-content">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="cat-section-title">Categories Table</h3>
                <p class="cat-subtitle">Add, update, export <span class="accent">.categories</span></p>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('admin.categories.export') }}" class="btn-export"><i class="bi bi-download"></i> Export Excel</a>
                <a href="{{ route('admin.categories.create') }}" class="btn-add"><i class="bi bi-file-earmark-plus-fill"></i> Add</a>
            </div>
        </div>

        <div class="table-responsive cat-table-wrap">
            <table class="table mb-0 cat-table">
                <thead>
                    <tr>
                        <th style="width: 90px;" class="text-center">#</th>
                        <th>Name</th>
                        <th>Division PJ</th>
                        <th style="width: 190px;">Total Items</th>
                        <th style="width: 320px;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="text-center">{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description ?: '-' }}</td>
                            <td class="text-center">{{ $category->items_count }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-2 align-items-center flex-wrap justify-content-center">
                                    <a class="btn-edit" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-delete" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Belum ada data kategori</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $categories->links() }}</div>
    </div>
</div>
@endsection
