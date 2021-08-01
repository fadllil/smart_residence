<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'warga';
    protected $fillable = [
        'id_rt',
        'nama',
        'nik',
        'alamat',
        'no_hp',
        'foto',
        'jml_anggota_keluarga',
        'email',
        'no_kk',
        'password',
    ];
}
