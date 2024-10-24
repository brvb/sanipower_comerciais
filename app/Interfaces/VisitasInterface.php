<?php

namespace App\Interfaces;

use App\Models\VisitasAgendadas;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface VisitasInterface
{
    public function getListagemVisitas($perPage,$page): LengthAwarePaginator;

    public function getNumberOfPages($perPage): array;

    public function getAlgumaCoisaDasVisitas($ValorQualquer1,$ValorQualquer2,$ValorQualquer3): LengthAwarePaginator;

    /** FILTRO POR Visitas */

    public function getListagemVisitasFiltro($perPage,$page,$nomeVisitas,$numeroVisitas,$zonaVisitas,$telemovelCliente,$emailCliente,$nifCliente): LengthAwarePaginator;

    public function getNumberOfPagesVisitasFiltro($perPage,$nomeVisitas,$numeroVisitas,$zonaVisitas,$telemovelCliente,$emailCliente,$nifCliente): array;

    /*********** */

    //** DETLAHES Visitas */

    public function getDetalhesVisitas($id_Visitas): object;

    public function getListagemAnalisesVisitas($perPage,$page,$idVisitas): LengthAwarePaginator;

    public function getNumberOfPagesAnalisesVisitas($perPage,$idVisitas): array;

    /****** */


    /** ADD VISITA */

    
    public function addVisitaDatabase($noClient, $clientID,$client,$dataInicial,$horaInicial, $horaFinal, $tipoVisitaEscolhido, $assuntoText): JsonResponse;

    public function addVisitaIniciarDatabase($noClient,$clientID,$client,$dataInicial,$horaInicial, $horaFinal, $tipoVisitaEscolhido, $assuntoText): JsonResponse;

    public function getListagemVisitasAgendadas($user): object;

    public function getListagemVisitasAndTarefas($user): array;

    public function getListagemVisitasAndTarefasWithDate($user,$date): array;
    
    /*** */

    /*** GET VISITAS AGENDADAS ***/

    public function getVisitasAgendadas($clientID): LengthAwarePaginator; 

    /******** */

    /*** APANHAR VISITAS TODAS ***/

    public function getAllVisitas($perPage): LengthAwarePaginator;

    /******** */

    /** ENVIAR PARA O PHC */

    public function sendVisitaToPhc($id,$customer_id,$subject,$report,$type_of_visit,$pending_next_visit,$comment_orders,$comment_budget,$comment_financial,$comments_occurrences,$end_date): JsonResponse;

    /******** */
    /*** APANHAR FINANCEIRO NAS VISITAS ***/

    public function getFinanceiroCliente($perPage,$page,$idCliente): array;
    public function getVisitasCliente($perPage,$page,$idCliente): array;
    public function getAssistencias($perPage,$page,$idCliente): array;

    /******** */
}
