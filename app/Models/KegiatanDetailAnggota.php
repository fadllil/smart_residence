<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanDetailAnggota extends Model
{
    use HasFactory;
    protected $table = 'kegiatan_detail_anggota';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kegiatan_anggota',
        'id_user',
        'nama_didaftarkan',
        'keterangan'
    ];
}
