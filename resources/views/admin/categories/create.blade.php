@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .add-cat-wrap {
        margin: 0 -1.5rem;
        min-height: calc(100vh - 56px);
        background: #f8fafc;
        padding: 24px 16px 40px;
    }

    .add-cat-card {
        max-width: 720px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.06);
        padding: 24px;
    }

    .add-cat-title {
        color: #0f172a;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .add-cat-sub {
        margin: 0 0 20px 0;
        color: #64748b;
        font-size: 0.875rem;
    }

    .add-cat-sub .accent {
        color: #0f766e;
        font-weight: 600;
    }

    .add-cat-form {
        margin: 0;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .add-cat-label {
        color: #1e293b;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .add-cat-input,
    .add-cat-select {
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

    .add-cat-input:focus,
    .add-cat-select:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        outline: none;
    }

    .add-cat-input::placeholder {
        color: #94a3b8;
    }

    .add-cat-input.is-invalid,
    .add-cat-select.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    .add-cat-error {
        color: #dc2626;
        font-size: 0.8125rem;
        margin-top: 4px;
        display: block;
    }

    .add-cat-alert {
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #b91c1c;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 16px;
        font-size: 0.875rem;
    }

    .add-cat-alert ul {
        margin: 0;
        padding-left: 20px;
        line-height: 1.5;
    }

    .add-cat-actions {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-save-cat {
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

    .btn-save-cat:hover {
        background: #0d5d57;
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
    }

    .btn-cancel-cat {
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

    .btn-cancel-cat:hover {
        background: #cbd5e1;
        border-color: #94a3b8;
    }

    @media (max-width: 576px) {
        .add-cat-wrap {
            padding: 16px 12px 28px;
        }

        .add-cat-card {
            padding: 16px;
        }

        .add-cat-actions {
            flex-direction: column-reverse;
        }

        .btn-save-cat,
        .btn-cancel-cat {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="add-cat-wrap">
    <div class="add-cat-card">
    <h2 class="add-cat-title">Tambah Kategori Inventaris</h2>
    <p class="add-cat-sub">Lengkapi <span class="accent">semua field wajib</span> dengan data yang benar.</p>

    <form method="POST" action="{{ route('admin.categories.store') }}" class="add-cat-form" novalidate>
        @csrf

        @if ($errors->any())
            <div class="add-cat-alert" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label class="add-cat-label">Name</label>
            <input
                type="text"
                name="name"
                class="form-control add-cat-input @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                placeholder="Alat Dapur"
                required
            >
            @error('name')
                <div class="add-cat-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="add-cat-label">Division PJ</label>
            <select name="description" class="form-select add-cat-select @error('description') is-invalid @enderror" required>
                <option value="">Select Division PJ</option>
                <option value="Sarpras" @selected(old('description') === 'Sarpras')>Sarpras</option>
                <option value="Tata Usaha" @selected(old('description') === 'Tata Usaha')>Tata Usaha</option>
                <option value="Tefa" @selected(old('description') === 'Tefa')>Tefa</option>
            </select>
            @error('description')
                <div class="add-cat-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="add-cat-actions">
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="btn-cancel-cat">Cancel</a>
                <button class="btn-save-cat" type="submit">Submit</button>
            </div>
        </div>
    </form>
    </div>
</div>
@endsection
