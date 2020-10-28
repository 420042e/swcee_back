<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Evento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_evento', 100)->unique();
            $table->string('lugar', 100)->nullable();
            $table->string('fecha', 100)->nullable();
            $table->string('hora', 100)->nullable();
            $table->integer('estado')->nullable();
            $table->string('tipo', 100)->nullable();
            $table->string('descripcion', 100)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
