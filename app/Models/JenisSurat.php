<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;
    protected $table = 'jenis_surat';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_rt',
        'jenis'
    ];
}
