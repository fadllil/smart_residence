<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;
    protected $table = 'administrator';
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'password',
        'email',
        'no_hp'
    ];
}
