<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanIuran extends Model
{
    use HasFactory;
    protected $table = 'kegiatan_iuran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kegiatan',
        'status',
        'nominal',
        'tgl_terakhir_pembayaran'
    ];

    public function detailIuran()
    {
        return $this->hasMany(KegiatanDetailIuran::class, 'id_iuran', 'id');
    }

    public function getIuran()
    {
        return $this->hasOne(KegiatanDetailIuran::class, 'id_iuran', 'id');
    }

    public function Kegiatan()
    {
        return $this->hasOne(Kegiatan::class, 'id', 'id_kegiatan');
    }
}
