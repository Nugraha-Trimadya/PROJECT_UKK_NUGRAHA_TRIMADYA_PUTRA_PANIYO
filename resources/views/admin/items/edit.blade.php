@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .edit-item-wrap {
        margin: 0 -1.5rem;
        min-height: calc(100vh - 56px);
        background: #f8fafc;
        padding: 24px 16px 40px;
    }

    .edit-item-card {
        max-width: 720px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.06);
        padding: 24px;
    }

    .edit-item-title {
        color: #0f172a;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .edit-item-sub {
        margin: 0 0 20px 0;
        color: #64748b;
        font-size: 0.875rem;
    }

    .edit-item-sub .accent {
        color: #0f766e;
        font-weight: 600;
    }

    .edit-item-form {
        margin: 0;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .edit-item-label {
        color: #1e293b;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .edit-item-label .currently {
        color: #f59e0b;
        font-size: 0.85em;
        font-weight: 500;
    }

    .edit-item-input,
    .edit-item-select {
        width: 100%;
        height: 40px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.9375rem;
        color: #1e293b;
        padding: 8px 12px;
        box-sizing: border-box;
        transition: all .15s ease;
        font-family: inherit;
    }

    .edit-item-input:focus,
    .edit-item-select:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        outline: none;
    }

    .edit-item-input::placeholder {
        color: #94a3b8;
    }

    .edit-item-input.is-invalid,
    .edit-item-select.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    .edit-item-error {
        color: #dc2626;
        font-size: 0.8125rem;
        margin-top: 4px;
        display: block;
    }

    .edit-item-alert {
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #b91c1c;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 16px;
        font-size: 0.875rem;
    }

    .edit-item-alert ul {
        margin: 0;
        padding-left: 20px;
        line-height: 1.5;
    }

    .repair-preview {
        margin-top: 6px;
        color: #475569;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .total-group {
        display: flex;
        align-items: stretch;
        gap: 0;
    }

    .total-group .edit-item-input {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        margin-right: -1px;
    }

    .total-suffix {
        min-width: 70px;
        border: 1px solid #cbd5e1;
        border-left: 0;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.8125rem;
        font-weight: 600;
        box-sizing: border-box;
    }

    .edit-item-actions {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-update-item {
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

    .btn-update-item:hover {
        background: #0d5d57;
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
    }

    .btn-cancel-item {
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

    .btn-cancel-item:hover {
        background: #cbd5e1;
        border-color: #94a3b8;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        height: 40px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.9375rem;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: normal;
        color: #1e293b;
        padding-left: 8px;
        padding-right: 28px;
        font-size: 0.9375rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 6px;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
    }

    .select2-error .select2-selection {
        border-color: #ef4444 !important;
    }

    @media (max-width: 576px) {
        .edit-item-wrap {
            padding: 16px 12px 28px;
        }

        .edit-item-card {
            padding: 16px;
        }

        .edit-item-actions {
            flex-direction: column-reverse;
        }

        .btn-update-item,
        .btn-cancel-item {
            width: 100%;
            text-align: center;
        }
    }
</style>

@endpush

@section('content')
<div class="edit-item-wrap">
    <h2 class="edit-item-title">Edit Item Forms</h2>
    <p class="edit-item-sub">Please <span class="accent">.fill-all</span> input form with right value.</p>

    <form method="POST" action="{{ route('admin.items.update', $item) }}" class="edit-item-form" novalidate>
        @csrf @method('PUT')

        @if ($errors->any())
            <div class="edit-item-alert" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label class="edit-item-label">Name</label>
            <input type="text" name="name" class="form-control edit-item-input @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}" required>
            @error('name')
                <div class="edit-item-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="edit-item-label">Category</label>
            <select name="category_id" id="category_id" class="form-select edit-item-select @error('category_id') is-invalid @enderror" required>
                <option value="">Pilih Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="edit-item-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="edit-item-label">Total</label>
            <div class="total-group">
                <input type="number" name="total" min="1" class="form-control edit-item-input @error('total') is-invalid @enderror" value="{{ old('total', $item->total) }}" required>
                <span class="total-suffix">item</span>
            </div>
            @error('total')
                <div class="edit-item-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="edit-item-label">New Broke Item <span class="currently">(currently: {{ $item->repair }})</span></label>
            <div class="total-group">
                <input type="number" id="new_broke_item" name="new_broke_item" min="0" class="form-control edit-item-input @error('new_broke_item') is-invalid @enderror" value="{{ old('new_broke_item', 0) }}">
                <span class="total-suffix">item</span>
            </div>
            <div class="repair-preview">Repair setelah update: <span id="repair_result">{{ $item->repair + (int) old('new_broke_item', 0) }}</span></div>
            @error('new_broke_item')
                <div class="edit-item-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="edit-item-actions">
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.items.index') }}" class="btn-cancel-item">Cancel</a>
                <button class="btn-update-item" type="submit">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const categorySelect = $('#category_id');

    categorySelect.select2({
        width: '100%',
        placeholder: 'Pilih Category'
    });

    @error('category_id')
        categorySelect.next('.select2-container').addClass('select2-error');
    @enderror

    const currentRepair = {{ $item->repair }};
    const brokeInput = document.getElementById('new_broke_item');
    const repairResult = document.getElementById('repair_result');

    const updateRepairPreview = () => {
        const extra = parseInt(brokeInput.value || '0', 10);
        const safeExtra = Number.isNaN(extra) || extra < 0 ? 0 : extra;
        repairResult.textContent = currentRepair + safeExtra;
    };

    brokeInput.addEventListener('input', updateRepairPreview);
    updateRepairPreview();
</script>
@endpush
