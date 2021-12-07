<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;
    protected $table = 'pelaporan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_rt',
        'id_user',
        'judul',
        'isi',
        'keterangan',
        'tgl_diproses',
        'gambar',
        'status'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
