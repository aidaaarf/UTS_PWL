@extends('layouts.tamplate')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                <button onclick="modalAction('{{ url('kategori/create') }}')" class="btn btn-sm btn-success mt-1">
                    + Tambah Kategori
                </button>
            </div>
        </div>
        <div class="card-body">
            <h1>Kategori</h1>
            <table class="table" id="table_kategori">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true">
    </div>
@endsection
@push('js')
    <script>
        function modalAction(url) {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }
        var dataKategori;
        $(document).ready(function () {
            dataKategori = $('#table_kategori').DataTable({
                serverSide: true,
                ajax: {
                    'url': "{{ url('kategori/data') }}",
                    'dataType': "json",
                    'type': "GET"
                },
                columns: [{
                    data: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }, {
                    data: "kode",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "nama",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
        });
    </script>
@endpush