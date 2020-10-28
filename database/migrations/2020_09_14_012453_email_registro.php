<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmailRegistro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_registro', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100)->nullable();
            $table->string('contenido', 100)->nullable();
            $table->integer('id_evento')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('email_registro');
    }
}
