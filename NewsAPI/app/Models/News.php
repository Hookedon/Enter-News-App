<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    
    protected $table = 'news';

    protected $fillable = [
        'titulo', 
        'autor', 
        'url',  
        'veracidad', 
        'relevancia', 
        'comunidad_id', 
        'fecha_publicacion', 
        'sinopsis'
    ];

    /**
     */
    public function comunidad()
    {
        return $this->belongsTo(Comunidades::class, 'comunidad_id');
    }
}