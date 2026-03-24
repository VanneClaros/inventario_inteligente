<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->string('numero_lote', 100)->nullable()->after('producto_id');
            $table->integer('cantidad_inicial')->default(0)->after('cantidad');
        });
    }

    public function down(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropColumn(['numero_lote', 'cantidad_inicial', 'estado']);
        });
    }
};
