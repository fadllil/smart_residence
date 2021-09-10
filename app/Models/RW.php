<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RW extends Model
{
    use HasFactory;
    protected $table = 'rw';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kelurahan',
        'nama',
    ];

    public function detailKelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan', 'id');
    }
    public function rt()
    {
        return $this->hasMany(RT::class, 'id_rt', 'id');
    }
}
