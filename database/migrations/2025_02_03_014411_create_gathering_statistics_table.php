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
        Schema::create('gathering_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lifetime_statistics_id'); // Relación con lifetime_statistics
            $table->enum('resource_type', ['Fiber', 'Hide', 'Ore', 'Rock', 'Wood', 'All']); // Tipo de recurso
            $table->bigInteger('Total')->nullable(); // Total de fama de recolección
            $table->bigInteger('Royal')->nullable(); // Fama en zonas reales
            $table->bigInteger('Outlands')->nullable(); // Fama en Outlands
            $table->bigInteger('Avalon')->nullable(); // Fama en Avalon
            $table->timestamps();

            // Clave foránea
            $table->foreign('lifetime_statistics_id')
                  ->references('id')
                  ->on('lifetime_statistics')
                  ->onDelete('cascade'); // Eliminación en cascada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gathering_statistics');
    }
};
