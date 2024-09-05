<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPieza extends Model
{
    use HasFactory;

    protected $table= 'tipos_piezas';

    //Definir los campos que se pueden llenar
    protected $fillable = ['nombre', 'descripcion'];

    //Relación: Un TipoPiezas tiene muchas Piezas
    public function piezas()
    {
        return $this->hasMany(Pieza::class, 'tipo_pieza_id');
    }
}
