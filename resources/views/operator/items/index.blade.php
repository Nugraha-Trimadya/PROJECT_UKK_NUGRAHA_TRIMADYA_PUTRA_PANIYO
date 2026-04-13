@extends('layouts.app')

@section('content')
{{-- Tabel daftar item yang bisa dipantau operator. --}}
<h4 class="mb-3">Items</h4>
<div class="alert alert-info py-2">
    Available = Total - Repair - Lending Total
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead><tr>
                <th>Name</th>
                <th>Category</th>
                <th>Total</th>
                {{-- <th>Repair</th> --}}
                <th>Available</th>
                <th>Lending Total</th>
            </tr></thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category?->name }}</td>
                    <td>{{ $item->total }}</td>
                    {{-- <td>{{ $item->repair }}</td> --}}
                    {{-- Jumlah item yang masih sedang dipinjam. --}}
                                        <td>{{ max(0, (int) $item->total - (int) $item->repair - (int) $item->active_lending_qty) }}</td>
                    <td>{{ (int) $item->active_lending_qty }}</td>
                    {{-- Sisa stok yang benar-benar tersedia. --}}

                    {{-- <td class="text-muted small">{{ $item->total }} - {{ $item->repair }} - {{ (int) $item->active_lending_qty }}</td> --}}
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Belum ada data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $items->links() }}</div>
@endsection
