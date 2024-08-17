<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencias extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'evidencias',
        'etapa',
    ];

    // Una Incidencia pertenece a un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Una Incidencia puede tener muchas Tareas
    public function tarea()
    {
        return $this->hasMany(Tareas::class);
    }

    // Una Incidencia puede tener muchas Asignaciones
    public function asignaciones()
    {
        return $this->hasMany(Asignaciones::class);
    }

    // Una Incidencia puede tener muchas Pruebas
    public function prueba()
    {
        return $this->hasMany(Pruebas::class);
    }
}
