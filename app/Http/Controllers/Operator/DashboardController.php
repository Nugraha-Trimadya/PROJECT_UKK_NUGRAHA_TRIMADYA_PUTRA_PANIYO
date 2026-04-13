<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lending;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil ringkasan data untuk ditampilkan di dashboard operator.
        return view('operator.dashboard', [
            // Total seluruh item yang tersedia di sistem.
            'totalItems' => Item::count(),
            // Jumlah peminjaman yang masih aktif, artinya belum dikembalikan.
            'activeLendings' => Lending::whereNull('return_date')->count(),
            // Jumlah peminjaman yang sudah selesai dikembalikan.
            'returnedLendings' => Lending::whereNotNull('return_date')->count(),
        ]);
    }
}
