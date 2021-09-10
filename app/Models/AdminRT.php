<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRT extends Model
{
    use HasFactory;
    protected $table = 'admin_rt';
    public $timestamps = false;
    protected $fillable = [
        'id_rt',
        'id_user',
        'nik',
        'no_hp',
        'alamat',
        'jabatan'
    ];

    public function detailRt()
    {
        return $this->belongsTo(RT::class, 'id_rt', 'id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
