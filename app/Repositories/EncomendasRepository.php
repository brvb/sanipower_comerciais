<?php

namespace App\Repositories;


use stdClass;
use App\Models\User;
use App\Models\Carrinho;
use App\Models\ComentariosProdutos;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;
use App\Interfaces\EncomendasInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class EncomendasRepository implements EncomendasInterface
{
    public function getCategorias(): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/products/categories',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
    
        return $response_decoded;

    }

    public function getSubFamily($idCategory, $idFamily, $idSubFamily): object
    {
        if($idCategory == ""){
            $idCategory = 1;
        }
        if($idFamily == ""){
            $idFamily = 1;
        }
        if($idSubFamily == ""){
            $idSubFamily = 1;
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/products/products?category_number='.$idCategory.'&family_number='.$idFamily.'&subfamily_number='.$idSubFamily.'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/products/products?category_number='.$idCategory.'&family_number='.$idFamily.'&subfamily_number='.$idSubFamily.'', ' ', $response_decoded);
        return $response_decoded; 
    }


    public function getSubFamilySearch($searchProduct): object
    {
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/products/products_search?search='.urlencode($searchProduct).'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        // foreach($response_decoded->product as $i => $prod)
        // {
        //     if (stripos($prod->product_name, $searchProduct) === false) {
        //         unset($response_decoded->product[$i]);
        //     }
        // }
        
        // dd($response_decoded);
        return $response_decoded; 
    }

    public function getprodCamp($searchProduct): object
    {
        // dd($searchProduct);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/products/products_campaign?stamp='.$searchProduct.'&img=true',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/products/products_campaign?stamp='.urlencode($searchProduct).'&img=true');

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        // foreach($response_decoded->product as $i => $prod)
        // {
        //     if (stripos($prod->product_name, $searchProduct) === false) {
        //         unset($response_decoded->product[$i]);
        //     }
        // }
        
        // dd($response_decoded);
        return $response_decoded; 
    }


    public function getProdutos($idCategory, $idFamily, $idSubFamily, $productNumber, $idCustomer): object
    {
        // dd($idCategory, $idFamily, $idSubFamily, $productNumber, $idCustomer);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/products/products?category_number='.$idCategory.'&family_number='.$idFamily.'&subfamily_number='.$idSubFamily.'&product_number='.$productNumber.'&customer_number='.$idCustomer.'&img=false',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        // dd(env('SANIPOWER_URL_DIGITAL').'/api/products/products?category_number='.$idCategory.'&family_number='.$idFamily.'&subfamily_number='.$idSubFamily.'&product_number='.$productNumber.'&customer_number='.$idCustomer.'&img=false');
        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        // dd(env('SANIPOWER_URL_DIGITAL').'/api/products/products?category_number='.$idCategory.'&family_number='.$idFamily.'&subfamily_number='.$idSubFamily.'&product_number='.$productNumber.'&customer_number='.$idCustomer.'&img=false', $response_decoded);

        // if (isset($response_decoded->product) && is_array($response_decoded->product)) {
        //     $filtered_products = array_filter($response_decoded->product, function($prod) {
        //         return $prod->quantity != "0";
        //     });
    
        //     $response_decoded->product = array_values($filtered_products);
        // }
        return $response_decoded; 
    }
    
    
    public function getCategoriasSearched($idCategory,$idFamily): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/products/categories',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);


        $arrayFiltrado = new stdClass;
        $arrayFiltrado->category = [];

    
        foreach($response_decoded->category as $i => $cat)
        {
            array_push($arrayFiltrado->category,$cat);
        }

        foreach($arrayFiltrado->category as $filter)
        {
            if($filter->id == $idCategory)
            {
                foreach($filter->family as $i => $family)
                {
                    if($family->id != $idFamily)
                    {
                        unset($filter->family[$i]);
                    }
                }
            }
        }

        return $arrayFiltrado; 

    }
    public function addCommentToDatabase($idCarrinho,$idCliente,$qtd,$nameProduct,$no,$ref,$codType,$type,$comment): JsonResponse
    {
        if($type == "encomenda") {
            $idencomenda = $codType;
            $idproposta = "";
        } else {
            $idencomenda = "";
            $idproposta = $codType;
        }

        $addComment = ComentariosProdutos::create([
            "id_user" => Auth::user()->id,
            "reference" => $qtd["product"]->referense,
            "no" => $no,
            "id_encomenda" => $idencomenda,
            "id_proposta" => $idproposta,
            "tipo" => $type,
            "comentario" => $comment,
            "id_carrinho_compras" => $idCarrinho
        ]);

        if ($addComment) {
            // Inserção bem-sucedida
            return response()->json([
                'success' => true,
                'data' => $addComment,
                'encomenda' => $idencomenda,
                'proposta' => $idproposta
            ], 201);
        } else {
            // Falha na inserção
            return response()->json([
                'success' => false,
                'message' => 'Falha ao inserir na base de dados.'
            ], 500);
        }
    }


    public function addProductToDatabase($codvisita,$idCliente,$qtd,$nameProduct,$no,$ref,$codType,$type): JsonResponse
    {   
        if ($qtd["product"]->color == "#cc7c3a") {
            $inCampanhas = 1;
        }else{
            $inCampanhas = 0;
        }
        if($type == "encomenda") {
            $idencomenda = $codType;
            $idproposta = "";
        } else {
            $idencomenda = "";
            $idproposta = $codType;
        }
        // dd($qtd);
        $addProduct = Carrinho::create([
            "id_encomenda" => $idencomenda,
            "id_proposta" => $idproposta,
            "id_cliente" => $no,
            "id_visita" => $codvisita ,
            "id_user" => Auth::user()->id,
            "referencia" => $qtd["product"]->referense,
            "designacao" => $nameProduct,
            "in_campanhas" => $inCampanhas,
            "pvp" => $qtd["product"]->pvp,
            "discount" => $qtd["product"]->discount1,
            "discount2" => $qtd["product"]->discount2,
            "price" => $qtd["product"]->price,
            "model" => $qtd["product"]->model,
            "qtd" => intval($qtd["quantidade"]),
            "iva" => $qtd["product"]->tax,
            "image_ref" => $ref,
        ]);

        if ($addProduct) {
            // Inserção bem-sucedida
            return response()->json([
                'success' => true,
                'data' => $addProduct,
                'encomenda' => $idencomenda,
                'proposta' => $idproposta
            ], 201);
        } else {
            // Falha na inserção
            return response()->json([
                'success' => false,
                'message' => 'Falha ao inserir na base de dados.'
            ], 500);
        }

        return $addProduct;
    }

    public function getLojas(): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/products/stores',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        $array = [$response_decoded];

        return $array;
    }


}