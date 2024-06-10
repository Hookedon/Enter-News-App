<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToNombreComunidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comunidades', function (Blueprint $table) {
            $table->unique('nombre_comunidad'); // Adding unique constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comunidades', function (Blueprint $table) {
            $table->dropUnique(['nombre_comunidad']); // Dropping unique constraint
        });
    }
}