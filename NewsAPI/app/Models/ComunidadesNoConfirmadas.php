<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComunidadesNoConfirmadas extends Model
{
    use HasFactory;
    protected $table = "comunidades_no_aceptadas";

    protected $fillable = ['nombre_comunidad', 'usuario'];

}
