<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EncomendasController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropostasController;
use App\Http\Controllers\VisitasController;
use App\Http\Controllers\VisitasNewController;
use App\Http\Controllers\CampanhasController;
use App\Http\Controllers\AnaliseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OcorrenciasController;
use App\Http\Controllers\FinanceiroController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

Route::get('/migrate', function () {

    $exitCode = Artisan::call('migrate');
     if ($exitCode === 0) {
        return 'Comando "migrate" executado com sucesso';
     } else {
        return 'Erro ao executar o comando "migrate"';
     }
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/logout', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth', 'check.level:1'])->group(function () {
        Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    });
    
    Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes');
    Route::get('/clientes/detalhes/{id}', [ClientesController::class, 'showDetail'])->name('clientes.detail');

    Route::get('/visitas', [VisitasController::class, 'index'])->name('visitas');
    Route::get('/visitas/new-visita/{id}', [VisitasNewController::class, 'showDetail'])->name('visitas.new-visita');
    Route::get('/visitas/detalhes/{id}', [VisitasController::class, 'showDetail'])->name('visitas.detail');
    Route::get('/visitas/nova-visita/{id}', [VisitasController::class, 'endVisita'])->name('visitas.end-visita');
    Route::get('/visitas/agendar-visita/{id}', [VisitasController::class, 'agendarVisita'])->name('visitas.agendar-visita');
    Route::get('/visitas/clientes', [VisitasController::class, 'clienteList'])->name('visitas.clientes');
    Route::get('/visitas/information/{id}', [VisitasController::class, 'visitasInfo'])->name('visitas.info');

    Route::get('/encomendas', [EncomendasController::class, 'index'])->name('encomendas');
    Route::get('/encomendas/detalhes/{id}', [EncomendasController::class, 'showDetail'])->name('encomendas.detail');
    Route::get('/encomendas/detalhes/{id}/{idVisita}', [EncomendasController::class, 'showDetailVisitas'])->name('encomendas.detail.visitas');

    Route::get('/encomendas/{idEncomenda}', [EncomendasController::class, 'showDetailEncomenda'])->name('encomendas.encomenda');
    Route::get('/encomendas/nova', [EncomendasController::class, 'encomendasList'])->name('encomendas.nova');

    Route::get('/propostas', [PropostasController::class, 'index'])->name('propostas');
    Route::get('/propostas/detalhes/{id}', [PropostasController::class, 'showDetail'])->name('propostas.detail');
    Route::get('/propostas/detalhes/{id}/{idVisita}', [PropostasController::class, 'showDetailVisitas'])->name('propostas.detail.visitas');

    Route::get('/propostas/{idProposta}', [PropostasController::class, 'showDetailProposta'])->name('propostas.proposta');
    Route::get('/propostas/nova', [PropostasController::class, 'propostasList'])->name('propostas.nova');

    Route::get('/getCode', [OfficeController::class, 'getCode']);

    Route::get('/campanhas', [CampanhasController::class, 'index'])->name('campanhas');

    Route::get('/ocorrencias', [OcorrenciasController::class, 'index'])->name('ocorrencias');
    
    Route::get('/ocorrencias/nova', [OcorrenciasController::class, 'ocorrenciasList'])->name('ocorrencias.nova');

    Route::get('/ocorrencias/detalhes/{id}', [OcorrenciasController::class, 'showDetail'])->name('ocorrencias.detail');

    Route::get('/ocorrencias/{idOcorrencia}', [OcorrenciasController::class, 'showDetailOcorrencia'])->name('ocorrencias.ocorrencia');


    Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro');
    Route::get('/financeiro/{idFinanceiro}', [FinanceiroController::class, 'showDetailFinanceiro'])->name('financeiros.financeiro');

    Route::get('/Analise', [AnaliseController::class, 'index'])->name('Analise');

});
require __DIR__ . '/auth.php';
