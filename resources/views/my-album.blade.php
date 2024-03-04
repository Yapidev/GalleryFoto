@extends('layouts.app')

@push('style')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .photo-container {
            width: 100%;
            columns: 4;
            column-gap: 20px
        }

        .photo-container .box {
            width: 100%;
            margin-bottom: 10px;
            break-inside: avoid;
        }

        #img {
            max-width: 100%;
            border-radius: 15px;
        }

        @media (max-width: 1200px) {
            .photo-container {
                width: calc(100% - 40px);
                columns: 3;
            }
        }

        @media (max-width: 768px) {
            .photo-container {
                columns: 2;
            }
        }

        @media (max-width: 480px) {
            .photo-container {
                columns: 1;
            }
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            opacity: 0;
            transition: opacity 0.5s;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
        }

        .overlay:hover {
            opacity: 1;
            /* Munculkan overlay saat dihover */
        }

        .overlay h3 {
            margin: 0;
            padding: 10px;
            text-align: center;
            color: #fff;
        }

        .overlay-icons {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .overlay-icons a {
            display: inline-block;
            margin-right: 5px;
            color: #fff;
            font-size: 18px;
        }
    </style>
@endpush

@section('content')
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Album Saya</h4>
                    <p class="mb-8">Halaman yang berisi album yang sudah anda buat.</p>
                    <button data-bs-toggle="modal" data-bs-target="#add-album-modal" class="btn btn-primary">Tambah
                        Album</button>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt=""
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Header --}}

    {{-- Modal Upload Album --}}
    <div class="modal fade modal-tambah" id="add-album-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 " id="exampleModalLabel">Tambah Album</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambah" action="{{ route('upload-album') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center align-items-center">
                            <div class="mb-3">
                                <label class="form-label">Nama Album</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" type="text" name="name" placeholder="Nama Album"
                                    required>
                                <div id="name-error"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Album </label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" type="text" value=""
                                    name="description" placeholder="Deskripsi Perusahaan">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Upload Album --}}

    {{-- Foreach data album --}}
    <div class="photo-container w-100">
        {{-- Private Album --}}
        <div class="overflow-hidden box">
            <div class="position-relative">
                <a href="{{ route('private-album') }}">
                    <img id="img" src="{{ asset('assets/images/private-album-logo.jpg') }}"
                        class="card-img-top rounded-6" alt="...">
                    <div class="overlay d-flex flex-column">
                        <h4 class="card-title mb-1 text-light">Album Pribadi</h4>
                        <h6 class="card-text fw-normal text-light d-inline-block" style="max-width: 150px">
                            Berisi foto-foto anda, dengan visibilitas privat.
                        </h6>
                    </div>
                </a>
            </div>
        </div>
        {{-- Private Album --}}

        @forelse ($albums as $item)
            <div class="overflow-hidden box">
                <div class="position-relative">
                    <a href="{{ route('private-album') }}">
                        <img id="img" src="{{ asset('assets/images/pen.png') }}" class="card-img-top rounded-6"
                            alt="...">
                        <div class="overlay d-flex flex-column">
                            <h4 class="card-title mb-1 text-light truncate">{{ $item->name }}</h4>
                            <h6 class="card-text fw-normal text-light d-inline-block text-truncate">
                                {{ $item->description }}
                            </h6>
                            <div class="overlay-icons">
                                <a href=""><i class="ti ti-eye"></i></a>
                                <a href=""><i class="ti ti-edit"></i></a>
                                <a href=""><i class="ti ti-trash"></i></a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @empty
        @endforelse
    </div>
    {{-- Foreach data Album --}}
@endsection

@push('script')
@endpush
