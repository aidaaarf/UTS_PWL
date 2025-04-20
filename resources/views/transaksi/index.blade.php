@extends('layouts.tamplate')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Transaksi</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('transaksi/create') }}')" class="btn btn-sm btn-success mt-1">
                    + Tambah Transaksi
                </button>
            </div>
        </div>
        <div class="card-body">
            <h1>Transaksi</h1>
            <table class="table" id="table_transaksi">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>User</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" 
        data-keyboard="false" data-width="75%" aria-hidden="true">
    </div>
@endsection

@push('js')
    <script>
        // Fungsi untuk memanggil modal
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        // DataTable Transaksi
        var dataTransaksi;

        $(document).ready(function () {
            dataTransaksi = $('#table_transaksi').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('transaksi/data') }}",
                    dataType: "json",
                    type: "GET"
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "barang.kode",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "barang.nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "username",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "keterangan",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "jumlah",
                        className: "text-center",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
