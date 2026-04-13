<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventaris Sekolah</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        :root {
            --bg: #f5f7fb;
            --surface: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --primary: #2f4cb5;
            --primary-soft: #e9eeff;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        .nav-wrap {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px 16px;
        }

        .brand {
            font-weight: 800;
            letter-spacing: 0.02em;
            color: var(--primary);
        }

        .hero {
            margin-top: 16px;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 26px;
        }

        .hero-title {
            font-size: clamp(1.6rem, 2.5vw, 2.2rem);
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 10px;
        }

        .hero-subtitle {
            color: var(--muted);
            font-size: 0.98rem;
            margin-bottom: 0;
        }

        .feature-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 18px;
            height: 100%;
        }

        .feature-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .feature-text {
            color: var(--muted);
            margin: 0;
            font-size: 0.92rem;
        }

        .btn-primary-soft {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            font-weight: 600;
        }

        .btn-primary-soft:hover {
            background: #263f98;
            border-color: #263f98;
            color: #fff;
        }

        .btn-ghost {
            background: var(--primary-soft);
            color: var(--primary);
            border: 1px solid #d4ddff;
            font-weight: 600;
        }

        .btn-ghost:hover {
            color: #223a92;
            background: #dde6ff;
        }
    </style>
</head>
<body>
    <div class="container py-4 py-lg-5">
        <header class="d-flex justify-content-between align-items-center nav-wrap">
            <div class="brand fs-5">INVENTARIS SEKOLAH</div>

            <div class="d-flex gap-2">
                @if (Route::has('login'))
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary-soft px-3">Dashboard</a>
                        @else
                            <a href="{{ route('operator.dashboard') }}" class="btn btn-primary-soft px-3">Dashboard</a>
                        @endif
                    @else
                        <button type="button" class="btn btn-primary-soft px-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    @endauth
                @endif
            </div>
        </header>

        <main class="hero">
            <h1 class="hero-title">Kelola Inventaris Lebih Ringkas dan Rapi</h1>
            <p class="hero-subtitle">Sistem inventaris sekolah untuk pencatatan barang, peminjaman, pengembalian, dan laporan dalam satu tempat.</p>

            <div class="d-flex flex-wrap gap-2 mt-4">
                @if (Route::has('login'))
                    <button type="button" class="btn btn-primary-soft" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</button>
                @endif
            </div>
        </main>

        <section id="fitur" class="row g-3 mt-2">
            <div class="col-md-4">
                <article class="feature-card">
                    <h2 class="feature-title">Manajemen Barang</h2>
                    <p class="feature-text">Atur kategori, data item, jumlah total, kondisi repair, dan stok tersedia.</p>
                </article>
            </div>
            <div class="col-md-4">
                <article class="feature-card">
                    <h2 class="feature-title">Peminjaman Cepat</h2>
                    <p class="feature-text">Catat peminjaman multi-item, validasi stok, dan status pengembalian secara langsung.</p>
                </article>
            </div>
            <div class="col-md-4">
                <article class="feature-card">
                    <h2 class="feature-title">Export Laporan</h2>
                    <p class="feature-text">Unduh data penting untuk dokumentasi administrasi dan kebutuhan ujikom.</p>
                </article>
            </div>
        </section>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <div class="modal-body text-dark">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary-soft">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @if ($errors->any())
        <script>
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        </script>
    @endif
</body>
</html>
