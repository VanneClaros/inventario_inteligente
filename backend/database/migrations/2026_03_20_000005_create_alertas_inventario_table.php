<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Central de alertas del sistema inteligente.
     * Depende de: lotes, productos, users (existentes) + scores_riesgo_lote (migration 4)
     */
    public function up(): void
    {
        Schema::create('alertas_inventario', function (Blueprint $table) {
            $table->id();

            $table->enum('tipo_alerta', [
                'vencimiento_proximo',  // badge "Por vencer" de tu blade
                'stock_minimo',         // stock <= stock_minimo de productos
                'stock_agotado',        // cantidad = 0
                'demanda_alta',         // IA predice pico, reabastece pronto
                'demanda_baja',         // IA predice caída, riesgo sobrestock
                'lote_sin_rotacion',    // lote activo sin ventas en X días
            ]);

            $table->enum('nivel', ['info', 'preventivo', 'critico'])->default('preventivo');

            // A qué entidad aplica la alerta
            $table->string('entidad_tipo', 20);       // 'lote' o 'producto'
            $table->unsignedBigInteger('entidad_id'); // id del lote o producto

            // FK directas para joins rápidos en el dashboard
            $table->foreignId('lote_id')
                    ->nullable()
                    ->constrained('lotes')
                    ->onDelete('cascade');

            $table->foreignId('producto_id')
                    ->nullable()
                    ->constrained('productos')
                    ->onDelete('cascade');

            // FK al score que originó esta alerta
            $table->foreignId('score_id')
                    ->nullable()
                    ->constrained('scores_riesgo_lote')
                    ->onDelete('set null');

            // Mensaje para mostrar en el dashboard
            // Ej: "Lote #11 Vino del Valle vence en 7 días con 5 uds sin vender"
            $table->text('mensaje');

            // Acción concreta sugerida por la IA
            // Ej: "Aplicar 30% de descuento o mover al área de promociones"
            $table->text('sugerencia')->nullable();

            // Datos adicionales en JSON
            // Ej: {"dias_para_vencer": 7, "unidades": 5, "valor_en_riesgo": 125.00}
            $table->json('datos_extra')->nullable();

            // Control de estado de la alerta
            $table->boolean('leida')->default(false);
            $table->boolean('resuelta')->default(false);
            $table->timestamp('leida_en')->nullable();
            $table->timestamp('resuelta_en')->nullable();

            // Quién resolvió la alerta (FK a tu tabla users existente)
            $table->foreignId('resuelta_por')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->timestamps();

            $table->index(['tipo_alerta', 'nivel']);
            $table->index(['leida', 'resuelta']);
            $table->index('created_at');
            $table->index(['entidad_tipo', 'entidad_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertas_inventario');
    }
};
