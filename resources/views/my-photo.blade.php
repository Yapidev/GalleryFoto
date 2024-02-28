@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <style>
        .card-custome {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 200px;
        }

        .card-image {
            position: relative;
        }

        .card {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .card-custome:hover .card-overlay {
            opacity: 1;
        }

        .card-body {
            padding: 20px;
        }

        .text-light {
            color: #fff;
            /* Set the text color to light */
        }

        .card-custome:hover .card {
            filter: brightness(60%);
        }

        .modal-edit .modal-body .preview-map {
            height: 680px;
        }

        .modal-tambah .modal-body .preview-map {
            height: 680px;
            border-radius: 20px;
        }

        @media only screen and (max-width: 768px) {
            .modal-edit .modal-body .preview-map {
                height: 300px;
                margin-bottom: 20px;
            }

            .modal-tambah .modal-body .preview-map {
                height: 300px;
                margin-bottom: 20px;
            }
        }
    </style>
@endpush

@section('content')
    {{-- Header --}}
    <div class="card w-100 bg-light-info overflow-hidden shadow-none">
        <div class="card-body py-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-6">
                    <h5 class="fw-semibold mb-9 fs-5">Ini adalah daftar foto yang telah anda upload</h5>
                    <p class="mb-9">
                        Anda bisa menambah, mengedit, dan menghapus foto-foto anda
                    </p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#upload-foto-modal">Upload Foto
                        Sekarang!</button>
                </div>
                <div class="col-sm-5">
                    <div class="position-relative mb-n7 text-end">
                        <img src="{{ asset('assets/images/backgrounds/welcome-bg2.png') }}" alt=""
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Header --}}

    {{-- Foreach data photos --}}
    <div class="row">
        @forelse ($photos as $item)
            <div class="col-12 col-md-4 my-3">
                <div class="card-custome">
                    <div class="card-image">
                        <a href="javascript:void(0)" class="card text-white w-100 card-hover"
                            style="background: url('{{ asset('storage/' . $item->file_path) }}') center; background-size: cover; width: 100%; height: 200px; object-fit: cover;">
                        </a>
                    </div>
                    <div class="card-overlay">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-auto">
                                    <div class="d-flex mt-4">
                                        <a href="{{ route('edit-photo', $item->id) }}" class="me-2 fs-5" style="border: none; background: transparent;"><i
                                                class="ti ti-edit text-white edit-btn"></i></a>
                                        <form id="deleteForm" action="{{ route('delete-photo', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button style="border: none; background: transparent;" type="button"
                                                class="fs-5 text-danger cursor-pointer"><i
                                                    class="ti ti-trash  delete-btn"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 100px">
                                <h4 class="card-title mb-1 text-light">{{ $item->title }}</h4>
                                <h6 class="card-text fw-normal text-light d-inline-block text-truncate"
                                    style="max-width: 150px">
                                    {{ $item->description }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            Tidak ada data.
        @endforelse
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    {{-- Script untuk validasi modal unggah foto --}}
    <script>
        $(document).ready(() => {
            const form = $('#upload-foto-form');
            form.on('submit', (event) => {
                event.preventDefault();

                // Mendapatkan nilai input judul dan foto
                const judulInput = $('#judul-input').val();
                const fotoInput = $('#formFileLg').val();

                // declare variable checkerror
                let error = false;

                // Memeriksa apakah input judul kosong
                if (judulInput.trim() === '') {
                    // Menampilkan pesan kesalahan untuk input judul
                    $('#error-judul').text('*Judul tidak boleh kosong.');
                    error = true;
                } else {
                    $('#error-judul').text('');
                }

                // Memeriksa apakah input foto kosong
                if (fotoInput.trim() === '') {
                    // Menampilkan pesan kesalahan untuk input foto
                    $('#error-foto').text('*Foto tidak boleh kosong.');
                    error = true;
                } else {
                    $('#error-judul').text('');
                }

                // Jalankan jika variable error bernilai false
                if (error === false) {
                    // Jika input judul dan foto tidak kosong, submit formulir
                    form.off('submit').submit();
                }
            });

            $('.delete-btn').on('click', function() {

                var form = $(this).closest('form');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus foto ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            })
        })
    </script>
@endpush
