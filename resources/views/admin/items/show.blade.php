@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .detail-front {
        margin: 0 -1.5rem;
        min-height: 100vh;
        background: #e6e6e6;
    }

    .detail-hero {
        min-height: 260px;
        padding: 26px 34px;
        color: #fff;
        background-image:
            linear-gradient(0deg, rgba(0, 0, 0, 0.42), rgba(0, 0, 0, 0.42)),
            url('https://images.unsplash.com/photo-1464822759844-d150ad6d1fa0?auto=format&fit=crop&w=1800&q=80');
        background-size: cover;
        background-position: center;
    }

    .detail-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .detail-hero-title {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .detail-date-title {
        font-size: 2.15rem;
        font-weight: 700;
    }

    .detail-notice-card {
        background: #f8fafc;
        color: #22334a;
        border-radius: 0;
        padding: 22px 28px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .detail-notice-text {
        font-size: 1.9rem;
        font-weight: 700;
        margin: 0;
    }

    .detail-user-drop {
        border: none;
        background: transparent;
        color: #26384d;
        font-size: 1.55rem;
        font-weight: 600;
    }

    .detail-content {
        padding: 28px 40px 30px;
    }

    .detail-section-title {
        margin: 0;
        color: #1f3147;
        font-weight: 700;
    }

    .detail-subtitle {
        margin: 6px 0 0;
        color: #7b8797;
        font-size: 1.45rem;
    }

    .detail-subtitle .accent {
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

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-top: 24px;
    }

    .summary-card {
        background: #fff;
        border: 1px solid #d8dce2;
        border-radius: 12px;
        padding: 18px;
    }

    .summary-label {
        display: block;
        font-size: 0.95rem;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .summary-value {
        font-size: 1.7rem;
        font-weight: 700;
        color: #1f3147;
        margin: 0;
    }

    .detail-table-wrap {
        margin-top: 24px;
        border: 1px solid #d8dce2;
        background: #fff;
    }

    .detail-table th,
    .detail-table td {
        border-color: #dee2e6;
        vertical-align: middle;
        font-size: 1.15rem;
        padding: 16px;
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
<div class="detail-front">
    <div class="detail-hero">
        <div class="detail-hero-top">
            <div class="detail-hero-title">
                <i class="bi bi-box-seam"></i>
                <span>Item Detail</span>
            </div>
            <div class="detail-date-title">{{ now()->format('d F, Y') }}</div>
        </div>

        <div class="detail-notice-card">
            <p class="detail-notice-text">Check menu in sidebar</p>
            <div class="dropdown">
                <button class="detail-user-drop dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <div class="detail-content">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="detail-section-title">{{ $item->name }}</h3>
                <p class="detail-subtitle">Read, update, delete <span class="accent">item information</span></p>
            </div>
            <a href="{{ route('admin.items.index') }}" class="btn-back">Back</a>
        </div>

        <div class="summary-grid">
            <div class="summary-card">
                <span class="summary-label">Category</span>
                <p class="summary-value">{{ $item->category?->name ?? '-' }}</p>
            </div>
            <div class="summary-card">
                <span class="summary-label">Total</span>
                <p class="summary-value">{{ $item->total }}</p>
            </div>
            <div class="summary-card">
                <span class="summary-label">Repair</span>
                <p class="summary-value">{{ $item->repair }}</p>
            </div>
            <div class="summary-card">
                <span class="summary-label">Available</span>
                <p class="summary-value">{{ $item->available }}</p>
            </div>
        </div>

        <div class="table-responsive detail-table-wrap">
            <table class="table mb-0 detail-table">
                <thead>
                    <tr>
                        <th style="width: 70px;" class="text-center">#</th>
                        <th>Total</th>
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
                        <td>{{ $detail->qty }}</td>
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
                    <tr><td colspan="7" class="text-center">Belum ada data lending untuk item ini</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $details->links() }}</div>
    </div>
</div>
@endsection