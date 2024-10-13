<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transportadora_motorista', function (Blueprint $table) {
            $table->uuid('motorista_id'); 
            $table->uuid('transportadora_id');
            $table->timestamps();

            $table->foreign('motorista_id')->references('id')->on('motoristas')->onDelete('cascade');
            $table->foreign('transportadora_id')->references('id')->on('transportadoras')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportadora_motorista');
    }
};
