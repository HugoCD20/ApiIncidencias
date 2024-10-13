<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PruebaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "resultados"=> $this->resultados,
            "estado"=> $this->estado,
            "usuario"=> new UserResource($this->whenLoaded("user")),
            "Incidencia"=>new IncidenciaResource($this->whenLoaded("incidencia")),
        ];
    }
}
