<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TareaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "titulo"=> $this->titulo,
            "descripcion"=> $this->descripcion,
            "estado"=> $this->estado,
            "Tecnico"=> new UserResource($this->whenLoaded("user")),
            "incidencia"=> new IncidenciaResource($this->whenLoaded("incidencia")),
        ];
    }
}
