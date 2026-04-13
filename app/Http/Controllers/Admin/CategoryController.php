<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('items')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:categories,name'],
            'description' => ['required', 'in:Sarpras,Tata Usaha,Tefa'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.min' => 'Nama kategori minimal 3 karakter.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'name.unique' => 'Nama kategori sudah dipakai.',
            'description.required' => 'Division PJ wajib dipilih.',
            'description.in' => 'Division PJ yang dipilih tidak valid.',
        ], [
            'name' => 'nama kategori',
            'description' => 'division pj',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:categories,name,' . $category->id],
            'description' => ['required', 'in:Sarpras,Tata Usaha,Tefa'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.min' => 'Nama kategori minimal 3 karakter.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'name.unique' => 'Nama kategori sudah dipakai.',
            'description.required' => 'Division PJ wajib dipilih.',
            'description.in' => 'Division PJ yang dipilih tidak valid.',
        ], [
            'name' => 'nama kategori',
            'description' => 'division pj',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function export()
    {
        $categories = Category::withCount('items')->orderBy('name')->get();

        $rows = [
            ['Name', 'Division PJ', 'Total Items', 'Last Updated'],
        ];

        foreach ($categories as $category) {
            $rows[] = [
                $category->name,
                $category->description ?: '-',
                $category->items_count,
                $category->updated_at->translatedFormat('M d, Y'),
            ];
        }

        return response($this->toXls($rows), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="categories-export.xls"',
        ]);
    }

    private function toXls(array $rows): string
    {
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
