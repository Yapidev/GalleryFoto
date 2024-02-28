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
            columns: 5;
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
    </style>
@endpush

@section('content')
    {{-- Header --}}
    <div class="card w-100 bg-light-info overflow-hidden shadow-none">
        <div class="card-body py-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-6">
                    <h5 class="fw-semibold mb-9 fs-5">Selamat datang! {{ Auth::user()->name }}</h5>
                    <p class="mb-9">
                        Upload karyamu disini
                    </p>
                    <a class="btn btn-primary" href="{{ route('create-photo') }}">Upload Foto
                        Sekarang</a>
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

    {{-- Card post --}}
    <div class="photo-container w-100">
        @forelse ($photos as $item)
            <div class="overflow-hidden box">
                <div class="position-relative">
                    <a href="{{ route('view-detail-photo', $item->slug) }}">
                        <img id="img" src="{{ Storage::url($item->file_path) }}" class="card-img-top rounded-6"
                            alt="...">
                        <div class="overlay d-flex flex-column">
                            <h3>{{ $item->title }}</h3>
                            <p>{{ $item->description }}</p>
                        </div>
                    </a>
                </div>
                <div class="p-2 pt-1">
                    <div class="d-flex gap-2 align-items-center pt-2">
                        <img class="rounded-circle"
                            src="{{ Storage::url($item->belongsToUser->avatar) ?: asset('assets/images/profile/user-1.jpg') }}"
                            alt="Profile Picture" style="width: 40px; height: 40px;">
                        <span class="fw-bold">{{ $item->belongsToUser->name }}</span>
                    </div>
                </div>
            </div>
        @empty
            tidak ada data
        @endforelse
    </div>
    {{-- Card post --}}
@endsection

@push('script')
@endpush
