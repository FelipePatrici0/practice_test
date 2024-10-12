<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_carrier', function (Blueprint $table) {
            $table->id('id_carrier_tbc');
            $table->string('name_carrier_tbc', 100);
            $table->char('cnpj_carrier_tbc', 14);
            $table->boolean('is_active_tbc')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_carrier');
    }
}

?>