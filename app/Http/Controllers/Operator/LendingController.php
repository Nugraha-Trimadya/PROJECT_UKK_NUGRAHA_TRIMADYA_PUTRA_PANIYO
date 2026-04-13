<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    public function index()
    {
        // Tampilkan daftar peminjaman beserta detail item dan user pembuatnya.
        $lendings = Lending::with(['details.item', 'user'])->latest()->paginate(10);
        return view('operator.lendings.index', compact('lendings'));
    }

    public function create()
    {
        // Siapkan daftar item untuk dipilih saat membuat peminjaman baru.
        // method with untuk mengirim data ke view dengan relasi category agar bisa menampilkan nama kategori di dropdown.
        // method orderBy untuk mengurutkan item berdasarkan nama agar lebih mudah dicari.
        // method get untuk mengambil semua data item.
        $items = Item::with('category')->orderBy('name')->get();
        return view('operator.lendings.create', compact('items'));
    }

    public function store(Request $request)
    {
        // Validasi semua input form sebelum menyimpan data peminjaman.
        $validated = $request->validate([
            'borrower_name' => ['required', 'max:100'],
            'borrower_phone' => ['nullable', 'max:30'],
            'note' => ['nullable', 'max:500'],
            'lend_date' => ['nullable', 'date'],
            // Tanggal kembali tidak boleh lebih awal dari tanggal pinjam.
            'due_date' => ['nullable', 'date', 'after_or_equal:lend_date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'exists:items,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ]);

        // Gunakan transaksi agar header peminjaman dan detail item selalu konsisten.
        DB::transaction(function () use ($validated, $request) {
            $lending = Lending::create([
                'borrower_name' => $validated['borrower_name'],
                'borrower_phone' => $validated['borrower_phone'] ?? null,
                'note' => $validated['note'] ?? null,
                'lend_date' => $validated['lend_date'] ?? now()->toDateString(),
                'due_date' => $validated['due_date'] ?? null,
                'created_by' => $request->user()->id,
            ]);

            foreach ($validated['items'] as $index => $entry) {
                // Ambil data item yang dipilih untuk cek stok tersisa.
                $item = Item::findOrFail($entry['item_id']);

                // Tolak jika jumlah pinjam melebihi stok tersedia.
                if ($entry['qty'] > $item->available) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "items.{$index}.qty" => 'Total item more than available!',
                    ]);
                }

                // Simpan detail item yang dipinjam.
                $lending->details()->create([
                    'item_id' => $item->id,
                    'qty' => $entry['qty'],
                ]);
            }
        });

        // Kembali ke daftar peminjaman setelah data tersimpan.
        return redirect()->route('operator.lendings.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function returned(Lending $lending)
    {
        // Tandai peminjaman sebagai sudah dikembalikan jika belum ada tanggal kembali.
        if ($lending->return_date === null) {
            $lending->update(['return_date' => now()]);
        }

        // Kembali ke daftar peminjaman dengan pesan sukses.
        return redirect()->route('operator.lendings.index')->with('success', 'Barang sudah ditandai sebagai returned.');
    }

    public function destroy(Lending $lending)
    {
        // Hapus data dalam transaksi supaya detail dan header ikut konsisten.
        DB::transaction(function () use ($lending) {
            // Kalau masih aktif, hapus dulu semua detail item-nya.
            if ($lending->return_date === null) {
                $lending->details()->delete();
            }

            // Hapus record peminjaman utama.
            $lending->delete();
        });

        // Kembali ke daftar peminjaman setelah data dihapus.
        return redirect()->route('operator.lendings.index')->with('success', 'Data lending berhasil dihapus.');
    }

    public function export()
    {
        // Ambil semua data untuk dibuat file Excel.
        $lendings = Lending::with(['details.item', 'user'])->orderByDesc('id')->get();
        $rows = [
            // Header kolom sesuai tampilan yang diminta.
            ['Item', 'Total', 'Name', 'Ket.', 'Date', 'Return Date', 'Edited By'],
        ];

        foreach ($lendings as $lending) {
            foreach ($lending->details as $detail) {
                $rows[] = [
                    $detail->item?->name,
                    $detail->qty,
                    $lending->borrower_name,
                    $lending->note ?: '-',
                    optional($lending->lend_date)->translatedFormat('d F, Y'),
                    $lending->return_date ? $lending->return_date->translatedFormat('d F, Y') : ' - ',
                    $lending->user?->name,
                ];
            }
        }

        // Kirim file Excel sebagai download ke browser.
        return response($this->toXls($rows), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="lendings-export.xls"',
        ]);
    }

    private function toXls(array $rows): string
    {
        // Format tab-separated supaya Excel bisa membukanya sebagai file .xls.
        $lines = ["\xEF\xBB\xBF"];
        foreach ($rows as $row) {
            $lines[] = implode("\t", array_map(function ($value) {
                $text = (string) $value;
                return str_replace(["\r\n", "\r", "\n", "\t"], ' ', $text);
            }, $row));
        }

        return implode("\r\n", $lines);
    }
}
