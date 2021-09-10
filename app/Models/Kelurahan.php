<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;
    protected $table = 'kelurahan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kecamatan',
        'nama',
    ];

    public function detailKecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function rw()
    {
        return $this->hasMany(RW::class, 'id_rw', 'id');
    }
}
