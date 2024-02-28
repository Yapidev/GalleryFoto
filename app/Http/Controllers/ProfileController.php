<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    protected function profilePage()
    {
        $user = Auth::user();
        return response()->view('profile', compact('user'));
    }

    protected function updatePhotoProfileProcess(Request $request)
    {
        try {
            $request->validate([
                'photoProfile' => 'required|image|max:2048'
            ], [
                'photoProfile.required' => 'Foto profil harus di isi!',
                'photoProfile.image' => 'Foto harus berupa gambar!',
                'photoProfile.max' => 'Ukuran foto profil maksimal 2MB'
            ]);

            $user = User::find(Auth::user()->id);

            if ($request->hasFile('photoProfile')) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $nameImage = $request->photoProfile->store('avatars', 'public');
                $user->update(['avatar' => $nameImage]);
            }

            return response()->json(['success' => 'Berhasil mengunggah foto', 'avatar' => $user->avatar], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengunggah foto', 'message' => $e->getMessage()], 422);
        }
        return response()->json(['error' => 'Gagal mengunggah foto'], 500);
    }

    protected function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'currentPass' => 'required',
                'newPass' => 'required|string|min:8|confirmed'
            ], [
                'currentPass.required' => 'Kata sandi saat ini wajib diisi.',
                'newPass.required' => 'Kata sandi baru wajib diisi.',
                'newPass.string' => 'Kata sandi baru harus berupa teks.',
                'newPass.min' => 'Kata sandi baru minimal 8 karakter.',
                'newPass.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            ]);

            $user = User::find(Auth::user()->id);

            if (!Hash::check($request->currentPass, $user->password)) {
                return response()->json([
                    'error' => 'Gagal mengubah password',
                    'message' => 'Kata sandi saat ini salah.'
                ], 422);
            }

            $user->update(['password' => bcrypt($request->newPass)]);

            return response()->json(['success' => 'Kata sandi berhasil diperbarui.', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengubah password', 'message' => $e->getMessage()], 422);
        }
        return response()->json(['error' => 'Gagal mengubah password'], 500);
    }

    protected function deletePhoto()
    {
        try {
            $user = User::findOrFail(Auth::user()->id);
            if ($user->avatar != null) {
                Storage::disk('public')->delete($user->avatar);
                $user->avatar = null;
                $user->save();
                return response()->json(['success' => 'Foto profil berhasil di hapus.'], 200);
            }
            return response()->json(['warning' => 'Anda tidak memiliki foto profil']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus foto profil', 'message' => $e->getMessage()], 422);
        }
    }

    protected function updateBiodata(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $request->validate([
                'username' => [
                    'string',
                    'max:30',
                    'nullable',
                    Rule::unique('users', 'name')->ignore($userId)
                ],
                'email' => [
                    'email',
                    'nullable',
                    Rule::unique('users', 'email')->ignore($userId)
                ],
                'nickname' => [
                    'string',
                    'max:30',
                    'nullable',
                    Rule::unique('users', 'nickname')->ignore($userId)
                ],
                'date' => 'date|before:today|nullable',
            ]);

            $user = User::find($userId);

            if ($request->has('username')) {
                $user->name = $request->username;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('nickname')) {
                $user->nickname = $request->nickname;
            }

            if ($request->has('date')) {
                $user->tanggal_lahir = $request->date;
            }

            $user->save();
            $user = $user->only('name', 'email');

            return response()->json(['success' => 'Berhasil update biodata!', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengupdate biodata', 'message' => $e->getMessage()], 422);
        }
    }
}
