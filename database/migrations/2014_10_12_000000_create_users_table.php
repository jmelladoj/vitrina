<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(bcrypt('123456789'));
            $table->string('fecha_nacimiento');
            $table->integer('telefono');
            $table->smallInteger('mailing')->default(0);
            $table->smallInteger('administrador')->default(0);
            $table->smallInteger('tipo_persona')->default(1);
            $table->string('perfil_url')->nullable()->default('https://image.flaticon.com/icons/svg/149/149076.svg');
            $table->string('linkedin')->nullable()->default(null);
            $table->string('facebook')->nullable()->default(null);
            $table->string('instagram')->nullable()->default(null);
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
