<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;
    protected $table = 'informasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_rt',
        'judul',
        'isi',
        'keterangan',
        'tanggal',
        'gambar'
    ];

    public function rt()
    {
        return $this->hasOne(RT::class, 'id_rt', 'id');
    }
}
