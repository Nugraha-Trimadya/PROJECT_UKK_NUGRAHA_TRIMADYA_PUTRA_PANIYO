@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .edit-user-wrap {
        margin: 0 -1.5rem;
        min-height: calc(100vh - 56px);
        background: #f8fafc;
        padding: 24px 16px 40px;
    }

    .edit-user-card {
        max-width: 720px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.06);
        padding: 24px;
    }

    .edit-user-title {
        color: #0f172a;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .edit-user-sub {
        margin: 0 0 20px 0;
        color: #64748b;
        font-size: 0.875rem;
    }

    .edit-user-sub .accent {
        color: #0f766e;
        font-weight: 600;
    }

    .edit-user-form {
        margin: 0;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .edit-user-label {
        color: #1e293b;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .edit-user-label .optional {
        color: #f59e0b;
        font-size: 0.85em;
        font-weight: 500;
    }

    .edit-user-input {
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

    .edit-user-input:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        outline: none;
    }

    .edit-user-input::placeholder {
        color: #94a3b8;
    }

    .edit-user-error {
        color: #dc2626;
        font-size: 0.8125rem;
        margin-top: 4px;
        display: block;
    }

    .edit-user-actions {
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
        .edit-user-wrap {
            padding: 16px 12px 28px;
        }

        .edit-user-card {
            padding: 16px;
        }

        .edit-user-actions {
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
<div class="edit-user-wrap">
    <div class="edit-user-card">
    {{-- Form untuk update profil operator sendiri. --}}
    <h2 class="edit-user-title">Edit Akun Operator</h2>
    <p class="edit-user-sub">Perbarui data akun dan isi <span class="accent">field wajib</span> dengan benar.</p>

    <form method="POST" action="{{ route('operator.users.update', $user) }}" class="edit-user-form" novalidate>
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="edit-user-label">Name</label>
            <input type="text" name="name" class="form-control edit-user-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="edit-user-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="edit-user-label">Email</label>
            <input type="email" name="email" class="form-control edit-user-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="edit-user-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="edit-user-label">New Password <span class="optional">optional</span></label>
            {{-- Password baru boleh dikosongkan kalau tidak ingin mengganti password. --}}
            <input type="password" name="new_password" class="form-control edit-user-input @error('new_password') is-invalid @enderror" placeholder="Kosongkan jika tidak ingin ganti password">
            @error('new_password')
                <div class="edit-user-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="edit-user-actions">
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('operator.dashboard') }}" class="btn-cancel-user">Cancel</a>
                <button class="btn-submit-user" type="submit">Submit</button>
            </div>
        </div>
    </form>
    </div>
</div>
@endsection
