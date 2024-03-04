@extends('layouts.app')

@push('style')
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
    </style>
@endpush

@section('content')
    @if (isset($private_photos))
        {{-- Header --}}
        <div class="card w-100 bg-light-info overflow-hidden shadow-none">
            <div class="card-body py-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h5 class="fw-semibold mb-9 fs-5">Ini adalah isi dari album "Privat" anda</h5>
                        <p class="mb-9">
                            Anda bisa menambah, mengedit, dan menghapus foto-foto yang ada di dalam album pribadi anda
                        </p>
                        <button data-bs-toggle="modal" data-bs-target="#add-album-modal" class="btn btn-primary">Upload Foto
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
            @forelse ($private_photos as $item)
                <div class="col-12 col-md-4 my-3">
                    <div class="card-custome rounded-4">
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
                @include('components.no-data')
            @endforelse
        </div>
        {{-- Foreach data photos --}}
    @else
        {{-- Header --}}
        <div class="card w-100 bg-light-info overflow-hidden shadow-none">
            <div class="card-body py-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h5 class="fw-semibold mb-9 fs-5">Ini adalah isi dari album berjudul "{{ $album->name }}"</h5>
                        <p class="mb-9">
                            Anda bisa menambah, mengedit, dan menghapus foto-foto yang ada di dalam album anda
                        </p>
                        <button data-bs-toggle="modal" data-bs-target="#add-album-modal" class="btn btn-primary">Upload
                            Album
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
            @forelse ($album->hasManyAlbumDetails as $item)
                <div class="col-12 col-md-4 my-3">
                    <div class="card-custome rounded-4">
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
                @include('components.no-data')
            @endforelse
        </div>
        {{-- Foreach data photos --}}
    @endif
@endsection

@push('script')
@endpush
