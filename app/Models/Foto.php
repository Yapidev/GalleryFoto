<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    /**
     * Kecualikan atribut "id" dari mass assignment atau pengisian massal.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'fotos';

    /**
     * Relasi belongs to one ke table users
     *
     * @return void
     */
    public function belongsToUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi has Many ke table views
     *
     * @return void
     */
    public function hasManyViews()
    {
        return $this->hasMany(views::class);
    }

    /**
     * Fungsi untuk menghitung jumlah relasi hasManyViews
     *
     * @return void
     */
    public function viewsCount()
    {
        return $this->hasManyViews->count();
    }

    /**
     * Relasi has Many ke table KomentarFotos
     *
     * @return void
     */
    public function hasManyComments()
    {
        return $this->hasMany(KomentarFoto::class);
    }

    /**
     * Fungsi untuk menghitung jumlah komentar
     *
     * @return void
     */
    public function commentsCount()
    {
        return $this->hasManyComments->count();
    }
}
