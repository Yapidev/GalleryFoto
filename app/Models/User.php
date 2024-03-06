<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'tanggal_lahir',
        'nickname'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi has Many ke table fotos
     *
     * @return void
     */
    public function hasManyPhotos()
    {
        return $this->hasMany(Foto::class);
    }

    /**
     * Fungsi untuk mendapatkan foto dengan visibilitas privat
     *
     * @return void
     */
    public function privatePhotos()
    {
        return $this->hasManyPhotos()->whereVisibility('private');
    }

    /**
     * Relasi has Many ke table albums
     *
     * @return void
     */
    public function hasManyAlbums()
    {
        return $this->hasMany(Album::class);
    }

    /**
     * Relasi belongsToMany ke table like_fotos
     *
     * @return void
     */
    public function likes()
    {
        return $this->belongsToMany(Foto::class, 'like_fotos')->withTimestamps();
    }

    /**
     * Relasi belongsToMany ke table views
     *
     * @return BelongsToMany
     */
    public function viewedPhotos(): BelongsToMany
    {
        return $this->belongsToMany(Foto::class, 'views')->withTimestamps();
    }

    /**
     * Fungsi untuk mendapatkan penayangan terakhir user
     *
     * @param  mixed $photo_id
     * @return void
     */
    public function recentView($photo_id)
    {
        return $this->viewedPhotos()
            ->whereFoto_id($photo_id)
            ->whereDate('views.created_at', '>=', Carbon::now()->subDay())
            ->exists();
    }
}
