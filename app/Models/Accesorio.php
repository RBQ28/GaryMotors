<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesorio extends Model
{
    use HasFactory;
    protected $table = 'accesorios';

    //Definir los campos que se pueden llenar
    protected $fillable = ['nombre', 'tipo_accesorio_id', 'descripcion', 'precio', 'stock', 'imagen'];

    //Relación: Una Pieza pertenece a un TipoAccesorio
    public function tipoAccesorios()
    {
        return $this->belongsTo(TipoAccesorio::class, 'tipo_accesorio_id');
    }
}
