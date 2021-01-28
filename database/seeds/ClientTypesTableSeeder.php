<?php

use Illuminate\Database\Seeder;
use App\Models\ClientType;

class ClientTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientType::create([
            'type_name'          => 'Domiciliario',
        ]);

        ClientType::create([
            'type_name'          => 'Comerciales',
        ]);

        ClientType::create([
            'type_name'          => 'Hospitalarios',
        ]);
    }
}
