<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ArrayExport;
use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Maatwebsite\Excel\Facades\Excel;

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
        $rows = Category::withCount('items')
            ->orderBy('name')
            ->get()
            ->map(function (Category $category) {
                return [
                    $category->name,
                    $category->description ?: '-',
                    $category->items_count,
                    $category->updated_at->translatedFormat('M d, Y'),
                ];
            })
            ->all();

        return Excel::download(
            new ArrayExport(['Name', 'Division PJ', 'Total Items', 'Last Updated'], $rows),
            'categories-export.xls',
            ExcelWriter::XLS
        );
    }
}
