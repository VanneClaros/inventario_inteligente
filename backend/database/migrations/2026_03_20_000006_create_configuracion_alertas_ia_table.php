<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Umbrales configurables por producto o globales.
     * Depende de: productos (existente)
     */
    public function up(): void
    {
        Schema::create('configuracion_alertas_ia', function (Blueprint $table) {
            $table->id();

            // NULL = config global para todos los productos
            // Con valor = config específica para ese producto
            $table->foreignId('producto_id')
                    ->nullable()
                    ->constrained('productos')
                    ->onDelete('cascade');

            // Tu blade usa 30 días para "Por vencer"
            // Aquí puedes ajustarlo por producto si necesitas más anticipación
            $table->integer('dias_aviso_vencimiento')->default(30);

            // Score mínimo para disparar alerta
            $table->decimal('umbral_score_critico', 4, 3)->default(0.700);
            $table->decimal('umbral_score_preventivo', 4, 3)->default(0.400);

            // Días sin movimiento para alerta "lote_sin_rotacion"
            $table->integer('dias_sin_rotacion_alerta')->default(15);

            $table->boolean('activo')->default(true);
            $table->text('notas')->nullable();
            $table->timestamps();

            // Una sola config global (NULL) o una por producto
            $table->unique('producto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_alertas_ia');
    }
};
