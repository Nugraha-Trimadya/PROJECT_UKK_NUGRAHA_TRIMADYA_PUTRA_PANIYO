@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .lend-front {
        margin: 0 -1.5rem;
        min-height: 100vh;
        background: #e6e6e6;
    }

    .lend-hero {
        min-height: 260px;
        padding: 26px 34px;
        color: #fff;
        background-image:
            linear-gradient(0deg, rgba(0, 0, 0, 0.42), rgba(0, 0, 0, 0.42)),
            url('https://images.unsplash.com/photo-1464822759844-d150ad6d1fa0?auto=format&fit=crop&w=1800&q=80');
        background-size: cover;
        background-position: center;
    }

    .lend-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .lend-hero-title {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .lend-date-title {
        font-size: 2.15rem;
        font-weight: 700;
    }

    .lend-notice-card {
        background: #f8fafc;
        color: #22334a;
        border-radius: 0;
        padding: 22px 28px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .lend-notice-text {
        font-size: 1.9rem;
        font-weight: 700;
        margin: 0;
    }

    .lend-user-drop {
        border: none;
        background: transparent;
        color: #26384d;
        font-size: 1.55rem;
        font-weight: 600;
    }

    .lend-content {
        padding: 28px 40px 30px;
    }

    .lend-section-title {
        margin: 0;
        color: #1f3147;
        font-weight: 700;
    }

    .lend-subtitle {
        margin: 6px 0 0;
        color: #7b8797;
        font-size: 1.45rem;
    }

    .lend-subtitle .accent {
        color: #c98eaa;
    }

    .btn-back {
        background: #9aa0a6;
        color: #1f2937;
        border: 0;
        border-radius: 8px;
        font-size: 1.3rem;
        font-weight: 600;
        padding: 10px 26px;
        text-decoration: none;
        display: inline-block;
    }

    .lend-table-wrap {
        margin-top: 24px;
        border: 1px solid #d8dce2;
        background: #fff;
    }

    .lend-table th,
    .lend-table td {
        border-color: #dee2e6;
        vertical-align: middle;
        font-size: 1.25rem;
        padding: 18px;
    }

    .badge-returned {
        background: #e8f8ee;
        color: #1f7a3f;
        border: 1px solid #a6dfbb;
        padding: 6px 10px;
    }

    .badge-not-returned {
        background: #fff9e5;
        color: #d3a41c;
        border: 1px solid #ecd37a;
        padding: 6px 10px;
    }
</style>
@endpush

@section('content')
<div class="lend-front">
    <div class="lend-hero">
        <div class="lend-hero-top">
            <div class="lend-hero-title">
                <i class="bi bi-list"></i>
                <span>Welcome Back, {{ auth()->user()->name }}</span>
            </div>
            <div class="lend-date-title">{{ now()->format('d F, Y') }}</div>
        </div>

        <div class="lend-notice-card">
            <p class="lend-notice-text">Check menu in sidebar</p>
            <div class="dropdown">
                <button class="lend-user-drop dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <div class="lend-content">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="lend-section-title">Lending Table</h3>
                <p class="lend-subtitle">Data of <span class="accent">.lendings</span> - {{ $item->name }}</p>
            </div>
            <a href="{{ route('admin.items.index') }}" class="btn-back">Back</a>
        </div>

        <div class="table-responsive lend-table-wrap">
            <table class="table mb-0 lend-table">
                <thead>
                    <tr>
                        <th style="width: 70px;" class="text-center">#</th>
                        <th>Item</th>
                        <th style="width: 110px;" class="text-center">Total</th>
                        <th>Name</th>
                        <th>Ket.</th>
                        <th>Date</th>
                        <th style="width: 180px;" class="text-center">Returned</th>
                        <th>Edited By</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($details as $detail)
                    <tr>
                        <td class="text-center">{{ $details->firstItem() + $loop->index }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $detail->qty }}</td>
                        <td>{{ $detail->lending?->borrower_name }}</td>
                        <td>{{ $detail->lending?->note ?: '-' }}</td>
                        <td>{{ optional($detail->lending?->lend_date)->translatedFormat('d F, Y') }}</td>
                        <td class="text-center">
                            @if($detail->lending?->return_date)
                                <span class="badge badge-returned">returned</span>
                            @else
                                <span class="badge badge-not-returned">not returned</span>
                            @endif
                        </td>
                        <td><strong>{{ strtolower($detail->lending?->user?->name ?? '-') }}</strong></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">Belum ada data lending untuk item ini</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $details->links() }}</div>
    </div>
</div>
@endsection
