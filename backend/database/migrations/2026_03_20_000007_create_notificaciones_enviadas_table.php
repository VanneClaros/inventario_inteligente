<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Registro de notificaciones enviadas a usuarios.
     * Depende de: alertas_inventario (migration 5) + users (existente)
     */
    public function up(): void
    {
        Schema::create('notificaciones_enviadas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alerta_id')
                    ->constrained('alertas_inventario')
                    ->onDelete('cascade');

            // FK a tu tabla users de Laravel
            $table->foreignId('user_id')
                    ->constrained('users')
                    ->onDelete('cascade');

            $table->enum('canal', ['web', 'email', 'sms'])->default('web');
            $table->enum('estado', ['pendiente', 'enviada', 'fallida', 'leida'])->default('pendiente');

            $table->text('error_mensaje')->nullable();
            $table->timestamp('enviada_en')->nullable();
            $table->timestamp('leida_en')->nullable();
            $table->timestamps();

            // Evita duplicados: misma alerta + usuario + canal solo una vez
            $table->unique(['alerta_id', 'user_id', 'canal']);
            $table->index(['user_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones_enviadas');
    }
};
