@extends('layouts.app')

@section('content')
    {{-- Header --}}
    <div class="card w-100 bg-light-info overflow-hidden shadow-none">
        <div class="card-body py-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-6">
                    <h5 class="fw-semibold mb-9 fs-5">Selamat datang! {{ Auth::user()->name }}</h5>
                    <p class="mb-9">
                        Upload karyamu disini!
                    </p>
                    <a href="{{ route('create-photo') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-post-modal">Upload Foto
                        Sekarang!</a>
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
    <div class="row">
        <div class="col-lg-4">
            <div class="card rounded-2 overflow-hidden hover-img">
                <div class="position-relative">
                    <a href=""><img src="{{ asset('assets/images/poto.png') }}" class="card-img-top rounded-0"
                            style="" alt="..."></a>
                    <span
                        class="badge bg-white text-dark fs-2 rounded-4 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                        Menit Lalu</span>
                </div>
                <div class="card-body p-4">
                    <a class="d-block my-0 fs-5 text-dark fw-semibold" href="#">Poto menfess ku aw aw :3</a>
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2"><i class="ti ti-eye text-dark fs-5"></i>9,125</div>
                        <div class="d-flex align-items-center gap-2"><i class="ti ti-message-2 text-dark fs-5"></i>4</div>
                        <div class="d-flex align-items-center fs-2 ms-auto"><i class="ti ti-point text-dark"></i>Senin, Dec
                            23</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Card post --}}
@endsection
