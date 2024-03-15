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
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="card overflow-hidden">
            <div class="card-body p-0">
                <img src="{{ asset('assets/images/backgrounds/profilebg.jpg') }}" alt="" class="img-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-4 order-lg-1 order-2">
                        <div class="d-flex align-items-center justify-content-around m-4">

                            {{-- Jumlah Foto --}}
                            <div class="text-center">
                                <i class="ti ti-photo fs-6 d-block mb-2"></i>
                                <h4 class="mb-0 fw-semibold lh-1">{{ $user->photosCount() }}</h4>
                                <p class="mb-0 fs-4">Foto</p>
                            </div>
                            {{-- Jumlah Foto --}}

                            {{-- Jumlah Pengikut --}}
                            <div class="text-center cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#followers-modal">
                                <i class="ti ti-user-circle fs-6 d-block mb-2"></i>
                                <h4 class="mb-0 fw-semibold lh-1">{{ $user->followers()->count() }}</h4>
                                <p class="mb-0 fs-4">Pengikut</p>
                            </div>
                            {{-- Jumlah Pengikut --}}

                            {{-- Modal Pengikut --}}
                            <div class="modal fade" id="followers-modal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content rounded-1">
                                        <div class="modal-body message-body" data-simplebar="">
                                            <h5 class="mb-0 fs-5 p-1">List user yang mengikuti
                                                {{ $user->id != auth()->id() ? $user->name : 'Anda' }}</h5>
                                            <ul class="list mb-0 py-2">
                                                {{-- Forelse Followers --}}
                                                @forelse ($followers as $item)
                                                    <li class="p-1 mb-1 bg-hover-light-black">
                                                        <a href="{{ route('profile-public', encrypt($item->id)) }}">
                                                            <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                                <img src="{{ asset($item->avatar ? 'storage/' . $item->avatar : 'assets/images/profile/user-1.jpg') }}"
                                                                    class="rounded-circle" style="object-fit: cover"
                                                                    width="50" height="50" alt="" />
                                                                <div class="ms-3 d-flex gap-2">
                                                                    <i class="ti ti-user fs-4"></i>
                                                                    <h5 class="mb-1 fs-3">{{ $item->name }}</h5>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li class="p-1 mb-1 bg-hover-light-black">User ini tidak memiliki
                                                        pengikut.</li>
                                                @endforelse
                                                {{-- Forelse Followers --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal Pengikut --}}

                            {{-- Jumlah Mengikuti --}}
                            <div class="text-center cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#followings-modal">
                                <i class="ti ti-user-check fs-6 d-block mb-2"></i>
                                <h4 class="mb-0 fw-semibold lh-1">{{ $user->following()->count() }}</h4>
                                <p class="mb-0 fs-4">Mengikuti</p>
                            </div>
                            {{-- Jumlah Mengikuti --}}

                            {{-- Modal Mengikuti --}}
                            <div class="modal fade" id="followings-modal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content rounded-1">
                                        <div class="modal-body message-body" data-simplebar="">
                                            <h5 class="mb-0 fs-5 p-1">List user yang di ikuti oleh
                                                {{ $user->id != auth()->id() ? $user->name : 'Anda' }}</h5>
                                            <ul class="list mb-0 py-2">
                                                {{-- Forelse Followings --}}
                                                @forelse ($followings as $item)
                                                    <li class="p-1 mb-1 bg-hover-light-black">
                                                        <a href="{{ route('profile-public', encrypt($item->id)) }}">
                                                            <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                                <img src="{{ asset($item->avatar ? 'storage/' . $item->avatar : 'assets/images/profile/user-1.jpg') }}"
                                                                    class="rounded-circle" style="object-fit: cover"
                                                                    width="50" height="50" alt="" />
                                                                <div class="ms-3 d-flex gap-2">
                                                                    <i class="ti ti-user fs-4"></i>
                                                                    <h5 class="mb-1 fs-3">{{ $item->name }}</h5>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li class="p-1 mb-1 bg-hover-light-black">User ini tidak mengikuti
                                                        siapapun.</li>
                                                @endforelse
                                                {{-- Forelse Followings --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal Mengikuti --}}

                        </div>
                    </div>
                    <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                        <div class="mt-n5">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle"
                                    style="width: 110px; height: 110px;";>
                                    <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden"
                                        style="width: 100px; height: 100px;";>
                                        <img src="{{ asset($user->avatar ? 'storage/' . $user->avatar : 'assets/images/profile/user-1.jpg') }}"
                                            alt="" class="w-100 h-100" style="object-fit: cover">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="fs-5 mb-0 fw-semibold" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                    {{ Str::limit($user->name, 20) }}</h5>
                                @if ($user->nickname)
                                    <p class="mb-0 fs-4">{{ $user->nickname }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($user->id != Auth::user()->id)
                        <div class="col-lg-4 order-last">
                            <ul
                                class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-start my-3 gap-3">
                                @if (Auth::user()->followed($user->id))
                                    <form action="{{ route('follow', $user->id) }}" method="POST">
                                        @csrf
                                        <li><button class="btn btn-muted" type="submit">Telah di ikuti <i
                                                    class="ti ti-user-check"></i></button></li>
                                    </form>
                                @else
                                    <form action="{{ route('follow', $user->id) }}" method="POST">
                                        @csrf
                                        <li><button class="btn btn-primary" type="submit">Ikuti <i
                                                    class="ti ti-user"></i></button></li>
                                    </form>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card post --}}
        @if ($photos->isNotEmpty())
            <div class="photo-container w-100">
                @foreach ($photos as $item)
                    <div class="overflow-hidden box">
                        <div class="position-relative">
                            <a href="{{ route('view-detail-photo', $item->slug) }}">
                                <img id="img" src="{{ Storage::url($item->file_path) }}"
                                    class="card-img-top rounded-6" alt="...">
                                <div class="overlay d-flex flex-column">
                                    <h3>{{ Str::limit($item->title, 20) }}</h3>
                                    <p>{{ Str::limit($item->description, 20) }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            @include('components.no-data')
        @endif
        {{-- Card post --}}

    </div>
@endsection

@push('script')
@endpush
