<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use App\Models\ComentariosPropostas;
use App\Models\ComentariosEncomendas;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientesInterface
{
    public function getListagemClientes($perPage,$page): array;

    public function getAllListagemClientesObject(): object;

    public function getNumberOfPages($perPage): array;


    /** FILTRO POR CLIENTE */

    public function getListagemClienteFiltro($perPage,$page,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente): array;
    public function getListagemClienteAllFiltro($perPage,$page,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$idPhcUser): LengthAwarePaginator;


    public function getNumberOfPagesClienteFiltro($perPage,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente): array;

    /*********** */

    //** DETLAHES CLIENTE */

    public function getDetalhesCliente($id_cliente): array;

    public function getListagemAnalisesCliente($perPage,$page,$idCliente):array;

    public function getNumberOfPagesAnalisesCliente($perPage,$idCliente): array;

    public function getListagemAnaliseFamily($STdate,$EndDate,$customer_number, $salesman_number): array;

    public function getListagemAnaliseAnual($customer_number,$salesman_number): array;


    //DETALHES CLIENTE -> ABA ENCOMENDAS **/
    public function getEncomendasCliente($perPage,$page,$nomeCliente): array;

    public function getNumberOfPagesEncomendasCliente($perPage,$idCliente): array;

    public function getEncomendasClienteFiltro($perPage,$page,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente, $estadoEncomenda,$typeEncomenda,$startDate,$endDate,$statusEncomenda): array;

    public function getNumberOfPagesEncomendasFiltro($perPage,$pageChosen,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente, $estadoEncomenda): array;

    public function  getEncomendasPendentes($perPage,$page): array;

    //DETALHES CLIENTE -> ABA PROPOSTAS **/

    public function getPropostasCliente($perPage,$page,$nomeCliente): array;

    public function getNumberOfPagesPropostasCliente($perPage,$idCliente): array;

    public function sendComentarios($idProposta, $comentario,$type): JsonResponse;  

    /****** */

    //DETALHES CLIENTE -> ABA OCORRENCIAS
    public function getNumberOfPagesPropostasFiltro($perPage,$pageChosen,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$estadoProposta): array;

    public function getOcorrenciasCliente($perPage,$pageChosen,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$startDate,$endDate,$statusOcorrencia): array;

    public function getInvoiceCliente($perPage,$pageChosen,$numeroCliente): array;

    public function getFinanceiroCliente($perPage,$page,$idCliente): array;

    public function getOcorrenciasID($idOcorrencia): array;

    public function getNumberOfPagesOcorrenciasCliente($perPage,$idCliente): array;

    /******** */

    //DETALHES CLIENTE -> SALVAR VISITA

    public function storeVisita($idVisita,$numero_cliente,$assunto,$relatorio,$pendentes,$comentario_encomendas,$comentario_propostas,$comentario_financeiro,$comentario_occorencias): JsonResponse;  


    /********** */
}