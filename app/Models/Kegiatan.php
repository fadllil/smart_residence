<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = 'kegiatan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_rt',
        'nama',
        'tgl_mulai',
        'tgl_selesai',
        'lokasi',
        'status',
        'gambar',
        'catatan'
    ];

    public function anggota()
    {
        return $this->hasOne(KegiatanAnggota::class, 'id_kegiatan', 'id');
    }
    public function iuran()
    {
        return $this->hasOne(KegiatanIuran::class, 'id_kegiatan', 'id');
    }
}
