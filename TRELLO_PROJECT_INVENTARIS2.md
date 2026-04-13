# Trello Project Inventaris 2

Dokumen ini berisi urutan kerja project Laravel ini dari awal setup sampai fitur yang sudah dikerjakan. Formatnya dibuat seperti Trello supaya gampang dipindah ke board: **Backlog / Doing / Done**.

## 1. Backlog Utama

### List 1 - Project Setup
- Buat project Laravel baru
- Install dependency PHP
- Install dependency frontend
- Setup file `.env`
- Generate application key
- Konfigurasi database
- Jalankan migration awal
- Jalankan seeder awal

### List 2 - Authentication
- Pasang auth scaffolding
- Buat login, register, logout
- Hubungkan auth ke middleware `auth`
- Tambahkan validasi custom Laravel
- Matikan validasi browser supaya pesan Laravel muncul

### List 3 - MVC Structure
- Buat model sesuai tabel
- Buat migration untuk setiap tabel
- Buat controller untuk setiap fitur
- Buat route web untuk admin dan operator
- Buat view Blade untuk semua halaman
- Hubungkan model ke relasi database

### List 4 - Admin Module
- Dashboard admin
- CRUD kategori
- CRUD item
- CRUD user
- Reset password user
- Export data ke Excel
- Detail item dan histori lending

### List 5 - Operator Module
- Dashboard operator
- Kelola lending
- Tambah transaksi peminjaman
- Tandai barang returned
- Hapus transaksi lending
- Export lending ke Excel
- Edit account operator

### List 6 - Validasi & UX
- Tambahkan validasi di semua form
- Buat pesan error yang jelas
- Hapus atribut yang memicu popup browser
- Rapikan tampilan form
- Sesuaikan ukuran button
- Bikin layout lebih konsisten

### List 7 - Testing & Finalisasi
- Jalankan migrate fresh
- Jalankan seeder
- Test login admin
- Test login operator
- Test create/update/delete
- Test export Excel
- Cek layout mobile dan desktop

## 2. Urutan Kerja dari Awal Project

### Tahap 1 - Buat Project
1. Buat project Laravel.
2. Masuk ke folder project.
3. Install dependency.
4. Copy file environment.
5. Generate app key.
6. Atur koneksi database.

#### Command yang dipakai
```bash
composer create-project laravel/laravel inventaris2
cd inventaris2
composer install
copy .env.example .env
php artisan key:generate
```

### Tahap 2 - Setup Database
1. Buat database di MySQL.
2. Isi `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`.
3. Jalankan migration.
4. Jalankan seeder.

#### Command yang dipakai
```bash
php artisan migrate
php artisan db:seed
```

Kalau ingin reset total data:
```bash
php artisan migrate:fresh --seed
```

### Tahap 3 - Auth Scaffolding
Project ini memakai `laravel/ui` untuk auth basic.

#### Command yang dipakai
```bash
composer require laravel/ui:4.5
php artisan ui bootstrap --auth
npm install
npm run dev
```

Catatan:
- `--auth` membuat login, register, logout, dan tampilan auth dasar.
- Setelah itu route auth dipakai lewat `Auth::routes()`.

### Tahap 4 - Tambah Package yang Dibutuhkan
#### Sanctum
Dipakai untuk kebutuhan autentikasi API atau token bila dibutuhkan.
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

#### Excel Export
Dipakai untuk export data kategori, item, user, dan lending.
```bash
composer require maatwebsite/excel:^3.1.67
```

### Tahap 5 - Buat Struktur MVC

#### Model
Model yang dipakai di project ini:
- `User`
- `Category`
- `Item`
- `Lending`
- `LendingItem`

Fungsi model:
- Menyimpan aturan relasi data
- Menentukan field yang bisa diisi lewat `fillable`
- Menyediakan accessor atau helper data

#### Migration
Migration yang dibuat:
- tabel users
- tabel categories
- tabel items
- tabel lendings
- tabel lending_items

Fungsi migration:
- Membuat struktur database
- Menentukan foreign key dan relasi antar tabel
- Menjaga struktur database tetap konsisten

#### Controller
Controller yang dipakai:
- `Auth\LoginController`
- `Auth\RegisterController`
- `Admin\DashboardController`
- `Admin\CategoryController`
- `Admin\ItemController`
- `Admin\UserController`
- `Operator\DashboardController`
- `Operator\ItemController`
- `Operator\LendingController`
- `Operator\UserController`

Fungsi controller:
- Menerima request dari route
- Validasi input
- Ambil / simpan / update / hapus data
- Kirim data ke view
- Jalankan export

#### View
View Blade yang dipakai:
- auth login/register
- admin dashboard
- admin category pages
- admin item pages
- admin user pages
- operator dashboard
- operator lending pages
- operator user edit page

Fungsi view:
- Menampilkan data ke user
- Menampilkan form input
- Menampilkan pesan validasi
- Menjaga tampilan tetap rapi

### Tahap 6 - Routing
Route dipisah berdasarkan role.

#### Route utama
- `/` untuk landing page
- `/home` untuk home setelah login

#### Admin route group
Prefix: `admin`
Middleware: `auth` dan `role:admin`

Fitur yang masuk:
- dashboard
- categories
- items
- users
- export
- detail item
- reset password

#### Operator route group
Prefix: `operator`
Middleware: `auth` dan `role:operator`

Fitur yang masuk:
- dashboard
- lendings
- returned item
- delete lending
- export lending
- edit account operator

### Tahap 7 - Middleware Role
Project ini memakai middleware `EnsureRole`.

Fungsi middleware:
- Cek role user yang sedang login
- Blok akses kalau role tidak cocok
- Pisahkan hak akses admin dan operator

### Tahap 8 - Validasi Form
Validasi dipasang di form admin dan operator.

Yang dilakukan:
- Tambahkan validasi di controller
- Matikan validasi browser dengan `novalidate`
- Tampilkan pesan error Laravel
- Hindari form submit kalau data belum lengkap

### Tahap 9 - Export Excel
Export dibuat untuk data:
- kategori
- item
- user admin
- user operator
- lending operator

Pola export yang dipakai:
- Pakai `maatwebsite/excel`
- Buat class export reusable
- Kirim data array ke export class
- Download file dengan format `.xls`

### Tahap 10 - Final UI/UX Polish
Yang dikerjakan:
- Komentar kode supaya mudah dibaca
- Form dibuat lebih rapih
- Button diperkecil kalau terlalu besar
- Layout kartu dibuat lebih konsisten
- Tabel diberi aksi yang jelas
- Beberapa form diberi padding dan spacing yang lebih enak dilihat

## 3. Mapping MVC per Fitur

### Auth
- Model: `User`
- Controller: `Auth\LoginController`, `Auth\RegisterController`
- View: `resources/views/auth/*`, `resources/views/welcome.blade.php`
- Route: `Auth::routes()`

### Category
- Model: `Category`
- Controller: `Admin\CategoryController`
- View: `resources/views/admin/categories/*`
- Route: `admin/categories`

### Item
- Model: `Item`
- Controller: `Admin\ItemController`, `Operator\ItemController`
- View: `resources/views/admin/items/*`, `resources/views/operator/items/*`
- Route: `admin/items`

### User
- Model: `User`
- Controller: `Admin\UserController`, `Operator\UserController`
- View: `resources/views/admin/users/*`, `resources/views/operator/users/*`
- Route: `admin/users`, `operator/users/{user}/edit`

### Lending
- Model: `Lending`, `LendingItem`
- Controller: `Operator\LendingController`
- View: `resources/views/operator/lendings/*`
- Route: `operator/lendings`

## 4. Urutan Implementasi yang Paling Masuk Akal

Kalau project ini mau dibangun ulang dari nol, urutan paling aman seperti ini:
1. Setup Laravel project
2. Setup `.env` dan database
3. Install auth scaffolding
4. Buat migration dan model
5. Buat relasi antar model
6. Buat middleware role
7. Buat controller admin dan operator
8. Buat route group admin dan operator
9. Buat Blade view
10. Tambahkan validasi form
11. Tambahkan export Excel
12. Rapikan UI/UX
13. Test semua fitur
14. Final seeding dan deployment

## 5. Done List Berdasarkan Project Sekarang

### Sudah dikerjakan
- Laravel project sudah dibuat
- Auth sudah aktif
- Role admin dan operator sudah dipisah
- Middleware role sudah dipakai
- Migration database sudah ada
- Model inti sudah dibuat
- CRUD kategori sudah jalan
- CRUD item sudah jalan
- CRUD user sudah jalan
- Lending operator sudah jalan
- Export Excel sudah jalan
- Validasi form sudah diperbaiki
- UI beberapa form sudah dirapikan

### Masih bisa dikembangkan lagi
- Standarisasi tampilan semua halaman supaya lebih konsisten
- Penamaan role bisa diseragamkan kalau ingin pakai istilah staff
- Tambah filter atau search di tabel data
- Tambah pagination dan sorting yang lebih rapi
- Tambah notifikasi success/error yang lebih modern

## 6. Checklist Singkat untuk Trello

### To Do
- Setup project Laravel
- Install auth scaffolding
- Buat database dan migration
- Buat model, controller, view
- Buat middleware role
- Buat CRUD admin dan operator
- Buat export Excel
- Buat validasi semua form
- Rapikan UI
- Test semua fitur

### Doing
- Isi sesuai progress sekarang

### Done
- Login/register
- Admin dashboard
- Category management
- Item management
- User management
- Lending management
- Excel export
- Validation fixes
- UI polish
