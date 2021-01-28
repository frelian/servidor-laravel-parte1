<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [

        'names'             => $faker->name,
        'identification'    => mt_rand( 100000, 999999),
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => bcrypt('123'), // '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' password
        'address'           => $faker->address,
        'remember_token'    => Str::random(10),
        'address'           => 'Carrera 99 #123-1',
        'phone'             => '30000000',
        'role'              => $faker->randomElement(['admin' ,'sales']),
    ];
});
