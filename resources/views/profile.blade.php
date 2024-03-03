@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-account" role="tabpanel"
                    aria-labelledby="pills-account-tab" tabindex="0">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="card w-100 position-relative overflow-hidden">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-semibold">Ubah Profil</h5>
                                    <p class="card-subtitle mb-4">Ubah gambar profil Anda dari sini</p>
                                    <form id="upload-photo" action="{{ route('profile.update-photo') }}"
                                        enctype="multipart/form-data" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="text-center">
                                            <img id="profile-image"
                                                src="{{ asset($user->avatar ? 'storage/' . $user->avatar : 'assets/images/profile/user-1.jpg') }}"
                                                alt="" class="rounded-circle cursor-pointer" width="120"
                                                height="120" style="object-fit: cover">
                                            <input id="photo-profile" type="file" src="" alt=""
                                                name="photoProfile" class="d-none" id="photo-profile-main">
                                            <div class="d-flex align-items-center justify-content-center my-4 gap-3">
                                                <button id="upload-button" type="button"
                                                    class="btn btn-primary">Unggah</button>
                                                <button type="button" id="delete-photo" class="btn btn-outline-danger"
                                                    data-url="{{ route('profile.delete-photo') }}">Hapus</button>
                                            </div>
                                            <p class="mb-0">Klik foto untuk ubah foto, lalu klik tombol "Unggah" untuk
                                                simpan. Dan klik button "Hapus" untuk hapus foto.</p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="card w-100 position-relative overflow-hidden">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-semibold">Ubah Kata Sandi</h5>
                                    <p class="card-subtitle mb-4">Untuk mengubah kata sandi Anda, silakan konfirmasi di sini
                                    </p>
                                    <form action="{{ route('profile.update-password') }}" method="POST"
                                        id="change-password-form">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-4">
                                            <label for="exampleInputPassword1" class="form-label fw-semibold">kata sandi
                                                saat ini</label>
                                            <input type="password" class="form-control" id="current-pass" name="currentPass"
                                                value="">
                                        </div>
                                        <div class="mb-4">
                                            <label for="exampleInputPassword1" class="form-label fw-semibold">Kata sandi
                                                baru</label>
                                            <input type="password" class="form-control" id="new-pass" name="newPass"
                                                value="">
                                        </div>
                                        <div class="">
                                            <label for="exampleInputPassword1" class="form-label fw-semibold">Konfirmasi
                                                sandi</label>
                                            <input type="password" class="form-control" id="confirm-pass"
                                                name="newPass_confirmation" value="">
                                        </div>
                                        <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                            <button id="update-pass-button" type="submit"
                                                class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card w-100 position-relative overflow-hidden mb-0">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-semibold">Data Pribadi</h5>
                                    <p class="card-subtitle mb-4">Untuk mengubah detail pribadi Anda, edit dan simpan dari
                                        sini
                                    </p>
                                    <form action="{{ route('profile.update-biodata') }}" method="POST"
                                        id="biodata-update-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label for="exampleInputPassword1"
                                                        class="form-label fw-semibold">Nama</label>
                                                    <input type="text" class="form-control" id="username-input"
                                                        placeholder="Isi nama anda" value="{{ $user->name }}"
                                                        name="username">
                                                </div>
                                                <div class="mb-4">
                                                    <label for="exampleInputPassword1"
                                                        class="form-label fw-semibold">Email</label>
                                                    <input type="email" class="form-control" id="email-input"
                                                        placeholder="Masukkan email anda" value="{{ $user->email }}"
                                                        name="email">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label for="exampleInputPassword1" class="form-label fw-semibold">Nama
                                                        Panggilan</label>
                                                    <input type="text" class="form-control complex-colorpicker"
                                                        id="nickname-input" placeholder="Isi Nickname" name="nickname"
                                                        value="{{ $user->nickname }}">
                                                </div>
                                                <div class="mb-4">
                                                    <label for="exampleInputPassword1"
                                                        class="form-label fw-semibold">Tanggal Lahir</label>
                                                    <input type="text" class="form-control complex-colorpicker"
                                                        id="date-input" placeholder="YYYY/MM/DD" name="date">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.js"></script>
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    <script>
        flatpickr("#date-input", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "Y-m-d",
            maxDate: "10-10-2006",
            defaultDate: "{{ $user->tanggal_lahir }}"
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.preloader').show();
                },
                complete: function() {
                    $('.preloader').hide();
                },
            });

            $('#profile-image').on('click', function() {
                var inputFile = $('#photo-profile');

                inputFile.on('change', function(e) {
                    var file = e.target.files[0];
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $('#profile-image').attr('src', event.target.result);
                    };

                    reader.readAsDataURL(file);
                });

                inputFile.click();
            });

            // Ajax update photo
            $('#upload-button').on('click', function() {
                var formData = new FormData($('#upload-photo')[0]);

                $.ajax({
                    type: 'POST',
                    url: $('#upload-photo').attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#photo-profile-master').attr('src', "{{ asset('storage') }}" +
                                "/" +
                                response.avatar);
                            $('#photo-profile-nav').attr('src', "{{ asset('storage') }}" +
                                "/" +
                                response.avatar);
                            $('#photo-profile').val('');
                            toastr.success(response.success);
                        } else {
                            toastr.error(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'Terjadi kesalahan dalam permintaan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        toastr.error(errorMessage);
                    }
                });
            });

            //Ajax update password
            $('#change-password-form').on('submit', function(e) {
                e.preventDefault();

                var currentPass = $('#current-pass').val();
                var newPassword = $('#new-pass').val();
                var confirmPassword = $('#confirm-pass').val();

                if (!currentPass) {
                    toastr.error('Kata sandi saat ini harus diisi');
                    return;
                } else if (!newPassword) {
                    toastr.error('Kata sandi baru harus diisi');
                    return;
                } else if (!confirmPassword) {
                    toastr.error('Konfirmasi sandi harus diisi');
                    return;
                } else if (newPassword !== confirmPassword) {
                    toastr.error('Kata sandi baru dan konfirmasi tidak cocok');
                    return;
                }

                var form = $('#change-password-form')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: $('#change-password-form').attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.success);
                            $('#current-pass').val('');
                            $('#new-pass').val('');
                            $('#confirm-pass').val('');
                        } else {
                            toastr.error(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'Terjadi kesalahan dalam permintaan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        toastr.error(errorMessage);
                    }
                });
            });

            // Ajax delete photo
            $('#delete-photo').on('click', function() {
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus foto ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.success) {
                                    $('#profile-image').attr('src',
                                        'public/assets/images/profile/user-1.jpg');
                                    $('#photo-profile-master').attr('src',
                                        'public/assets/images/profile/user-1.jpg');
                                    $('#photo-profile-nav').attr('src',
                                        'public/assets/images/profile/user-1.jpg');
                                    toastr.success(response.success);
                                } else if (response.warning) {
                                    toastr.warning(response.warning);
                                }
                            },
                            error: function(xhr, status, error) {
                                var errorMessage = 'Terjadi kesalahan dalam permintaan';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                toastr.error(errorMessage);
                            }
                        })
                    }
                });
            });

            // Ajax update biodata
            $('#biodata-update-form').on('submit', function(e) {
                e.preventDefault();

                var nama = $('#username-input').val();
                var nickname = $('#nickname-input').val();

                if (nama.length > 30) {
                    toastr.warning('Nama maksimal 30 karakter');
                    return;
                }

                if (nickname.length > 30) {
                    toastr.warning('Nickname maksimal 30 karakter');
                    return;
                }

                var form = $(this);
                var formData = new FormData(form[0]);


                $.ajax({
                    type: 'POST',
                    url: $('#biodata-update-form').attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#nama-user-nav').text(response.user.name);
                            $('#email-user-nav').text(response.user.email);
                            toastr.success(response.success);
                        } else {
                            toastr.error(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'Terjadi kesalahan dalam permintaan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        toastr.error(errorMessage);
                    }
                });
            });
        });
    </script>
@endpush
