<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Registra cada versión del modelo IA entrenado.
     * No depende de ninguna otra tabla nueva — va primero.
     */
    public function up(): void
    {
        Schema::create('historial_modelo_ia', function (Blueprint $table) {
            $table->id();

            // Nombre del algoritmo: 'XGBoost', 'LinearRegression', 'ClaudeAPI'
            $table->string('nombre_modelo', 100);
            $table->string('version', 20);

            // Métricas de precisión
            // MAE  = error promedio en unidades (ej: 3.2 = se equivoca ~3 uds)
            // RMSE = penaliza errores grandes
            // R2   = qué tan bien explica los datos (0 a 1, más alto = mejor)
            $table->decimal('mae', 10, 4)->nullable();
            $table->decimal('rmse', 10, 4)->nullable();
            $table->decimal('r2', 8, 6)->nullable();

            // Parámetros usados para entrenar el modelo
            // Ej: {"n_estimators": 100, "max_depth": 6}
            $table->json('parametros')->nullable();

            $table->integer('registros_entrenamiento')->default(0);
            $table->date('fecha_datos_desde')->nullable();
            $table->date('fecha_datos_hasta')->nullable();

            // Solo un modelo activo a la vez
            $table->boolean('activo')->default(false);
            $table->text('notas')->nullable();
            $table->timestamp('fecha_entrenamiento')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_modelo_ia');
    }
};
