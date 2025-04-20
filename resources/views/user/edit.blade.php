@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
 @else
    <form action="{{ url('/user/' . $user->id . '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- Nama --}}
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required value="{{ $user->nama }}">
                        <small id="error-nama" class="error-text form-text text-danger"></small>
                    </div>

                    {{-- Username --}}
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" id="username" class="form-control" required
                            value="{{ $user->username }}">
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label>Password <small class="text-muted">(Biarkan kosong jika tidak diubah)</small></label>
                        <input type="password" name="password" id="password" class="form-control">
                        <small id="error-password" class="error-text form-text text-danger"></small>
                    </div>

                    {{-- Password Konfirmasi --}}
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        <small id="error-password_confirmation" class="error-text form-text text-danger"></small>
                    </div>

                    {{-- Role --}}
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pegawai" {{ $user->role === 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        </select>
                        <small id="error-role" class="error-text form-text text-danger"></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function () {
            $('#form-edit').validate({
                rules: {
                    nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    password: {
                        minlength: 6
                    },
                    password_confirmation: {
                        equalTo: "#password"
                    },
                    role: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataUser.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty