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
        'jenis',
        'keterangan',
        'tanggal',
    ];
}
