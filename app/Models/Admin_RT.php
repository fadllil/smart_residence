<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_RT extends Model
{
    use HasFactory;
    protected $table = 'admin_rt';
    public $timestamps = false;
    protected $fillable = [
        'id_rt',
        'nik',
        'nama',
        'email',
        'no_hp',
        'alamat',
        'password',
        'jabatan'
    ];
}
