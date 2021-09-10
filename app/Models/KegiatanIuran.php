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
        'nominal'
    ];

    public function detailIuran()
    {
        return $this->hasMany(KegiatanDetailIuran::class, 'id', 'id_iuran');
    }
}
