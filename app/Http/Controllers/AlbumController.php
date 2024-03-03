<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman Album saya
     *
     * @return void
     */
    public function index()
    {
        $private = Foto::query()
            ->whereuser_id(Auth::user()->id)
            ->wherevisibility('private')
            ->first();

        $albums = Album::query()
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('my-album', compact('albums', 'private'));
    }

    /**
     * Fungsi untuk menampilkan halaman detail album
     *
     * @param  mixed $album
     * @return void
     */
    public function detail(Album $album)
    {
        return view('album-detail', compact('album'));
    }

    /**
     * Fungsi untuk menghandle upload album
     *
     * @param  mixed $request
     * @return void
     */
    public function upload(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        $data = [
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description
        ];

        Album::create($data);

        return back()->with('success', 'Berhasil menambah album');
    }

    /**
     * Fungsi untuk menghandle delete data album
     *
     * @param  mixed $album
     * @return void
     */
    public function delete(Album $album)
    {
        $album->delete();
        $album->save();

        return back()->with('success', 'Berhasil menghapus album');
    }

    /**
     * Fungsi untuk menampilkan halaman private-album
     *
     * @return void
     */
    public function private()
    {
        $private_photos = Foto::query()
            ->whereuser_id(Auth::user()->id)
            ->wherevisibility('private')
            ->latest()
            ->get();

        return view('album-detail', compact('private_photos'));
    }
}
