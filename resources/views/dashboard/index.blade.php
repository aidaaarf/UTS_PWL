@extends('layouts.tamplate')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Dashboard Admin</h3>

    {{-- Info Box --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $jumlahBarang }}</h3>
                    <p>Jumlah Barang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $jumlahPegawai }}</h3>
                    <p>Jumlah Pegawai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

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

    {{-- Tabel Transaksi Terbaru --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5>Transaksi Terbaru</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>User</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksiTerbaru as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->barang->nama }}</td>
                            <td>{{ ucfirst($item->keterangan) }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->user->nama }}</td>
                            <td>{{ $item->created_at ? $item->created_at->format('d-m-Y H:i') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Grafik Transaksi --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5>Grafik Transaksi (6 Bulan Terakhir)</h5>
        </div>
        <div class="card-body">
            <canvas id="grafikTransaksi"></canvas>
        </div>
    </div>
</div>

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikTransaksi').getContext('2d');
    const grafik = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafikTransaksi->pluck('bulan')) !!},
            datasets: [
                {
                    label: 'Masuk',
                    data: {!! json_encode($grafikTransaksi->pluck('masuk')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                },
                {
                    label: 'Keluar',
                    data: {!! json_encode($grafikTransaksi->pluck('keluar')) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
