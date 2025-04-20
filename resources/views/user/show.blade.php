@extends('layouts.tamplate')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
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

            @empty($user)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ $user->role ?? '-' }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
