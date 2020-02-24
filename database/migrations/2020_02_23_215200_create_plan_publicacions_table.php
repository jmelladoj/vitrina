<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanPublicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_publicaciones', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nombre_plan');
            $table->integer('duracion');
            $table->integer('valor');
            $table->text('token')->nullable()->default(null);
            $table->integer('estado')->nullable()->default(0);

            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('planes');

            $table->unsignedBigInteger('publicacion_id');
            $table->foreign('publicacion_id')->references('id')->on('publicaciones');

            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('plan_publicaciones');
    }
}
