<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanDetailIuran extends Model
{
    use HasFactory;
    protected $table = 'kegiatan_detail_iuran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_iuran',
        'id_user',
        'uang',
        'tgl_pembayaran',
        'status',
        'gambar',
        'keterangan'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
