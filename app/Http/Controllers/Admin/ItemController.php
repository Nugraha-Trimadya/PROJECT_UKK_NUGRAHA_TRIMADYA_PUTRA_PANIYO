<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\LendingItem;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->latest()->paginate(10);
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'min:3', 'max:120'],
            'total' => ['required', 'integer', 'min:1'],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'name.required' => 'Nama barang wajib diisi.',
            'name.min' => 'Nama barang minimal 3 karakter.',
            'name.max' => 'Nama barang maksimal 120 karakter.',
            'total.required' => 'Total barang wajib diisi.',
            'total.integer' => 'Total barang harus berupa angka.',
            'total.min' => 'Total barang minimal 1.',
        ], [
            'category_id' => 'category',
        ]);

        $validated['repair'] = $validated['repair'] ?? 0;

        Item::create($validated);

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'min:3', 'max:120'],
            'total' => ['required', 'integer', 'min:1'],
            'new_broke_item' => ['nullable', 'integer', 'min:0'],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'name.required' => 'Nama barang wajib diisi.',
            'name.min' => 'Nama barang minimal 3 karakter.',
            'name.max' => 'Nama barang maksimal 120 karakter.',
            'total.required' => 'Total barang wajib diisi.',
            'total.integer' => 'Total barang harus berupa angka.',
            'total.min' => 'Total barang minimal 1.',
            'new_broke_item.integer' => 'Barang rusak harus berupa angka.',
            'new_broke_item.min' => 'Barang rusak minimal 0.',
        ], [
            'category_id' => 'category',
        ]);

        $newBroke = (int) ($validated['new_broke_item'] ?? 0);
        $newRepair = $item->repair + $newBroke;

        if ($newRepair > (int) $validated['total']) {
            return back()->withErrors([
                'new_broke_item' => 'Total repair tidak boleh lebih besar dari total item.',
            ])->withInput();
        }

        $item->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'total' => $validated['total'],
            'repair' => $newRepair,
        ]);

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil diubah.');
    }

    public function show(Item $item)
    {
        $item->load('category');

        $details = LendingItem::with(['lending', 'lending.user'])
            ->where('item_id', $item->id)
            ->latest()
            ->paginate(15);

        return view('admin.items.show', compact('item', 'details'));
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil dihapus.');
    }

    public function export()
    {
        $items = Item::with('category')->orderBy('name')->get();

        $rows = [
            ['Category', 'Name Item', 'Total', 'Repair Total', 'Last Updated'],
        ];

        foreach ($items as $item) {
            $rows[] = [
                $item->category?->name,
                $item->name,
                $item->total,
                $item->repair === 0 ? '-' : $item->repair,
                $item->updated_at->translatedFormat('M d, Y'),
            ];
        }

        return response($this->toXls($rows), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="items-export.xls"',
        ]);
    }

    public function lendingDetails(Item $item)
    {
        $details = LendingItem::with(['lending', 'lending.user'])
            ->where('item_id', $item->id)
            ->latest()
            ->paginate(15);

        return view('admin.items.lending-details', compact('item', 'details'));
    }

    private function toXls(array $rows): string
    {
        //rows adalaha data table dalam bentuk array
        //
        // $lines = ["\xEF\xBB\xBF"];
        foreach ($rows as $row) {
            $lines[] = implode("\t", array_map(function ($value) {
                $text = (string) $value;
                // Hilangkan karakter yang bisa mengacaukan format Excel.
                $text = str_replace(["\r\n", "\r", "\n", "\t"], [' ', ' ', ' ', ' '], $text);

                return $text;
            }, $row));
        }

        //gabungin semua baris menjadi satu string 
        return implode("\r\n", $lines);
    }
}
