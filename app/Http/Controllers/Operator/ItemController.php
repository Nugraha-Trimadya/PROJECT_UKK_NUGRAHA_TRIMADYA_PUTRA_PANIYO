<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        // Ambil data item beserta kategori dan jumlah peminjaman aktif.
        $items = Item::with('category')
            ->withSum([
                // Hitung total qty dari lending item yang masih aktif dipinjam.
                'lendingItems as active_lending_qty' => function ($query) {
                    $query->whereHas('lending', function ($lendingQuery) {
                        $lendingQuery->whereNull('return_date');
                    });
                },
            ], 'qty')
            ->latest()
            // Batasi hasil per halaman agar tabel tetap ringan.
            ->paginate(10);

        // Kirim data item ke view operator.
        return view('operator.items.index', compact('items'));
    }
}
