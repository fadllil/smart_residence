<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanAnggota extends Model
{
    use HasFactory;
    protected $table = 'kegiatan_anggota';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kegiatan',
        'status',
        'maksimal_anggota'
    ];

    public function kegiatan(){
        return $this->hasOne(Kegiatan::class, 'id', 'id_kegiatan');
    }

    public function detailAnggota(){
        return $this->hasMany(KegiatanDetailAnggota::class, 'id_kegiatan_anggota', 'id');
    }
}
