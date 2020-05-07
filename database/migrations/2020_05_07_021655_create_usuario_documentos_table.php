<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_documentos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('titulo');
            $table->string('url')->nullable();

            $table->unsignedBigInteger('user_id')->nullable()->default(NULL);
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('usuario_documentos');
    }
}
