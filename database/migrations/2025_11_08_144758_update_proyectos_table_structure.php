<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            // 🔹 Renombrar columnas si existen
            if (Schema::hasColumn('proyectos', 'area_desde')) {
                $table->renameColumn('area_desde', 'area');
            }

            // 🔹 Eliminar columnas que ya no se usan
            if (Schema::hasColumn('proyectos', 'activo')) {
                $table->dropColumn('activo');
            }

            // 🔹 Agregar nuevas columnas si no existen
            if (!Schema::hasColumn('proyectos', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('proyectos', 'precio')) {
                $table->decimal('precio', 12, 2)->nullable()->after('area');
            }
            if (!Schema::hasColumn('proyectos', 'imagen')) {
                $table->string('imagen')->nullable()->after('precio');
            }
        });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            // 🔹 Revertir cambios (opcional)
            if (Schema::hasColumn('proyectos', 'area')) {
                $table->renameColumn('area', 'area_desde');
            }
            if (!Schema::hasColumn('proyectos', 'activo')) {
                $table->boolean('activo')->default(true);
            }
            if (Schema::hasColumn('proyectos', 'descripcion')) {
                $table->dropColumn('descripcion');
            }
            if (Schema::hasColumn('proyectos', 'precio')) {
                $table->dropColumn('precio');
            }
            if (Schema::hasColumn('proyectos', 'imagen')) {
                $table->dropColumn('imagen');
            }
        });
    }
};
