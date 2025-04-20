@extends('layouts.tamplate')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                <button onclick="modalAction('{{ url('user/create') }}')" class="btn btn-sm btn-success mt-1">
                    + Tambah User
                </button>
            </div>
        </div>
        <div class="card-body">
            <h1>User</h1>
            <table class="table" id="table_user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Role</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true">
        </div>
    </div>
@endsection
@push('js')
    <script>
        function modalAction(url) {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        var dataUser;
        $(document).ready(function () {
            dataUser = $('#table_user').DataTable({
                serverSide: true,
                ajax: {
                    'url': "{{ url('user/data') }}",
                    'dataType': "json",
                    'type': "GET",
                    'error': function (xhr, error, code) {
                        console.log(xhr, error, code);
                        alert("Terjadi kesalahan saat mengambil data.");
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'role',
                        className: '',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'username',
                        className: '',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'nama',
                        className: '',
                        orderable: true,
                        searchable: true
                    },
                    
                    {
                        data: 'aksi',
                        className: '',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

        });
    </script>
@endpush