<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excels', function (Blueprint $table) {
            $table->increments('id');

            $table->string('albaran', 10);
            $table->string('destinatario', 28);
            $table->string('direccion', 250);
            $table->string('poblacion', 10)->nullable();
            $table->char('cp', 5);
            $table->string('provincia', 20);
            $table->string('telefono', 10);
            $table->string('observaciones', 500)->nullable();
            $table->dateTime('fecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excels');
    }
}
