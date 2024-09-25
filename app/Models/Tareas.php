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
        return $this->belongsTo(User::class);
    }

    public function incidencia(){
        return $this->belongsTo(Incidencias::class);
    }
}
