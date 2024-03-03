<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Views;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FotoController extends Controller
{
    /**
     * Fungsi untuk menampilkan detail foto
     *
     * @param  mixed $slug
     * @return void
     */
    public function view(string $slug)
    {

        $photo = Foto::query()
            ->whereSlug($slug)
            ->with('belongsToUser', 'hasManyComments')
            ->firstOrFail();

        if ($photo->visibility == 'private') {
            return back()->with('warning', 'Foto telah di privat, anda tidak memiliki akses');
        }

        $photos = Foto::query()
            ->whereNot('slug', $slug)
            ->inRandomOrder()
            ->with('belongsToUser')
            ->get();

        $userId = Auth::user()->id;

        if ($photo->user_id != $userId) {
            Views::create([
                'foto_id' => $photo->id,
                'user_id' => $userId
            ]);
        }

        return view('view-detail-photo', compact('photo', 'photos'));
    }

    /**
     * Fungsi untuk menghandle unggah foto
     *
     * @param  mixed $request
     * @return void
     */
    public function upload(Request $request)
    {
        // Validasi untuk field request yang masuk
        $request->validate([
            'title' => ['required', 'string', 'unique:fotos,title'],
            'description' => ['nullable', 'string'],
            'photo' => ['required', 'image']
        ]);

        if ($request->hasFile('photo')) {
            // Mengunggah file foto ke direktori 'photos' di sistem penyimpanan publik
            $file_path = $request->photo->store('photos', 'public');
        }

        $data = [
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'comment_permit' => $request->commentPermit ? true : false,
            'description' => $request->description ?: null,
            'file_path' => $file_path,
            'visibility' => $request->visibility
        ];

        // Membuat entitas Foto baru dengan data yang diterima
        Foto::create($data);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('home')->with('success', 'Berhasil mengunggah foto!');
    }

    /**
     * Fungsi untuk update foto
     *
     * @param  mixed $request
     * @param  mixed $foto
     * @return void
     */
    public function update(Request $request, Foto $photo)
    {
        $request->validate([
            'title' => ['required', 'string', 'unique:fotos,title,' . $photo->id],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'image']
        ]);

        $slug = Str::slug($request->title);

        $data = [
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
        ];

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($photo->file_path);
            $file_path = $request->photo->store('photos', 'public');
            $data['file_path'] = $file_path;
        }

        $photo->update($data);
        $photo->save();

        return redirect()->route('my-photo')->with('success', 'Berhasil memperbarui foto');
    }

    /**
     * Fungsi untuk menghapus foto
     *
     * @param  mixed $foto
     * @return void
     */
    public function delete(Foto $foto)
    {
        Storage::disk('public')->delete($foto->file_path);

        $foto->hasManyViews()->delete();

        $foto->delete();

        return back()->with('success', 'Berhasil menghapus foto');
    }
}
