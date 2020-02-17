<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        User::create([
            'nombre' => 'Administrador',
            'email' => 'admin@vitrinalaboral.cl',
            'password' => bcrypt('123456789'),
            'fecha_nacimiento' => '1994-10-190',
            'telefono' => 987654321,
            'administrador' => 1
        ]);

        User::create([
            'nombre' => 'Prueba',
            'email' => 'prueba@vitrinalaboral.cl',
            'password' => bcrypt('123456789'),
            'fecha_nacimiento' => '1994-10-190',
            'telefono' => 987654321,
            'administrador' => 0
        ]);
    }
}
