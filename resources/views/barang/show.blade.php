@extends('layouts.tamplate')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <!-- Menampilkan breadcrumb -->
            @if(isset($breadcrumb))
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @foreach($breadcrumb->list as $item)
                                <li class="breadcrumb-item">
                                    @if($loop->last)
                                        <span>{{ $item }}</span>
                                    @else
                                        <a href="#">{{ $item }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                </div>
            @endif

            @if(!$barang)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>Kode Barang</th>
                        <td>{{ $barang->kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td>{{ $barang->nama }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>{{ $barang->stok }}</td>
                    </tr>
                </table>
            @endif


            <a href="{{ url('barang') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush