<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_rt',
        'id_kegiatan',
        'nominal',
        'keterangan',
    ];

    public function kegiatan()
    {
        return $this->hasOne(Kegiatan::class, 'id', 'id_kegiatan');
    }
}
