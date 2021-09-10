<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    protected $table = 'provinsi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
    ];

    public function kabKota()
    {
        return $this->hasMany(KabKota::class, 'id_kab_kota', 'id');
    }
}
