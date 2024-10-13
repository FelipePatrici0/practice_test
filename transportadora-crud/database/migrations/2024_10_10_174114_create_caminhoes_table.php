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
        Schema::create('caminhoes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('motorista_id');
            $table->uuid('modelo_id');
            $table->char('placa_caminhao', 8)->unique();
            $table->timestamps();

            $table->foreign('motorista_id')->references('id')->on('motoristas')->onDelete('cascade');
            $table->foreign('modelo_id')->references('id')->on('modelos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caminhoes');
    }
};
