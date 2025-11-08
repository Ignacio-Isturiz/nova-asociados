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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete();
            $table->date('fecha');
            $table->time('hora');
            $table->string('telefono_contacto')->nullable();
            $table->string('estado')->default('pendiente');
            $table->text('notas')->nullable();
            $table->timestamps();
        
            $table->unique(['user_id', 'proyecto_id', 'fecha', 'hora'], 'cita_unica_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
