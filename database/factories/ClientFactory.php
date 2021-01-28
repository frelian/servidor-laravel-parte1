<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [

        'ide_cli'           => mt_rand( 100000, 999999),
        'ide_type_cli'      => $faker->randomElement(['identification', 'nit']),
        'first_name_cli'    => $faker->firstName,
        'sur_name_cli'      => $faker->name,
        'business_name_cli' => $faker->company, // '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' password
        'address_cli'       => $faker->address,
        'phone_cli'         => Str::random(10),
        'specialty_cli'     => $faker->firstName,
        'user_id'           => '30000000',
        'client_types_id'   => $faker->randomNumber([1,2,3]),
    ];
});
