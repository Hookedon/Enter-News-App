<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;
    protected $table = "usuarios";

    protected $fillable = [
        'nombre',
        'email',
        'contrasenya',
        'suscripciones',
        'fecha_creacion',
        'created_at',
        'updated_at',
        'is_admin'
    ];
}