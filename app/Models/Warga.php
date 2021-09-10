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
        'id_user',
        'nik',
        'alamat',
        'no_hp',
        'foto',
        'jml_anggota_keluarga',
        'no_kk',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function detailRt()
    {
        return $this->belongsTo(RT::class, 'id_rt', 'id');
    }
}
