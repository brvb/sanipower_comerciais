<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface PropostasInterface
{
    /** GET CATEGORIAS **/

    public function getCategorias(): object;


    public function getCategoriasSearched($idCategory,$idFamily): object;

    public function getSubFamily($idCategory, $idFamily, $idSubFamily): object;

    public function getprodCamp($searchProduct): object;

    public function getSubFamilySearch($searchProduct): object;

    public function getProdutos($idCategory, $idFamily, $idSubFamily, $productNumber, $idCustomer): object;

    
    /*** PARTE DO CARRINHO ***/

    public function addProductToDatabase($codvisita,$idCliente,$qtd, $nameProduct, $no, $ref, $codType,$type): JsonResponse;
    public function addCommentToDatabase($idCarrinho,$idCliente,$qtd, $nameProduct, $no, $ref, $codType,$type,$comment): JsonResponse;

    /********** */


    /********* */

}