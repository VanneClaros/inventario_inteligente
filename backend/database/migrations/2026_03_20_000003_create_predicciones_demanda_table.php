<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Almacena pronósticos de demanda por producto.
     * Depende de: productos (existente) + historial_modelo_ia (migration 2)
     */
    public function up(): void
    {
        Schema::create('predicciones_demanda', function (Blueprint $table) {
            $table->id();

            // FK a tu tabla productos existente
            $table->foreignId('producto_id')
                    ->constrained('productos')
                    ->onDelete('cascade');

            // FK al modelo que generó esta predicción
            // nullable porque al inicio usarás Claude API sin modelo local
            $table->foreignId('modelo_ia_id')
                  ->nullable()
                  ->constrained('historial_modelo_ia')
                  ->onDelete('set null');

            // Periodo que cubre el pronóstico
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->enum('granularidad', ['diario', 'semanal', 'mensual'])->default('semanal');

            // Resultado del pronóstico
            $table->decimal('cantidad_predicha', 10, 2);
            $table->decimal('cantidad_minima', 10, 2)->nullable();   // rango inferior
            $table->decimal('cantidad_maxima', 10, 2)->nullable();   // rango superior
            $table->decimal('confianza_pct', 5, 2)->nullable();      // % confianza

            // Qué generó la predicción
            // 'claude_api' al inicio, luego 'python_xgboost' cuando implementes Python
            $table->string('fuente', 50)->default('claude_api');

            // Datos enviados a la IA (para auditoría)
            $table->json('datos_entrada')->nullable();

            // Se llena después: cuánto SE VENDIÓ realmente en ese periodo
            // Permite medir qué tan preciso fue el modelo
            $table->decimal('cantidad_real', 10, 2)->nullable();
            $table->decimal('error_porcentual', 8, 4)->nullable();

            $table->timestamps();

            $table->index(['producto_id', 'periodo_inicio']);
            $table->index('periodo_inicio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predicciones_demanda');
    }
};
