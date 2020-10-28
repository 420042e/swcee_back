<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Items extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 100)->nullable();
            $table->string('message', 100)->nullable();
            $table->string('fontSize', 100)->nullable();
            $table->string('pos_x', 100)->nullable();
            $table->string('pos_y', 100)->nullable();
            $table->integer('id_certificado')->unsigned();
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
        Schema::dropIfExists('items');
    }
}
