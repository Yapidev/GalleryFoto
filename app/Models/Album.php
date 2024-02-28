<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
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
    protected $table = 'albums';

    /**
     * Relasi belongs To ke table users
     *
     * @return void
     */
    public function belongsToUser()
    {
        return $this->belongsTo(User::class);
    }
}
