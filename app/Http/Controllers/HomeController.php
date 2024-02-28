<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan Halaman utama dari aplikasi Photopie.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $photos = Foto::query()
            ->inRandomOrder()
            ->with('belongsToUser')
            ->get();

        return view('home', compact('photos'));
    }
}
