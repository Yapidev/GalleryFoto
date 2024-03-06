<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadOrUpdateController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman create photo
     *
     * @return void
     */
    public function create()
    {
        return view('form-photo');
    }

    /**
     * Fungsi untuk menampilkan halaman edit photo
     *
     * @param  mixed $photo
     * @return void
     */
    public function edit(Foto $photo)
    {
        if ($photo->user_id != auth()->id()) {
            return back()->with('warning', 'Anda tidak memiliki izin');
        }

        $albums = Album::query()
            ->whereuser_id(Auth::user()->id)
            ->latest()
            ->get();

        return view('form-photo', compact('photo', 'albums'));
    }
}
