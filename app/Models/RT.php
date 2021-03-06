<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RT extends Model
{
    use HasFactory;
    protected $table = 'rt';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_rw',
        'nama'
    ];

    public function detailRw()
    {
        return $this->belongsTo(RW::class, 'id_rw', 'id');
    }
}
