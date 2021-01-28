<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creo un usuario administrador con mis datos
        User::create([
            'names'          => 'Julian Niño',
            'identification' => '246810',
            'email'          => 'frelian@gmail.com',
            'email_verified_at' => now(),
            'password'       => bcrypt('123'),
            'address'        => 'Carrera 99 #123-1',
            'phone'          => '30000000',
            'role'           => 'admin',
        ]);

        factory(User::class, 19)->create();
    }
}
