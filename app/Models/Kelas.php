<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama',
        'progdi_id'
    ];

    public function progdi()
    {
        return $this->belongsTo(Progdi::class, 'progdi_id');
    }
}
