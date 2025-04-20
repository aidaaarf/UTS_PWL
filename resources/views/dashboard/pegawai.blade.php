@extends('layouts.tamplate')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Dashboard Pegawai</h3>

    {{-- Stok Rendah Warning --}}
    @if($stokRendah->count())
    <div class="alert alert-warning mt-3">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan Stok Rendah</h5>
        <ul class="mb-0">
            @foreach($stokRendah as $barang)
                <li><strong>{{ $barang->nama }}</strong> - Stok: {{ $barang->stok }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Tabel Transaksi Terbaru (Transaksi Pegawai) --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5>Transaksi Terbaru Anda</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksiPegawai as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->barang->nama }}</td>
                            <td>{{ ucfirst($item->keterangan) }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->created_at ? $item->created_at->format('d-m-Y H:i') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>    
</div>
@endsection
