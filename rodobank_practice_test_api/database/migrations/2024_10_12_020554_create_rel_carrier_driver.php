<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelCarrierDriverTable extends Migration
{
    public function up()
    {
        Schema::create('rel_carrier_driver', function (Blueprint $table) {
            $table->id('id_carrier_driver_rcd');
            $table->foreignId('id_carrier_rcd')->constrained('tb_carrier', 'id_carrier_tbc')->onDelete('cascade');
            $table->foreignId('id_driver_rcd')->constrained('tb_driver', 'id_driver_tbd')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rel_carrier_driver');
    }
}

