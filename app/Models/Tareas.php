<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{
    use HasFactory;

    protected $fillable=[
        "user_id",
        "incidencia_id",
        "titulo",
        "descripcion",
        "estado"
    ];
    public function user(){
        return $this->hasMany(User::class);
    }

    public function incidencia(){
        return $this->hasMany(Incidencias::class);
    }
}
