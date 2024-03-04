@extends('layouts.app')

@push('style')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #comments-container {
            max-height: 500px;
            /* Batas tinggi kontainer komentar */
            overflow-y: auto;
            /* Mengaktifkan scroll jika konten melebihi batas tinggi */
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

            #row {
                gap: 0.5rem;
            }
        }

        @media (max-width: 768px) {
            .photo-container {
                columns: 2;
            }

            #row {
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .photo-container {
                columns: 1;
            }

            #row {
                gap: 0.5rem;
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

    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush

@section('content')
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Detail Foto</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none"
                                    href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Detail Foto</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="" id="foto"
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Photo content --}}
    <div class="card shadow-none border">
        <div class="card-body p-0">
            <div class="row" id="row">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                        <img src="{{ Storage::url($photo->file_path) }}" alt="" class="w-100 h-auto rounded-2"
                            id="foto">
                    </div>
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-between">

                    {{-- Detail Info Section --}}
                    <div class="shop-content">
                        <h4 class="fw-semibold text-capitalize">{{ $photo->title }}</h4>
                        @if ($photo->description)
                            <p class="mb-3">{{ $photo->description }}</p>
                        @else
                            <p class="mb-3">Foto ini tidak memiliki deskripsi.</p>
                        @endif
                        <div class="d-flex align-items-center gap-4 pb-2">
                            {{-- jumlah views --}}
                            <div class="d-flex align-items-center gap-2">
                                <i class="ti ti-eye text-dark fs-5"></i>
                                {{ $photo->viewsCount() }}
                            </div>
                            {{-- jumlah views --}}

                            {{-- jumlah like --}}
                            <div class="d-flex align-items-center gap-2 heart-icon cursor-pointer"
                                onclick="toggleLike('{{ route('like-photo', $photo->id) }}')">
                                <i class="fas fa-heart fs-5 {{ $photo->isLiked() ? 'text-danger' : '' }}"></i>
                                <span id="like-count">{{ $photo->likesCount() }}</span>
                            </div>
                            {{-- jumlah like --}}

                            {{-- jumlah download --}}
                            <div class="d-flex align-items-center gap-2 cursor-pointer">
                                <a href="{{ route('download-photo', $photo->id) }}">
                                    <i class="ti ti-download text-dark fs-5"></i>
                                </a>
                                <span id="download-count">{{ $photo->downloads }}</span>
                            </div>
                            {{-- jumlah download --}}

                            <div class="d-flex align-itemsn-center fs-2 ms-auto"><i
                                    class="ti ti-point text-dark"></i>{{ $photo->created_at->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </div>

                    {{-- Main Komentar Section --}}
                    @if ($photo->comment_permit == true)
                        <div class="position-relative py-4">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <h4 class="mb-0 fw-semibold">Jumlah Komentar</h4>
                                <span id="comment-count"
                                    class="badge bg-light-primary text-primary fs-4 fw-semibold px-6 py-8 rounded">{{ $photo->commentsCount() }}</span>
                            </div>
                            {{-- Comment Section --}}
                            <div id="comments-container">
                                @forelse ($photo->hasManyComments as $item)
                                    <div class="p-4 rounded-2 bg-light mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ asset($item->belongsToUser->avatar ? 'storage/' . $item->belongsToUser->avatar : 'assets/images/profile/user-1.jpg') }}"
                                                alt="" class="rounded-circle" width="33" height="33"
                                                style="object-fit: cover">
                                            <h6 class="fw-semibold mb-0 fs-4">{{ $item->belongsToUser->name }}</h6>
                                            <p class="text-muted mb-0">{{ $item->created_at->diffForHumans() }}</p>
                                            <div class="ms-auto">
                                                <div class="dropdown">
                                                    <a class="" href="javascript:void(0)" id="m1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-4"></i>
                                                    </a>
                                                    @if ($item->user_id == Auth::user()->id)
                                                        <ul class="dropdown-menu" aria-labelledby="m1">
                                                            <li>
                                                                <form action="{{ route('delete-comment', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item delete-btn">
                                                                        <i
                                                                            class="ti ti-trash text-muted me-1 fs-4"></i>Hapus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <p class="my-3">{{ $item->content }}</p>
                                    </div>
                                @empty
                                    Tidak ada komentar.
                                @endforelse
                            </div>
                            {{-- Comment Section --}}
                        </div>
                    @endif
                    {{-- Main Komentar Section --}}

                    {{-- Upload Komentar Section --}}
                    @if ($photo->comment_permit == true)
                        <div class="comment mt-auto sticky-comment-section">
                            <h4 class="mb-4 fw-semibold">Beri Komentar</h4>
                            <form id="komentar-form" action="{{ route('post-comment', ['foto_id' => $photo->id]) }}"
                                method="POST">
                                @csrf
                                @method('POST')
                                <textarea id="comment-content" class="form-control mb-2" name="content" rows="5"></textarea>
                                <button id="submit-comment" class="btn btn-primary">Kirim Komentar</button>
                            </form>
                        </div>
                    @endif
                    {{-- Upload Komentar Section --}}

                </div>
            </div>
        </div>
    </div>
    {{-- Photo content --}}

    {{-- Foto Lainnya --}}
    <div class="related-products pt-7">
        <h4 class="mb-3 fw-semibold">Jelajahi foto lain nya..</h4>
        <div class="photo-container w-100">
            @forelse ($other_photos as $item)
                <div class="overflow-hidden box">
                    <div class="position-relative">
                        <a href="{{ route('view-detail-photo', $item->slug) }}">
                            <img id="img" src="{{ Storage::url($item->file_path) }}" class="card-img-top rounded-4"
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
                                src="{{ $item->belongsToUser->avatar ? Storage::url($item->belongsToUser->avatar) : asset('assets/images/profile/user-1.jpg') }}"
                                alt="Profile Picture" style="width: 40px; height: 40px;">
                            <span class="fw-bold">{{ $item->belongsToUser->name }}</span>
                        </div>
                    </div>
                </div>
            @empty
                Tidak ada foto lain nya.
            @endforelse
        </div>
    </div>
    {{-- Foto Lainnya --}}
@endsection

@push('script')
    {{-- Script untuk comment --}}
    <script>
        $(document).ready(function() {
            $('#komentar-form').on('submit', function(e) {
                e.preventDefault();

                commentContent = $('#comment-content').val();

                if (!commentContent) {
                    $('#error-comment').text('Komentar tidak boleh kosong!');
                } else {
                    $('#error-comment').text('');
                    this.submit();
                }
            })
        });
    </script>

    {{-- Script untuk delete komentar --}}
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();

                var form = $(this).closest('form');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus komentar ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    {{-- Script untuk delete komentar --}}

    {{-- Script untuk like dan unlike --}}
    <script>
        function toggleLike(url) {
            $.ajax({
                url: url,
                type: 'POST',
                success: function(response) {
                    $('#like-count').text(response.likes_count);
                    if (response.is_liked) {
                        $('.heart-icon i').addClass('text-danger');
                    } else {
                        $('.heart-icon i').removeClass('text-danger');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
    {{-- Script untuk like dan unlike --}}

    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
@endpush
