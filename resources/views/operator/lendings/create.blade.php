@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .lend-form-wrap {
        margin: 0 -1.5rem;
        min-height: calc(100vh - 56px);
        background: #f8fafc;
        padding: 24px 16px 40px;
    }

    .lend-form-card {
        max-width: 760px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.06);
        padding: 24px;
    }

    .lend-form-title {
        color: #0f172a;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .lend-form-sub {
        margin: 0 0 20px 0;
        color: #64748b;
        font-size: 0.875rem;
    }

    .lend-form-sub .accent {
        color: #0f766e;
        font-weight: 600;
    }

    .lend-form {
        margin: 0;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .lend-label {
        color: #1e293b;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .lend-input,
    .lend-select,
    .lend-textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.9375rem;
        color: #1e293b;
        padding: 8px 12px;
        background: #fff;
        box-sizing: border-box;
        transition: all .15s ease;
        font-family: inherit;
    }

    .lend-input,
    .lend-select {
        height: 40px;
    }

    .lend-textarea {
        min-height: 88px;
        resize: vertical;
    }

    .lend-input:focus,
    .lend-select:focus,
    .lend-textarea:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        outline: none;
    }

    .lend-input::placeholder,
    .lend-textarea::placeholder {
        color: #94a3b8;
    }

    .item-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        margin-bottom: 12px;
        align-items: stretch;
    }

    .item-row > div {
        flex: 1;
    }

    .extra-item-block {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #f9fafb;
        padding: 16px;
        margin: 12px 0;
        position: relative;
    }

    .row-remove {
        width: 28px;
        height: 28px;
        border: 0;
        border-radius: 6px;
        background: #ef4444;
        color: #fff;
        font-size: 0.9rem;
        font-weight: 700;
        line-height: 1;
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all .15s ease;
    }

    .row-remove:hover {
        background: #dc2626;
        transform: scale(1.05);
    }

    .more-btn {
        background: transparent;
        border: 1px solid #cbd5e1;
        color: #0f766e;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        padding: 6px 12px;
        cursor: pointer;
        transition: all .15s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .more-btn:hover {
        border-color: #0f766e;
        background: #f0fffe;
    }

    .lend-error {
        color: #dc2626;
        font-size: 0.8125rem;
        margin-top: 4px;
        display: block;
    }

    .stock-warning {
        display: none;
        background: #fef3c7;
        border: 1px solid #fcd34d;
        border-radius: 8px;
        color: #92400e;
        padding: 12px;
        margin-bottom: 14px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .btn-submit {
        background: #0f766e;
        border: none;
        color: #fff;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        padding: 8px 16px;
        cursor: pointer;
        transition: all .15s ease;
    }

    .btn-submit:hover {
        background: #0d5d57;
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
    }

    .btn-cancel {
        background: #e2e8f0;
        border: 1px solid #cbd5e1;
        color: #334155;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        padding: 8px 16px;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        transition: all .15s ease;
    }

    .btn-cancel:hover {
        background: #cbd5e1;
        border-color: #94a3b8;
    }

    .form-actions {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    @media (max-width: 576px) {
        .lend-form-wrap {
            padding: 16px 12px 28px;
        }

        .lend-form-card {
            padding: 16px;
        }

        .item-row {
            grid-template-columns: 1fr;
        }

        .row-remove {
            width: 100%;
            height: 32px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-submit,
        .btn-cancel {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="lend-form-wrap">
    <div class="lend-form-card">
    {{-- Form utama untuk menambah transaksi peminjaman baru. --}}
    <h2 class="lend-form-title">Tambah Data Peminjaman</h2>
    <p class="lend-form-sub">Isi <span class="accent">seluruh field wajib</span> agar data peminjaman valid.</p>

    <form method="POST" action="{{ route('operator.lendings.store') }}" class="lend-form" novalidate>
        @csrf
        <input type="hidden" name="lend_date" value="{{ old('lend_date', now()->toDateString()) }}">

        {{-- Peringatan stok ketika jumlah pinjam melebihi stok tersedia. --}}
        <div id="stock-warning" class="stock-warning">Total item more than available!</div>

        @if ($errors->any() && collect($errors->all())->contains('Total item more than available!'))
            <div class="stock-warning" style="display:block;">Total item more than available!</div>
        @endif

        <div class="mb-4">
            <label class="lend-label">Name</label>
            <input type="text" name="borrower_name" class="form-control lend-input @error('borrower_name') is-invalid @enderror" value="{{ old('borrower_name') }}" placeholder="Name" required>
            @error('borrower_name')
                <div class="lend-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Daftar item yang akan dipinjam bisa ditambah lebih dari satu baris. --}}
        <div id="items-wrapper">
            <div class="item-row" data-index="0">
                <div>
                    <label class="lend-label">Items</label>
                    <select name="items[0][item_id]" class="form-select lend-select @error('items.0.item_id') is-invalid @enderror" required>
                        <option value="">Select Items</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" data-available="{{ $item->available }}">{{ $item->name }} (available: {{ $item->available }})</option>
                        @endforeach
                    </select>
                    @error('items.0.item_id')
                        <div class="lend-error">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="lend-label">Total</label>
                    <input type="number" min="1" name="items[0][qty]" class="form-control lend-input @error('items.0.qty') is-invalid @enderror" placeholder="total item" required>
                    @error('items.0.qty')
                        <div class="lend-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Tombol untuk menambahkan baris item baru. --}}
        <button type="button" class="more-btn mb-3" id="add-more">⌄ More</button>

        <div class="mb-4">
            <label class="lend-label">Ket.</label>
            <textarea name="note" class="form-control lend-textarea" placeholder="Keterangan">{{ old('note') }}</textarea>
        </div>

        {{-- Aksi submit dan cancel. --}}
        <div class="d-flex gap-3">
            <button class="btn-submit" type="submit">Submit</button>
            <a href="{{ route('operator.lendings.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Index baris item tambahan yang akan dibuat.
    let rowIndex = 1;
    // Template opsi item agar baris baru punya pilihan yang sama.
    const options = `@foreach($items as $item)<option value="{{ $item->id }}" data-available="{{ $item->available }}">{{ $item->name }} (available: {{ $item->available }})</option>@endforeach`;
    const wrapper = document.getElementById('items-wrapper');
    const stockWarning = document.getElementById('stock-warning');

    // Cek apakah total qty melebihi stok yang tersedia.
    const refreshStockWarning = () => {
        let isExceeded = false;

        document.querySelectorAll('.item-row').forEach((row) => {
            const select = row.querySelector('select[name*="[item_id]"]');
            const qtyInput = row.querySelector('input[name*="[qty]"]');

            if (!select || !qtyInput) {
                return;
            }

            const selectedOption = select.options[select.selectedIndex];
            const available = parseInt(selectedOption?.dataset?.available || '0', 10);
            const qty = parseInt(qtyInput.value || '0', 10);

            if (select.value !== '' && !Number.isNaN(qty) && qty > available) {
                isExceeded = true;
            }
        });

        stockWarning.style.display = isExceeded ? 'block' : 'none';
    };

    // Tambahkan baris item baru saat tombol More diklik.
    document.getElementById('add-more').addEventListener('click', function () {
        const block = document.createElement('div');
        block.className = 'extra-item-block';
        block.dataset.index = rowIndex;
        block.innerHTML = `
            <button type="button" class="row-remove remove-row" title="hapus">x</button>
            <div class="item-row">
                <div>
                    <label class="lend-label">Items</label>
                    <select name="items[${rowIndex}][item_id]" class="form-select lend-select" required>
                        <option value="">Select Items</option>
                        ${options}
                    </select>
                </div>
                <div>
                    <label class="lend-label">Total</label>
                    <input type="number" min="1" name="items[${rowIndex}][qty]" class="form-control lend-input" placeholder="total item" required>
                </div>
            </div>
        `;

        wrapper.appendChild(block);
        refreshStockWarning();
        rowIndex++;
    });

    // Hapus baris item tambahan yang dipilih user.
    document.addEventListener('click', function (e) {
        if (!e.target.classList.contains('remove-row')) {
            return;
        }

        const block = e.target.closest('.extra-item-block');
        if (block) {
            block.remove();
            refreshStockWarning();
        }
    });

    // Update warning stok saat jumlah berubah.
    document.addEventListener('input', function (e) {
        if (e.target.name && e.target.name.includes('[qty]')) {
            refreshStockWarning();
        }
    });

    // Update warning stok saat item yang dipilih berubah.
    document.addEventListener('change', function (e) {
        if (e.target.name && e.target.name.includes('[item_id]')) {
            refreshStockWarning();
        }
    });

    // Jalankan pengecekan awal saat halaman dibuka.
    refreshStockWarning();
</script>
@endpush
