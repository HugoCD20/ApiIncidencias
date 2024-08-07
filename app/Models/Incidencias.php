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
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function tarea(){
        return $this->hasMany(Tareas::class);
    }
    public function asignacion(){
        return $this->hasMany(asignaciones::class);
    }
    public function prueba(){
        return $this->hasMany(Pruebas::class);
    }
}
