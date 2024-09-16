<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAccesorio extends Model
{
    use HasFactory;

    protected $table= 'tipo_accesorios';

    //Definir los campos que se pueden llenar
    protected $fillable = ['nombre', 'descripcion'];

    //Relación: Un TipoPiezas tiene muchas accesorios
    public function accesorios()
    {
        return $this->hasMany(Accesorio::class, 'tipo_accesorio_id');
    }
}
