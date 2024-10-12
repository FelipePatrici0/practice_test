<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTruckTable extends Migration
{
    public function up()
    {
        Schema::create('tb_truck', function (Blueprint $table) {
            $table->id('id_truck_tbt');
            $table->foreignId('id_driver_tbt')->constrained('tb_driver', 'id_driver_tbd')->onDelete('cascade');
            $table->foreignId('id_model_truck_tbt')->constrained('tb_model_truck', 'id_model_truck_tmt')->onDelete('cascade');
            $table->char('plate_truck_tbt', 8);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_truck');
    }
}

