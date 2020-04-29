<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagenPublicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagen_publicaciones', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('url');
            $table->smallInteger('perfil');

            $table->unsignedBigInteger('publicacion_id')->nullable()->default(NULL);
            $table->foreign('publicacion_id')->references('id')->on('publicaciones');

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
        Schema::dropIfExists('imagen_publicaciones');
    }
}
