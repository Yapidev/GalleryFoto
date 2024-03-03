<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Fungsi untuk like dan unlike foto
     *
     * @param  mixed $photo
     * @return void
     */
    public function like(Foto $photo)
    {
        $userId = Auth::user()->id;

        $isLiked = $photo->likes()->where('user_id', $userId)->exists();

        if ($isLiked) {
            $photo->likes()->detach($userId);
        } else {
            $photo->likes()->attach($userId);
        }

        $likesCount = $photo->likesCount();

        return response()->json(['likes_count' => $likesCount, 'is_liked' => !$isLiked]);
    }
}
