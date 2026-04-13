@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .edit-user-wrap {
        margin: 0 -1.5rem;
        min-height: calc(100vh - 56px);
        background: #ececec;
        padding: 24px 16px 40px;
    }

    .edit-user-card {
        max-width: 760px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #d6dce3;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.06);
        padding: 24px;
    }

    .edit-user-title {
        color: #17314e;
        font-size: 1.6rem;
        font-weight: 700;
        margin: 0;
    }

    .edit-user-sub {
        margin-top: 8px;
        color: #7b8794;
        font-size: 0.95rem;
    }

    .edit-user-sub .accent {
        color: #c88dac;
    }

    .edit-user-form {
        margin-top: 20px;
    }

    .edit-user-label {
        color: #17314e;
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
    }

    .edit-user-label .optional {
        color: #d3a41c;
        font-size: 0.9em;
    }

    .edit-user-input {
        height: 44px;
        border: 1px solid #d6dce3;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #223649;
        padding: 10px 14px;
    }

    .edit-user-error {
        color: #dc3545;
        font-size: 0.82rem;
        margin-top: 4px;
    }

    .edit-user-actions {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-submit-user {
        background: #6c43c1;
        border: none;
        color: #fff;
        border-radius: 6px;
        font-size: 0.95rem;
        font-weight: 600;
        padding: 8px 16px;
    }

    .btn-cancel-user {
        background: #9aa0a6;
        border: none;
        color: #1f2937;
        border-radius: 6px;
        font-size: 0.95rem;
        font-weight: 600;
        padding: 8px 16px;
        text-decoration: none;
        display: inline-block;
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
        <h2 class="edit-user-title">Edit Account Forms</h2>
        <p class="edit-user-sub">Please <span class="accent">.fill-all</span> input form with right value.</p>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="edit-user-form" novalidate>
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="edit-user-label">Name</label>
                <input type="text" name="name" class="form-control edit-user-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="edit-user-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="edit-user-label">Email</label>
                <input type="email" name="email" class="form-control edit-user-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="edit-user-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="edit-user-label">New Password <span class="optional">optional</span></label>
                <input type="password" name="new_password" class="form-control edit-user-input @error('new_password') is-invalid @enderror">
                @error('new_password')
                    <div class="edit-user-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="edit-user-actions">
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route($user->role === 'admin' ? 'admin.users.admin' : 'admin.users.operator') }}" class="btn-cancel-user">Cancel</a>
                    <button class="btn-submit-user" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
