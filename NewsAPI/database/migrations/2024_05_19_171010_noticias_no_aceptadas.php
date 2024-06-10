<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('noticias_no_aceptadas', function (Blueprint $table) {
            $table->id();
            $table->string("titulo",100);
            $table->string("autor",100);
            $table->string("url",500);
            $table->smallInteger('veracidad');
            $table->smallInteger('relevancia');
            $table->foreignId('comunidad_id')->constrained('comunidades');
            $table->date("fecha_publicacion");
            $table->string("usuario",100);
            $table->longText("sinopsis");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
