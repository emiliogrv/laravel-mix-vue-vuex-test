<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ExcelResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'albaran' => $this->albaran,
            'destinatario' => $this->destinatario,
            'direccion' => $this->direccion,
            'poblacion' => $this->poblacion,
            'cp' => $this->cp,
            'provincia' => $this->provincia,
            'telefono' => $this->telefono,
            'observaciones' => $this->observaciones,
            'fecha' => $this->fecha,
        ];
    }
}
