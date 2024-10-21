<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Visitas;
use App\Models\Comentarios;
use Illuminate\Http\JsonResponse;
use App\Models\ComentariosPropostas;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use App\Models\ComentariosEncomendas;
use App\Models\VisitasAgendadas;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientesRepository implements ClientesInterface
{
    public function getListagemClientes($perPage,$page): array
    {
        $nomeCliente = '&Name=';
        $numeroCliente = '&Customer_number=0';
        $zonaCliente = '&Zone=';
        $mobileCliente = '&Mobile_phone=';
        $emailCliente = '&Email=';
        $nifCliente = '&Nif=';

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$mobileCliente.$emailCliente.$nifCliente;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/customers/GetCustomers?perPage='.$perPage.'&Page='.$page.$string.'&Salesman_number='.Auth::user()->id_phc,
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
     
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentPage = 1;

        if($response_decoded != null)
        {
            $currentItems = array_slice($response_decoded->customers, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);

        }
        else {
            $arrayInfo = ["paginator" => null, "nr_paginas" => null, "nr_registos" => null];
     
            return $arrayInfo; 
        }

        $arrayInfo = ["paginator" => $itemsPaginate, "nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];
        
        return $arrayInfo; 
    }

    public function getAllListagemClientesObject(): object
    {
        
        $nomeCliente = '&Name=';
        $numeroCliente = '&Customer_number=0';
        $zonaCliente = '&Zone=';
        $mobileCliente = '&Mobile_phone=';
        $emailCliente = '&Email=';
        $nifCliente = '&Nif=';

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$mobileCliente.$emailCliente.$nifCliente;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/customers/GetCustomers?perPage=99999999&Page=1'.$string.'&Salesman_number='.Auth::user()->id_phc,
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

    public function getListagemAnalisesCliente($perPage,$page,$idCliente): array
    {

        $curl = curl_init();
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/sales?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente);
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/sales?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente,
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
        // dd($response_decoded);
    
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        if($response_decoded->sales != null)
        {   
            $currentItems = array_slice($response_decoded->sales, $perPage * ($currentPage - 1), $perPage);
            
            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
 
        }
        else {
 
            $currentItems = [];
 
            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
        }
 
        $arrayAnalysis = [
            "paginator" => $itemsPaginate,
            "nr_paginas" => $response_decoded->total_pages, 
            "nr_registos" => $response_decoded->total_records
        ];
   
        return $arrayAnalysis;
    }

    public function getNumberOfPages($perPage): array
    {
        $nomeCliente = '&Name=';
        $numeroCliente = '&Customer_number=0';
        $zonaCliente = '&Zone=';
        $mobileCliente = '&Mobile_phone=';
        $emailCliente = '&Email=';
        $nifCliente = '&Nif=';

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$mobileCliente.$emailCliente.$nifCliente;
        

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/customers/GetCustomers?perPage='.$perPage.$string.'&Page=1&Salesman_number='.Auth::user()->id_phc,
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

        $arrayInfo = [];

        $arrayInfo = ["nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];

        return $arrayInfo;
    }

    /*** FILTROS ***/

    public function getListagemClienteFiltro($perPage,$page,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente): array
    {
        // dd($perPage,$page,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente);
        if ($nomeCliente != "") {
            $nomeCorrigido = str_replace(' ', '%20', $nomeCliente);
            $nomeCliente = '&Name='.$nomeCorrigido;
        } else {
            $nomeCliente = '&Name=';
        }
        
        if ($numeroCliente != "") {
            $numeroCliente = '&Customer_number='.urlencode($numeroCliente);
        } else {
            $numeroCliente = '&Customer_number=0';
        }
        
        if ($zonaCliente != "") {
            $zonaCliente = '&Zone='.urlencode($zonaCliente);
        } else {
            $zonaCliente = '&Zone=';
        }

        if ($telemovelCliente != "") {
            $telemovelCliente = '&Mobile_phone='.urlencode($telemovelCliente);
        } else {
            $telemovelCliente = '&Mobile_phone=';
        }

        if ($emailCliente != "") {
            $emailCliente = '&Email='.urlencode($emailCliente);
        } else {
            $emailCliente = '&Email=';
        }

        if ($nifCliente != "") {
            $nifCliente = '&Nif='.urlencode($nifCliente);
        } else {
            $nifCliente = '&Nif=';
        }

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$telemovelCliente.$emailCliente.$nifCliente;
        // dd( env('SANIPOWER_URL_DIGITAL').'/api/customers/GetCustomers?perPage='.$perPage.'&Page='.$page.'&Salesman_number='.Auth::user()->id_phc.$string);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/customers/GetCustomers?perPage='.$perPage.'&Page='.$page.'&Salesman_number='.Auth::user()->id_phc.$string,
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
        if(isset($response_decoded->Message))
        {
        if($response_decoded->Message == "An error has occurred.")
        {
            $response_decoded = null;
        }
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        if ($response_decoded != null && $response_decoded->success) {
            // Verifica se 'customers' é um array antes de usar array_slice
            $customers = is_array($response_decoded->customers) ? $response_decoded->customers : [];
    
            $currentItems = array_slice($customers, $perPage * ($currentPage - 1), $perPage);
            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_records, $perPage);

            $arrayInfo = ["paginator" => $itemsPaginate,"nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];
            return $arrayInfo;
        } else {
            // Caso a resposta não tenha sucesso ou seja nula, retorna um paginador vazio.
            $currentItems = [];
            $itemsPaginate = new LengthAwarePaginator($currentItems, 0, $perPage);

            $arrayInfo = ["paginator" => $itemsPaginate,"nr_paginas" => 0, "nr_registos" => 0];
            return $arrayInfo;
        }

        // $arrayInfo = ["paginator" => $itemsPaginate,"nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];
        // return $arrayInfo; 
    }
    public function getListagemClienteAllFiltro($perPage,$page,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$idPhcUser): LengthAwarePaginator
    {
        
        if ($nomeCliente != "") {
            $nomeCliente = '&Name='.urlencode($nomeCliente);
        } else {
            $nomeCliente = '&Name=';
        }
        
        if ($numeroCliente != "") {
            $numeroCliente = '&Customer_number='.urlencode($numeroCliente);
        } else {
            $numeroCliente = '&Customer_number=0';
        }
        
        if ($zonaCliente != "") {
            $zonaCliente = '&Zone='.urlencode($zonaCliente);
        } else {
            $zonaCliente = '&Zone=';
        }

        if ($telemovelCliente != "") {
            $telemovelCliente = '&Mobile_phone='.urlencode($telemovelCliente);
        } else {
            $telemovelCliente = '&Mobile_phone=';
        }

        if ($emailCliente != "") {
            $emailCliente = '&Email='.urlencode($emailCliente);
        } else {
            $emailCliente = '&Email=';
        }

        if ($nifCliente != "") {
            $nifCliente = '&Nif='.urlencode($nifCliente);
        } else {
            $nifCliente = '&Nif=';
        }

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$telemovelCliente.$emailCliente.$nifCliente;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/customers/GetCustomers?perPage='.$perPage.'&Page='.$page.'&Salesman_number='.$idPhcUser.$string,
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
       
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        if($response_decoded != null)
        {
            $currentItems = array_slice($response_decoded->customers, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
        }
        else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
        }

    
        return $itemsPaginate; 
    }

    public function getNumberOfPagesClienteFiltro($perPage,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente): array
    {

        if ($nomeCliente != "") {
            $nomeCliente = '&Name='.urlencode($nomeCliente);
        } else {
            $nomeCliente = '&Name=';
        }
        
        if ($numeroCliente != "") {
            $numeroCliente = '&Customer_number='.urlencode($numeroCliente);
        } else {
            $numeroCliente = '&Customer_number=0';
        }
        
        if ($zonaCliente != "") {
            $zonaCliente = '&Zone='.urlencode($zonaCliente);
        } else {
            $zonaCliente = '&Zone=';
        }

        if ($telemovelCliente != "") {
            $telemovelCliente = '&Mobile_phone='.urlencode($telemovelCliente);
        } else {
            $telemovelCliente = '&Mobile_phone=';
        }

        if ($emailCliente != "") {
            $emailCliente = '&Email='.urlencode($emailCliente);
        } else {
            $emailCliente = '&Email=';
        }

        if ($nifCliente != "") {
            $nifCliente = '&Nif='.urlencode($nifCliente);
        } else {
            $nifCliente = '&Nif=';
        }

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$telemovelCliente.$emailCliente.$nifCliente;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/customers/GetCustomers?perPage='.$perPage.'&Page=1&Salesman_number='.Auth::user()->id_phc.$string,
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
      

        $arrayInfo = [];

        $arrayInfo = ["nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];

        return $arrayInfo;
    }


    /**** END FILTROS ****/


    public function getDetalhesCliente($id): array
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/customers/GetCustomers?id='. $id,
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
        if (isset($response_decoded->Message) && $response_decoded->Message === 'An error has occurred.') {
            return  [
                "object" => null,
                "nr_paginas" =>null, 
                "nr_registos" => null
            ];
        } else {
            return 
            [
                "object" => $response_decoded,
                "nr_paginas" => $response_decoded->total_pages, 
                "nr_registos" => $response_decoded->total_records
            ];
        }

    //    return 
    //     [
    //         "object" => $response_decoded,
    //         "nr_paginas" => $response_decoded->total_pages, 
    //         "nr_registos" => $response_decoded->total_records
    //     ];
    }

   


    /***  DETALHES DO CLIENTE *****/

    public function getEncomendasCliente($perPage,$page,$idCliente): array
    {
        $nomeCliente = '&Name=';
        $numeroCliente = '&Customer_number=0';
        $zonaCliente = '&Zone=';
        $mobileCliente = '&Mobile_phone=';
        $emailCliente = '&Email=';
        $nifCliente = '&Nif=';
        $commentCliente = '&Comments=0';
        $typeCliente = '&type=0';

        $startDate = '&start_date=1900-01-01';
        $endDate = '&end_date=2900-12-31';
        $statusEncomenda = '&status=0';
        

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$mobileCliente.$emailCliente.$nifCliente.$commentCliente.$typeCliente.$startDate.$endDate.$statusEncomenda;

        $curl = curl_init();
      
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='.Auth::user()->id_phc.$string,
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
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='.Auth::user()->id_phc.$string, $response_decoded);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
       
        if($response_decoded->orders != null)
        {
            $currentItems = array_slice($response_decoded->orders, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);

        }
        else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
        }
    
        return [
            'paginator' => $itemsPaginate,
            "nr_paginas" => $response_decoded->total_pages, 
            "nr_registos" => $response_decoded->total_records
        ];
    }

    public function getNumberOfPagesAnalisesCliente($perPage,$idCliente): array
    {
        $nomeCliente = '&Name=';
        $numeroCliente = '&Customer_number=0';
        $zonaCliente = '&Zone=';
        $mobileCliente = '&Mobile_phone=';
        $emailCliente = '&Email=';
        $nifCliente = '&Nif=';
        $commentCliente = '&Comments=0';

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$mobileCliente.$emailCliente.$nifCliente.$commentCliente;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?perPage='.$perPage.'&Page=1&customer_id='.$idCliente.'&Salesman_number='.Auth::user()->id_phc.$string,
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

        $arrayInfo = [];

        $arrayInfo = ["nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];

        return $arrayInfo;
    }

    public function getNumberOfPagesEncomendasCliente($perPage,$idCliente): array
    {
        $nomeCliente = '&Name=';
        $numeroCliente = '&Customer_number=0';
        $zonaCliente = '&Zone=';
        $mobileCliente = '&Mobile_phone=';
        $emailCliente = '&Email=';
        $nifCliente = '&Nif=';
        $commentCliente = '&Comments=0';

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$mobileCliente.$emailCliente.$nifCliente.$commentCliente;
        $curl = curl_init();

        curl_setopt_array($curl, array(

            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?perPage='.$perPage.'&Page=1&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string,
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

        $arrayInfo = [];

        $arrayInfo = ["nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];

        return $arrayInfo;
    }

    public function getEncomendasClienteFiltro($perPage,$page,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$estadoEncomenda,$typeEncomenda,$startDate,$endDate,$statusEncomenda): array
    {
        // dd($perPage,$page,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$estadoEncomenda,$typeEncomenda,$startDate,$endDate,$statusEncomenda);
        if ($nomeCliente != "") {
            $nomeCliente = '&Name='.urlencode($nomeCliente);
        } else {
            $nomeCliente = '&Name=';
        }
        
        if ($numeroCliente != "") {
            $numeroCliente = '&Customer_number='.urlencode($numeroCliente);
        } else {
            $numeroCliente = '&Customer_number=0';
        }
        
        if ($zonaCliente != "") {
            $zonaCliente = '&Zone='.urlencode($zonaCliente);
        } else {
            $zonaCliente = '&Zone=';
        }

        if ($telemovelCliente != "") {
            $telemovelCliente = '&Mobile_phone='.urlencode($telemovelCliente);
        } else {
            $telemovelCliente = '&Mobile_phone=';
        }

        if ($emailCliente != "") {
            $emailCliente = '&Email='.urlencode($emailCliente);
        } else {
            $emailCliente = '&Email=';
        }

        if ($nifCliente != "") {
            $nifCliente = '&Nif='.urlencode($nifCliente);
        } else {
            $nifCliente = '&Nif=';
        }

        if ($estadoEncomenda != "0") {
            $commentCliente = '&Comments='.urlencode($estadoEncomenda);
        } else {
            $commentCliente = '&Comments=0';
        }
        if ($typeEncomenda != "0") {
            $typeCliente = '&type='.urlencode($typeEncomenda);
        } else {
            $typeCliente = '&type=0';
        }

        if ($startDate != "") {
            $startDate = '&start_date='.urlencode($startDate);
        } else {
            $startDate = '&start_date=1900-01-01';
        }
        if ($endDate != "") {
            $endDate = '&end_date='.urlencode($endDate);
        } else {
            $endDate = '&end_date=2900-12-31';
        }
        if ($statusEncomenda != "") {
            $statusEncomenda = '&status='.urlencode($statusEncomenda);
        } else {
            $statusEncomenda = '&status=0';
        }

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$telemovelCliente.$emailCliente.$nifCliente.$commentCliente.$typeCliente.$startDate.$endDate.$statusEncomenda;

        $curl = curl_init();
        // $url = env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string;
        // dd($url);
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string,
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
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string, $response_decoded);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if($response_decoded != null && $response_decoded->orders != null)
        {
            $currentItems = array_slice($response_decoded->orders, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
        }
        else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
        }

    
        return [
            'paginator' => $itemsPaginate,
            "nr_paginas" => $response_decoded->total_pages, 
            "nr_registos" => $response_decoded->total_records
        ];
    }

    public function getNumberOfPagesEncomendasFiltro($perPage,$pageChosen,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$estadoEncomenda): array
    {

        if ($nomeCliente != "") {
            $nomeCliente = '&Name='.urlencode($nomeCliente);
        } else {
            $nomeCliente = '&Name=';
        }
        
        if ($numeroCliente != "") {
            $numeroCliente = '&Customer_number='.urlencode($numeroCliente);
        } else {
            $numeroCliente = '&Customer_number=0';
        }
        
        if ($zonaCliente != "") {
            $zonaCliente = '&Zone='.urlencode($zonaCliente);
        } else {
            $zonaCliente = '&Zone=';
        }

        if ($telemovelCliente != "") {
            $telemovelCliente = '&Mobile_phone='.urlencode($telemovelCliente);
        } else {
            $telemovelCliente = '&Mobile_phone=';
        }

        if ($emailCliente != "") {
            $emailCliente = '&Email='.urlencode($emailCliente);
        } else {
            $emailCliente = '&Email=';
        }

        if ($nifCliente != "") {
            $nifCliente = '&Nif='.urlencode($nifCliente);
        } else {
            $nifCliente = '&Nif=';
        }
       
        if ($estadoEncomenda != "0") {
            $commentCliente = '&Comments='.urlencode($estadoEncomenda);
        } else {
            $commentCliente = '&Comments=0';
        }

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$telemovelCliente.$emailCliente.$nifCliente.$commentCliente; 
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?perPage='.$perPage.'&Page=1&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string,
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
        

        $arrayInfo = [];

        $arrayInfo = ["nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];

        return $arrayInfo;
    }


    
    public function getPropostasCliente($perPage,$page,$idCliente): array
    {
        $nomeCliente = '&Name=';
        $numeroCliente = '&Customer_number=0';
        $zonaCliente = '&Zone=';
        $mobileCliente = '&Mobile_phone=';
        $emailCliente = '&Email=';
        $nifCliente = '&Nif=';
        $commentCliente = '&Comments=0';
        $typeCliente = '&type=0';

        $startDate = '&start_date=1900-01-01';
        $endDate = '&end_date=2900-12-31';
        $statusEncomenda = '&status=0';

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$mobileCliente.$emailCliente.$nifCliente.$commentCliente.$typeCliente.$startDate.$endDate.$statusEncomenda;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            //NÃO FAZER UPLOAD DISSO ESTÁ ERRADO!!!!!!!
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/budgets?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='.Auth::user()->id_phc.$string,
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
    //    dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/budgets?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string);
        $response = curl_exec($curl);
    
        curl_close($curl);
    
        $response_decoded = json_decode($response);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // dd($response_decoded);
        if($response_decoded != null && $response_decoded->budgets != null)
        {
            $currentItems = array_slice($response_decoded->budgets, $perPage * ($currentPage - 1), $perPage);
            
            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
            
        }
        else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
        }

        return [
            'paginator' => $itemsPaginate,
            "nr_paginas" => $response_decoded->total_pages, 
            "nr_registos" => $response_decoded->total_records
        ];

        // return $itemsPaginate; 
    }

    public function getNumberOfPagesPropostasCliente($perPage,$idCliente): array
    {
        $nomeCliente = '&Name=';
        $numeroCliente = '&Customer_number=0';
        $zonaCliente = '&Zone=';
        $mobileCliente = '&Mobile_phone=';
        $emailCliente = '&Email=';
        $nifCliente = '&Nif=';
        $commentCliente = '&Comments=0';

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$mobileCliente.$emailCliente.$nifCliente.$commentCliente;

        $curl = curl_init();

        curl_setopt_array($curl, array(

            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/budgets?perPage='.$perPage.'&Page=1&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string,
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

        $arrayInfo = [];


        $arrayInfo = ["nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];

        return $arrayInfo;
    }

    public function getPropostasClienteFiltro($perPage,$page,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$estadoProposta,$typeProposta,$startDate,$endDate,$statusProsposta): array
    {
        // dd($perPage,$page,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$estadoProposta,$typeProposta,$startDate,$endDate,$statusProsposta);
        if ($nomeCliente != "") {
            $nomeCliente = '&Name='.urlencode($nomeCliente);
        } else {
            $nomeCliente = '&Name=';
        }
        
        if ($numeroCliente != "") {
            $numeroCliente = '&Customer_number='.urlencode($numeroCliente);
        } else {
            $numeroCliente = '&Customer_number=0';
        }
        
        if ($zonaCliente != "") {
            $zonaCliente = '&Zone='.urlencode($zonaCliente);
        } else {
            $zonaCliente = '&Zone=';
        }

        if ($telemovelCliente != "") {
            $telemovelCliente = '&Mobile_phone='.urlencode($telemovelCliente);
        } else {
            $telemovelCliente = '&Mobile_phone=';
        }

        if ($emailCliente != "") {
            $emailCliente = '&Email='.urlencode($emailCliente);
        } else {
            $emailCliente = '&Email=';
        }

        if ($nifCliente != "") {
            $nifCliente = '&Nif='.urlencode($nifCliente);
        } else {
            $nifCliente = '&Nif=';
        }
       
        if ($estadoProposta != "0" && $estadoProposta != "") {
            $commentCliente = '&Comments='.urlencode($estadoProposta);
        } else {
            $commentCliente = '&Comments=0';
        }
        if ($typeProposta != "0" && $typeProposta != "") {
            $typeCliente = '&type='.urlencode($typeProposta);
        } else {
            $typeCliente = '&type=0';
        }
        if ($startDate != "") {
            $startDate = '&start_date='.urlencode($startDate);
        } else {
            $startDate = '&start_date=1900-01-01';
        }
        if ($endDate != "") {
            $endDate = '&end_date='.urlencode($endDate);
        } else {
            $endDate = '&end_date=2900-12-31';
        }
        if ($statusProsposta != "") {
            $statusProsposta = '&status='.urlencode($statusProsposta);
        } else {
            $statusProsposta = '&status=0';
        }

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$telemovelCliente.$emailCliente.$nifCliente.$commentCliente.$typeCliente.$startDate.$endDate.$statusProsposta;
       

        $curl = curl_init();

        // dd($string);

        // $url = env('SANIPOWER_URL_DIGITAL').'/api/documents/budgets?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string;
        // dd($url);
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/budgets?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string,
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

        // dd($response_decoded);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();


        if(isset($response_decoded->budgets))
        {
                if($response_decoded != null && $response_decoded->budgets != null)
                {
                    $currentItems = array_slice($response_decoded->budgets, $perPage * ($currentPage - 1), $perPage);

                    $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
                }
                else {

                    $currentItems = [];

                    $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
                }
        } 
        else {
            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, 0 ,$perPage);
        }
       
        return [
            'paginator' => $itemsPaginate,
            "nr_paginas" => $response_decoded->total_pages, 
            "nr_registos" => $response_decoded->total_records
        ];
    
    }

    public function getNumberOfPagesPropostasFiltro($perPage,$pageChosen,$idCliente,$nomeCliente,$numeroCliente,$zonaCliente,$telemovelCliente,$emailCliente,$nifCliente,$estadoProposta): array
    {
        if ($nomeCliente != "") {
            $nomeCliente = '&Name='.urlencode($nomeCliente);
        } else {
            $nomeCliente = '&Name=';
        }
        
        if ($numeroCliente != "") {
            $numeroCliente = '&Customer_number='.urlencode($numeroCliente);
        } else {
            $numeroCliente = '&Customer_number=0';
        }
        
        if ($zonaCliente != "") {
            $zonaCliente = '&Zone='.urlencode($zonaCliente);
        } else {
            $zonaCliente = '&Zone=';
        }

        if ($telemovelCliente != "") {
            $telemovelCliente = '&Mobile_phone='.urlencode($telemovelCliente);
        } else {
            $telemovelCliente = '&Mobile_phone=';
        }

        if ($emailCliente != "") {
            $emailCliente = '&Email='.urlencode($emailCliente);
        } else {
            $emailCliente = '&Email=';
        }

        if ($nifCliente != "") {
            $nifCliente = '&Nif='.urlencode($nifCliente);
        } else {
            $nifCliente = '&Nif=';
        }
    
        if ($estadoProposta != "0") {
            $commentCliente = '&Comments='.urlencode($estadoProposta);
        }
        else {
            $commentCliente = '&Comments=0';
        }

        $string = $nomeCliente.$numeroCliente.$zonaCliente.$telemovelCliente.$emailCliente.$nifCliente.$commentCliente;
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/budgets?perPage='.$perPage.'&Page=1&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc.$string,
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
      
        $arrayInfo = [];

        $arrayInfo = ["nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];

        return $arrayInfo;
    }

    public function getEncomendaID($encomendaID): object
    {
        $curl = curl_init();
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?order_id='.$encomendaID);
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?order_id='.$encomendaID,
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
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/orders?order_id='.$encomendaID, $response_decoded);
        return $response_decoded; 
    }

    public function getPropostaID($propostaID): object
    {
        $curl = curl_init();
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/budget?budget_id='.$propostaID);
        curl_setopt_array($curl, array(

            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/budget?budget_id='.$propostaID,
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

        // dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/budget?budget_id='.$propostaID);

        $response = curl_exec($curl);
        curl_close($curl);
    
        $response_decoded = json_decode($response);

        return $response_decoded; 
    }

    public function sendComentarios($idProposta, $comentario, $type): JsonResponse
    {
        // $comentarioCreated = Comentarios::create([
        //     "stamp" => $idProposta,
        //     "tipo" => $type,
        //     "comentario" => $comentario,
        //     'id_user' => Auth::user()->id
        // ]);

        $comentarios = [
            "document_id" => $idProposta,
            "comment" => $comentario,
            "user" => Auth::user()->name,
            "date" => date('Y-m-d').'T'.date('H:i:s'),
            "hour" => date('H:i:s')
        ];
        $curl = curl_init();
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/comments', $comentarios);
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/comments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($comentarios),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // dd($response);
        $response_decoded = json_decode($response);
        if ($response_decoded->success == true) {
            // Inserção bem-sucedida
            return response()->json([
                'success' => true,
                'message' => 'Comentário adicionado com sucesso'
            ], 201);
        } else {
            // Falha na inserção
            return response()->json([
                'success' => false,
                'message' => 'Falha ao inserir na base de dados.'
            ], 500);
        }

        return $response_decoded;
    }

    public function getOcorrenciasCliente($perPage,$page,$idCliente): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(

            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/occurrences?perPage='.$perPage.'&Page='.$page.'&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc,
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

        // dd($response_decoded);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();


        if(isset($response_decoded->occurrences))
        {
                if($response_decoded != null && $response_decoded->occurrences != null)
                {
                    $currentItems = array_slice($response_decoded->occurrences, $perPage * ($currentPage - 1), $perPage);

                    $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
                }
                else {

                    $currentItems = [];

                    $itemsPaginate = new LengthAwarePaginator($currentItems, $response_decoded->total_pages,$perPage);
                }
        } 
        else {
            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, 0 ,$perPage);
        }
       

        return [
            'object' => $itemsPaginate,
            "nr_paginas" => $response_decoded->total_pages, 
            "nr_registos" => $response_decoded->total_records
        ];

    
        return $itemsPaginate; 
    }

    public function getNumberOfPagesOcorrenciasCliente($perPage,$idCliente): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(

            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/occurrences?perPage='.$perPage.'&Page=1&customer_id='.$idCliente.'&Salesman_number='. Auth::user()->id_phc,
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

        $arrayInfo = [];

        $arrayInfo = ["nr_paginas" => $response_decoded->total_pages, "nr_registos" => $response_decoded->total_records];

        return $arrayInfo;
    }


    public function storeVisita($idVisita,$numero_cliente,$assunto,$relatorio,$pendentes,$comentario_encomendas,$comentario_propostas,$comentario_financeiro,$comentario_occorencias): JsonResponse
    {
    
        $checkVisitaAgendada = Visitas::where('id_visita_agendada',$idVisita)->first();

        if(!empty($checkVisitaAgendada)){

            return response()->json([
                'success' => false,
                "type" => 1,
                'data' => "Essa Visita já foi registada"
            ], 201);
        }

        $visitaCreate = Visitas::create([
            "id_visita_agendada" => $idVisita,
            "numero_cliente" => $numero_cliente,
            "assunto" => $assunto,
            "relatorio" => $relatorio,
            "pendentes_proxima_visita" => $pendentes,
            "comentario_encomendas" => $comentario_encomendas,
            "comentario_propostas" => $comentario_propostas,
            "comentario_financeiro" => $comentario_financeiro,
            "comentario_ocorrencias" => $comentario_occorencias,
            "data" => date('Y-m-d'),
            "user_id" => Auth::user()->id
        ]);

        VisitasAgendadas::where('id',$idVisita)->update([
            "finalizado" => 1
        ]);

        if ($visitaCreate) {
            // Inserção bem-sucedida
            return response()->json([
                'success' => true,
                'data' => $visitaCreate
            ], 201);
        } else {
            // Falha na inserção
            return response()->json([
                'success' => false,
                'type' => 0,
                'message' => 'Falha ao inserir visita na base de dados.'
            ], 500);
        }

        return $visitaCreate;
    }


}