<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Excel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'albaran',
        'destinatario',
        'direccion',
        'poblacion',
        'cp',
        'provincia',
        'telefono',
        'observaciones',
        'fecha',
    ];

    public function setFechaAttribute($value)
    {
        return $this->attributes['fecha'] = Carbon::createFromFormat('d/m/Y h:i', $value)->toDateTimeString();
    }

    public function getFechaAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d h:i:s', $value)->format('d/m/Y h:i');
    }
}
