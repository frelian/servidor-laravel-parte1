<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ide_cli');
            // $table->string('nit_cli')->nullable();
            $table->enum('ide_type_cli', ['identification', 'nit']);
            $table->string('first_name_cli')->nullable();
            $table->string('sur_name_cli')->nullable();
            $table->string('business_name_cli')->nullable();
            $table->string('address_cli');
            $table->string('phone_cli');
            $table->string('specialty_cli')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'fk_user_clients')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('client_types_id');
            $table->foreign('client_types_id', 'fk_client_types_clients')
                ->references('id')
                ->on('client_types')
                ->onDelete('cascade');

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
        Schema::dropIfExists('clients');
    }
}
