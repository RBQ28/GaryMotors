<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{
    use HasFactory;
    protected $table = 'piezas';

    //Definir los campos que se pueden llenar
    protected $fillable = ['nombre', 'tipo_pieza_id', 'descripcion', 'precio', 'stock', 'imagen'];

    //Relación: Una Pieza pertenece a un TipoPieza
    public function tipoPieza()
    {
        return $this->belongsTo(TipoPieza::class, 'tipo_pieza_id');
    }
}
