<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Score de riesgo por lote — el corazón de las alertas de vencimiento.
     * Depende de: lotes (existente, ya modificada en migration 1)
     *
     * Usa exactamente la misma lógica que tu blade:
     *   $hoy = date('Y-m-d');
     *   $vence30 = date('Y-m-d', strtotime('+30 days'));
     * ...pero agrega la capa cuantitativa: cuántas unidades van a vencer.
     */
    public function up(): void
    {
        Schema::create('scores_riesgo_lote', function (Blueprint $table) {
            $table->id();

            // FK a tu tabla lotes existente
            $table->foreignId('lote_id')
                    ->constrained('lotes')
                    ->onDelete('cascade');

            // Score principal: 0.00 = sin riesgo → 1.00 = riesgo máximo
            // Calculado como: 1 - (unidades_proyectadas_vender / cantidad)
            // Si proyección de ventas < stock → hay unidades que vencerán
            $table->decimal('score_vencimiento', 4, 3); // ej: 0.875

            // Nivel legible derivado del score
            // bajo < 0.3 | moderado 0.3-0.6 | alto 0.6-0.8 | critico > 0.8
            $table->enum('nivel_riesgo', ['bajo', 'moderado', 'alto', 'critico'])
                    ->default('bajo');

            // Datos del cálculo (para mostrar en dashboard)
            $table->integer('dias_para_vencer');       // hoy - fecha_vencimiento
            $table->integer('unidades_restantes');     // = lote.cantidad al momento
            $table->decimal('tasa_rotacion_diaria', 8, 2)->default(0); // uds/día últimos 30d
            $table->decimal('unidades_proyectadas_vender', 10, 2)->default(0);
            $table->decimal('unidades_en_riesgo', 10, 2)->default(0);  // restantes - proyectadas

            // Valor económico: unidades_en_riesgo × precio del producto
            $table->decimal('valor_en_riesgo', 12, 2)->default(0);

            // Acción sugerida por la IA
            // Ej: "Aplicar descuento del 20%", "Trasladar a punto de venta principal"
            $table->text('sugerencia_accion')->nullable();

            $table->timestamp('calculado_en')->useCurrent();
            $table->timestamps();

            $table->index(['lote_id', 'calculado_en']);
            $table->index('nivel_riesgo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores_riesgo_lote');
    }
};
