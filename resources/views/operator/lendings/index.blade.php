@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .op-lending-front {
        margin: 0 -1.5rem;
        min-height: 100vh;
        background: #e6e6e6;
    }

    .op-lending-hero {
        min-height: 300px;
        padding: 26px 34px;
        color: #fff;
        background-image:
            linear-gradient(0deg, rgba(0, 0, 0, 0.42), rgba(0, 0, 0, 0.42)),
            url('https://images.unsplash.com/photo-1464822759844-d150ad6d1fa0?auto=format&fit=crop&w=1800&q=80');
        background-size: cover;
        background-position: center;
    }

    .op-lending-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .op-lending-hero-title {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .op-lending-date-title {
        font-size: 2.15rem;
        font-weight: 700;
    }

    .op-lending-notice-card {
        background: #f8fafc;
        color: #22334a;
        border-radius: 0;
        padding: 22px 28px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .op-lending-notice-text {
        font-size: 1.9rem;
        font-weight: 700;
        margin: 0;
    }

    .op-lending-user-drop {
        border: none;
        background: transparent;
        color: #26384d;
        font-size: 1.55rem;
        font-weight: 600;
    }

    .op-lending-content {
        padding: 28px 40px 30px;
    }

    .op-lending-section-title {
        margin: 0;
        color: #1f3147;
        font-weight: 700;
    }

    .op-lending-subtitle {
        margin: 6px 0 0;
        color: #7b8797;
        font-size: 1.45rem;
    }

    .op-lending-subtitle .accent {
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

    .op-lending-table-wrap {
        margin-top: 24px;
        border: 1px solid #d8dce2;
        background: #fff;
    }

    .op-lending-table th,
    .op-lending-table td {
        border-color: #dee2e6;
        vertical-align: middle;
        font-size: 1.2rem;
        padding: 16px;
    }

    .badge-not-returned {
        background: #fff9e5;
        color: #d3a41c;
        border: 1px solid #ecd37a;
        padding: 5px 10px;
    }

    .badge-returned {
        background: #e8f8ee;
        color: #1f7a3f;
        border: 1px solid #a6dfbb;
        padding: 5px 10px;
    }

    .btn-returned {
        background: #f7bf2f;
        border: 0;
        color: #1f2937;
        font-size: 1.15rem;
        padding: 9px 16px;
        border-radius: 6px;
    }

    .btn-delete {
        background: #ff3b30;
        border: 0;
        color: #fff;
        font-size: 1.15rem;
        padding: 9px 16px;
        border-radius: 6px;
    }
</style>
@endpush

@section('content')
<div class="op-lending-front">
    {{-- Hero dan identitas halaman peminjaman operator. --}}
    <div class="op-lending-hero">
        <div class="op-lending-hero-top">
            <div class="op-lending-hero-title">
                <i class="bi bi-list"></i>
                <span>Welcome Back, {{ auth()->user()->name }}</span>
            </div>
            <div class="op-lending-date-title">{{ now()->format('d F, Y') }}</div>
        </div>

        {{-- Kartu ringkas dengan aksi logout. --}}
        <div class="op-lending-notice-card">
            <p class="op-lending-notice-text">Check menu in sidebar</p>
            <div class="dropdown">
                <button class="op-lending-user-drop dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2"></i>
                    {{ auth()->user()->name }}
                </button>
                {{-- Menu logout cepat. --}}
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

    <div class="op-lending-content">
        {{-- Tombol aksi utama untuk export dan tambah data. --}}
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="op-lending-section-title">Lending Table</h3>
                <p class="op-lending-subtitle">Data of <span class="accent">.lendings</span></p>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('operator.lendings.export') }}" class="btn-export">Export Excel</a>
                <a href="{{ route('operator.lendings.create') }}" class="btn-add"><i class="bi bi-file-earmark-plus-fill"></i> Add</a>
            </div>
        </div>

        @if (session('success'))
            {{-- Notifikasi sukses setelah aksi create/update/delete. --}}
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        {{-- Tabel data lending beserta detail item per transaksi. --}}
        @php $rowNo = ($lendings->currentPage() - 1) * $lendings->perPage() + 1; @endphp
        <div class="table-responsive op-lending-table-wrap">
            <table class="table mb-0 op-lending-table">
                <thead>
                    <tr>
                        <th style="width: 70px;" class="text-center">#</th>
                        <th>Item</th>
                        <th style="width: 110px;" class="text-center">Total</th>
                        <th>Name</th>
                        <th>Ket.</th>
                        <th>Date</th>
                        <th style="width: 170px;" class="text-center">Returned</th>
                        <th>Edited By</th>
                        <th style="width: 240px;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($lendings as $lending)
                    @foreach($lending->details as $detail)
                        <tr>
                            <td class="text-center">{{ $rowNo++ }}</td>
                            <td>{{ $detail->item?->name }}</td>
                            <td class="text-center">{{ $detail->qty }}</td>
                            <td>{{ $lending->borrower_name }}</td>
                            <td>{{ $lending->note ?: '-' }}</td>
                            <td>{{ optional($lending->lend_date)->translatedFormat('d F, Y') }}</td>
                            <td class="text-center">
                                @if($lending->return_date)
                                    <span class="badge badge-returned">{{ $lending->return_date->translatedFormat('d F, Y') }}</span>
                                @else
                                    <span class="badge badge-not-returned">not returned</span>
                                @endif
                            </td>
                            <td><strong>{{ strtolower($lending->user?->name ?? '-') }}</strong></td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-2">
                                    {{-- Tombol menandai barang sudah dikembalikan. --}}
                                    @if(!$lending->return_date)
                                        <form method="POST" action="{{ route('operator.lendings.returned', $lending) }}">
                                            @csrf
                                            <button class="btn-returned">Returned</button>
                                        </form>
                                    @endif
                                    {{-- Tombol hapus data lending. --}}
                                    <form method="POST" action="{{ route('operator.lendings.destroy', $lending) }}" onsubmit="return confirm('Hapus data lending?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr><td colspan="9" class="text-center">Belum ada data lending</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $lendings->links() }}</div>
    </div>
</div>
@endsection
