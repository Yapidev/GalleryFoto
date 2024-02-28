<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;

class UploadOrUpdateController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman create photo
     *
     * @return void
     */
    public function create()
    {
        return view('form');
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

        return view('form', compact('photo'));
    }
}
