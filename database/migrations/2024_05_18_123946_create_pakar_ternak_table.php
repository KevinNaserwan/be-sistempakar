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
        Schema::create('pakar_ternak', function (Blueprint $table) {
            $table->id();
            $table->string('waktu_panen')->nullable();
            $table->string('budget_tahunan')->nullable();
            $table->string('metode_panen')->nullable();
            $table->string('jenis_pakan')->nullable();
            $table->string('jenis_ikan')->nullable();
            $table->string('keyakinan_metode_pakan')->nullable();
            $table->string('keyakinan_metode_panen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakar_ternak');
    }
};
