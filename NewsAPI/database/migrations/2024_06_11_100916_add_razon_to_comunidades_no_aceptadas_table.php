<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRazonToComunidadesNoAceptadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comunidades_no_aceptadas', function (Blueprint $table) {
            $table->text('razon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comunidades_no_aceptadas', function (Blueprint $table) {
            $table->dropColumn('razon');
        });
    }
}