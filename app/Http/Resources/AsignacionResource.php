<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class AsignacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id_asignacion'=>$this->id,
            'user'=>new UserResource(new UserResource($this->whenLoaded('user'))),
            'incidencia'=>new IncidenciaResource($this->whenLoaded('incidencia')),
        ];
    }
}
