<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_rt',
        'id_user',
        'id_jenis_surat',
        'keterangan',
        'tanggal',
    ];

    public function jenisSurat()
    {
        return $this->hasOne(JenisSurat::class, 'id', 'id_jenis_surat');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
