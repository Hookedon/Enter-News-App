<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticiasNoConfirmadas extends Model
{
    use HasFactory;
    protected $table = "noticias_no_aceptadas";

    protected $fillable = [
        'titulo', 
        'autor', 
        'usuario',
        'url',  
        'veracidad', 
        'relevancia', 
        'comunidad_id', 
        'fecha_publicacion', 
        'sinopsis'
    ];
    public function comunidad()
    {
        return $this->belongsTo(Comunidades::class, 'comunidad_id');
    }
}
