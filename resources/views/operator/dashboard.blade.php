@extends('layouts.app')

@section('hideTopbar', '1')

@push('styles')
<style>
    .operator-front {
        margin: 0 -1.5rem;
        min-height: 100vh;
        background: #e6e6e6;
    }

    .operator-hero {
        min-height: 390px;
        padding: 34px;
        color: #fff;
        background-image:
            linear-gradient(0deg, rgba(0, 0, 0, 0.42), rgba(0, 0, 0, 0.42)),
            url('https://images.unsplash.com/photo-1464822759844-d150ad6d1fa0?auto=format&fit=crop&w=1800&q=80');
        background-size: cover;
        background-position: center;
    }

    .operator-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 56px;
    }

    .operator-hero-title {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 2.65rem;
        font-weight: 700;
    }

    .operator-menu-icon {
        font-size: 2rem;
    }

    .operator-date-title {
        font-size: 2.15rem;
        font-weight: 700;
    }

    .operator-notice-card {
        background: #f8fafc;
        color: #22334a;
        border-radius: 0;
        padding: 28px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .operator-notice-text {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .operator-user-drop {
        border: none;
        background: transparent;
        color: #26384d;
        font-size: 1.7rem;
        font-weight: 600;
    }

    .operator-user-drop i {
        font-size: 1.8rem;
    }
</style>
@endpush

@section('content')
<div class="operator-front">
    {{-- Bagian hero utama dashboard operator. --}}
    <div class="operator-hero">
        <div class="operator-hero-top">
            <div class="operator-hero-title">
                <i class="bi bi-list operator-menu-icon"></i>
                <span>Welcome Back, {{ auth()->user()->name }}</span>
            </div>
        </div>

        {{-- Kartu informasi singkat dan menu logout. --}}
        <div class="operator-notice-card">
            <p class="operator-notice-text">Check menu in sidebar</p>
            <div class="dropdown">
                <button class="operator-user-drop dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2"></i>
                    {{ auth()->user()->name }}
                </button>
                {{-- Dropdown untuk logout user. --}}
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
</div>
@endsection
