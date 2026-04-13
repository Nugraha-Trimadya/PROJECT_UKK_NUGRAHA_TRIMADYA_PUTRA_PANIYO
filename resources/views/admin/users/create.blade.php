@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .add-user-wrap {
        margin: 0 -1.5rem;
        min-height: calc(100vh - 56px);
        background: #f8fafc;
        padding: 24px 16px 40px;
    }

    .add-user-card {
        max-width: 720px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.06);
        padding: 24px;
    }

    .add-user-title {
        color: #0f172a;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .add-user-sub {
        margin: 0 0 20px 0;
        color: #64748b;
        font-size: 0.875rem;
    }

    .add-user-sub .accent {
        color: #0f766e;
        font-weight: 600;
    }

    .add-user-form {
        margin: 0;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .add-user-label {
        color: #1e293b;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .add-user-input,
    .add-user-select {
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

    .add-user-input:focus,
    .add-user-select:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        outline: none;
    }

    .add-user-input::placeholder {
        color: #94a3b8;
    }

    .add-user-input.is-invalid,
    .add-user-select.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    .add-user-error {
        color: #dc2626;
        font-size: 0.8125rem;
        margin-top: 4px;
        display: block;
    }

    .add-user-actions {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-submit-user {
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

    .btn-submit-user:hover {
        background: #0d5d57;
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
    }

    .btn-cancel-user {
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

    .btn-cancel-user:hover {
        background: #cbd5e1;
        border-color: #94a3b8;
    }

    @media (max-width: 576px) {
        .add-user-wrap {
            padding: 16px 12px 28px;
        }

        .add-user-card {
            padding: 16px;
        }

        .add-user-actions {
            flex-direction: column-reverse;
        }

        .btn-submit-user,
        .btn-cancel-user {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="add-user-wrap">
    <div class="add-user-card">
    <h2 class="add-user-title">Tambah Akun Pengguna</h2>
    <p class="add-user-sub">Isi <span class="accent">seluruh field wajib</span> agar akun bisa dibuat dengan benar.</p>

    <form method="POST" action="{{ route('admin.users.store') }}" class="add-user-form" novalidate>
        @csrf

        <div class="mb-4">
            <label class="add-user-label">Name</label>
            <input type="text" name="name" class="form-control add-user-input @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Fema Flamelina Putri">
            @error('name')
                <div class="add-user-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="add-user-label">Email</label>
            <input type="email" name="email" class="form-control add-user-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="femaflam22@gmail.com">
            @error('email')
                <div class="add-user-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="add-user-label">Role</label>
            <select name="role" class="form-select add-user-select @error('role') is-invalid @enderror">
                <option value="">Select Role</option>
                <option value="admin" @selected(old('role', $role) === 'admin')>admin</option>
                <option value="operator" @selected(old('role', $role) === 'operator')>operator</option>
            </select>
            <div class="add-user-error" style="color:#64748b; margin-top:4px; font-size:0.8rem;">
                Pilih role admin atau operator.
            </div>
            @error('role')
                <div class="add-user-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="add-user-actions">
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route(old('role', $role) === 'admin' ? 'admin.users.admin' : 'admin.users.operator') }}" class="btn-cancel-user">Cancel</a>
                <button class="btn-submit-user" type="submit">Submit</button>
            </div>
        </div>
    </form>
    </div>
</div>
@endsection
