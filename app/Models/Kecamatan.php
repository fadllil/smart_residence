<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'kecamatan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kabkota',
        'nama',
    ];

    public function detailKabKota()
    {
        return $this->belongsTo(KabKota::class, 'id_kabkota', 'id');
    }

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class, 'id_kelurahan', 'id');
    }
}
