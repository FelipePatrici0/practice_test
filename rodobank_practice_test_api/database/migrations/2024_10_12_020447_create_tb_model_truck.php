<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_model_truck', function (Blueprint $table) {
            $table->id('id_model_truck_tmt');
            $table->string('model_truck_tmt', 50);
            $table->string('color_truck_tmt', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_model_truck');
    }
}
?>

