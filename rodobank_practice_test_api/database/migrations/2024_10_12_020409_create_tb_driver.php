<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_driver', function (Blueprint $table) {
            $table->id('id_driver_tbd');
            $table->string('name_driver_tbd', 100);
            $table->char('cpf_driver_tbd', 11);
            $table->date('birthdate_driver_tbd');
            $table->string('email_driver_tbd', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_driver');
    }
}

?>

