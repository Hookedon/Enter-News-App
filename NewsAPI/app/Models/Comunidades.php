<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidades extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'comunidades';

    // Define the fillable properties
    protected $fillable = ['nombre_comunidad'];

    /**
     * Define a one-to-many relationship with the News model.
     */
    public function news()
    {
        return $this->hasMany(News::class, 'comunidad_id');
    }
}