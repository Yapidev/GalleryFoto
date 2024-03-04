@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
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
            top: 10px;
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
                    <h4 class="fw-semibold mb-8">Foto Favorit</h4>
                    <p class="mb-8">Halaman yang berisi foto yang anda sukai.</p>
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

    {{-- Foreach data photos --}}
    @if ($photos->isNotEmpty())
        <div class="photo-container">
            @foreach ($photos as $item)
                <div class="overflow-hidden box">
                    <div class="position-relative">
                        <a href="{{ route('private-album') }}">
                            <img id="img" src="{{ asset('storage/' . $item->file_path) }}"
                                class="card-img-top rounded-6" alt="...">
                            <div class="overlay d-flex flex-column">
                                <h4 class="card-title mb-1 text-light truncate">{{ $item->title }}</h4>
                                <h6 class="card-text fw-normal text-light d-inline-block text-truncate">
                                    {{ $item->description }}
                                </h6>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @include('components.no-data')
    @endif
    {{-- Foreach data photos --}}
@endsection

@push('script')
@endpush
