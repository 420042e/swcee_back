<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AsisteEvento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asiste_evento', function (Blueprint $table) {
            $table->id();
            $table->integer('id_asistente')->unsigned();
            $table->integer('id_evento')->unsigned();
            $table->timestamps();

            $table->foreign('id_asistente')->references('id')->on('asistentes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('id_evento')->references('id')->on('eventos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asiste_evento');
    }
}
