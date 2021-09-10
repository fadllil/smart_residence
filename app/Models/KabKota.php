<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabKota extends Model
{
    use HasFactory;
    protected $table = 'kab_kota';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_provinsi',
        'nama',
    ];

    public function detailProvinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi', 'id');
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'id_kecamatan', 'id');
    }
}
