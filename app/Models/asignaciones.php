<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asignaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'incidencia_id',
    ];

    // Un Asignacion pertenece a un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un Asignacion pertenece a una Incidencia
    public function incidencia()
    {
        return $this->belongsTo(Incidencias::class);
    }
}
