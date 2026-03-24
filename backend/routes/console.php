<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\ScoreRiesgoService;
use App\Services\AlertaInventarioService;
use App\Services\PronosticoDemandaService;

// ── Comando original de Laravel (no borrar) ─────────────────
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ── Comandos Artisan para la IA ──────────────────────────────

// Calcular scores manualmente: php artisan ia:scores
Artisan::command('ia:scores', function () {
    $this->info('Calculando scores de riesgo para todos los lotes...');
    app(ScoreRiesgoService::class)->calcularTodos();
    app(AlertaInventarioService::class)->generarDesdeScores();
    $this->info('✓ Scores y alertas generados correctamente.');
})->purpose('Calcular scores de riesgo de vencimiento y generar alertas');

// Generar pronósticos manualmente: php artisan ia:pronosticos
Artisan::command('ia:pronosticos', function () {
    $this->info('Generando pronósticos de demanda con Claude API...');
    app(PronosticoDemandaService::class)->generarSemanal();
    $this->info('✓ Pronósticos generados correctamente.');
})->purpose('Generar pronósticos de demanda usando Claude API');

// ── Tareas programadas automáticas ──────────────────────────

// Cada noche a medianoche: scores + alertas de vencimiento
Schedule::call(function () {
    app(ScoreRiesgoService::class)->calcularTodos();
    app(AlertaInventarioService::class)->generarDesdeScores();
})->dailyAt('00:00')->name('ia-scores-nocturnos')->withoutOverlapping();

// Cada lunes a la 1am: pronósticos semanales
Schedule::call(function () {
    app(PronosticoDemandaService::class)->generarSemanal();
})->weeklyOn(1, '01:00')->name('ia-pronosticos-semanales')->withoutOverlapping();
