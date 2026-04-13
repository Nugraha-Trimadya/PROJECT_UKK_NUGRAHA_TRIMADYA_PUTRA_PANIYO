@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .item-front {
        margin: 0 -1.5rem;
        min-height: 100vh;
        background: #e6e6e6;
    }

    .item-hero {
        min-height: 210px;
        padding: 20px 34px;
        color: #fff;
        background-image:
            linear-gradient(0deg, rgba(0, 0, 0, 0.42), rgba(0, 0, 0, 0.42)),
            url('https://images.unsplash.com/photo-1464822759844-d150ad6d1fa0?auto=format&fit=crop&w=1800&q=80');
        background-size: cover;
        background-position: center;
    }

    .item-notice-card {
        margin-top: 14px;
        background: #f8fafc;
        color: #22334a;
        border-radius: 0;
        padding: 20px 28px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .item-notice-text {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }

    .item-user-drop {
        border: none;
        background: transparent;
        color: #26384d;
        font-size: 1.55rem;
        font-weight: 600;
    }

    .item-content {
        padding: 26px 40px 30px;
    }

    .item-section-title {
        margin: 0;
        color: #1f3147;
        font-weight: 700;
    }

    .item-subtitle {
        margin: 6px 0 0;
        color: #7b8797;
        font-size: 1.45rem;
    }

    .item-subtitle .accent {
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

    .btn-edit {
        background: #6c43c1;
        border: 0;
        color: #fff;
        font-size: 0.95rem;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
    }

    .item-table-wrap {
        margin-top: 24px;
        border: 1px solid #d8dce2;
        background: #fff;
    }

    .item-table th,
    .item-table td {
        border-color: #dee2e6;
        vertical-align: middle;
        font-size: 1.25rem;
        padding: 18px;
    }

</style>
@endpush

@section('content')
<div class="item-front">
    <div class="item-hero">
        <div class="item-notice-card">
            <p class="item-notice-text">Check menu in sidebar</p>
            <div class="dropdown">
                <button class="item-user-drop dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <div class="item-content">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="item-section-title">Items Table</h3>
                <p class="item-subtitle">Add and export <span class="accent">.items</span></p>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('admin.items.export') }}" class="btn-export">Export Excel</a>
                <a href="{{ route('admin.items.create') }}" class="btn-add"><i class="bi bi-file-earmark-plus-fill"></i> Add</a>
            </div>
        </div>

        <div class="table-responsive item-table-wrap">
            <table class="table mb-0 item-table">
                <thead>
                    <tr>
                        <th style="width: 80px;" class="text-center">#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th style="width: 130px;" class="text-center">Total</th>
                        <th style="width: 130px;" class="text-center">Repair</th>
                        <th style="width: 150px;" class="text-center">Lending</th>
                        <th style="width: 140px;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="text-center">{{ $items->firstItem() + $loop->index }}</td>
                        <td>{{ $item->category?->name }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $item->total }}</td>
                        <td class="text-center">{{ $item->repair }}</td>
                        <td class="text-center">
                            @if($item->active_lending_total > 0)
                                <a href="{{ route('admin.items.lendings', $item) }}">{{ $item->active_lending_total }}</a>
                            @else
                                0
                            @endif
                        </td>
                        <td class="text-center">
                            <a class="btn-edit" href="{{ route('admin.items.edit', $item) }}">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Belum ada data item</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $items->links() }}</div>
    </div>
</div>
@endsection
