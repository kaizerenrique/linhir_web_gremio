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
        Schema::create('lifetime_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personaje_id'); // Relación con la tabla personajes
            $table->bigInteger('PvE_Total')->nullable(); // Total de fama PvE
            $table->bigInteger('PvE_Royal')->nullable(); // Fama PvE en zonas reales
            $table->bigInteger('PvE_Outlands')->nullable(); // Fama PvE en Outlands
            $table->bigInteger('PvE_Avalon')->nullable(); // Fama PvE en Avalon
            $table->bigInteger('PvE_Hellgate')->nullable(); // Fama PvE en Hellgates
            $table->bigInteger('PvE_CorruptedDungeon')->nullable(); // Fama PvE en mazmorras corruptas
            $table->bigInteger('PvE_Mists')->nullable(); // Fama PvE en los Mists
            $table->bigInteger('Crafting_Total')->nullable(); // Total de fama de crafteo
            $table->bigInteger('Crafting_Royal')->nullable(); // Fama de crafteo en zonas reales
            $table->bigInteger('Crafting_Outlands')->nullable(); // Fama de crafteo en Outlands
            $table->bigInteger('Crafting_Avalon')->nullable(); // Fama de crafteo en Avalon
            $table->integer('CrystalLeague')->nullable(); // Fama en Crystal League
            $table->bigInteger('FishingFame')->nullable(); // Fama de pesca
            $table->bigInteger('FarmingFame')->nullable(); // Fama de cultivo
            $table->dateTime('Timestamp_Conec')->nullable(); // Fecha de la última actualización
            $table->timestamps();

            // Clave foránea
            $table->foreign('personaje_id')
                  ->references('id')
                  ->on('personajes')
                  ->onDelete('cascade'); // Eliminación en cascada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lifetime_statistics');
    }
};
