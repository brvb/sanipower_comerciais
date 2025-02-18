<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;


class OcorrenciasController extends Controller
{
    private ?object $clientesRepository = NULL;
    public function __construct(ClientesInterface $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
    }
    
    public function index()
    {
        return view('ocorrencias.index');
    }

    public function showDetail($id)
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($id);
        $detailsClientes = $arrayCliente["object"];
        // dd($detailsClientes);
        return view('ocorrencias.newocorrencia',["cliente" =>  $detailsClientes, "nameCliente" => $detailsClientes->customers[0]->name]);
    }

    public function showDetailOcorrencia($idOcorrencia)
    {
            $ocorrencia = Session::get('ocorrencia');
            if($ocorrencia == null)
            {
                $ocorrencia = $this->clientesRepository->getOcorrenciasID($idOcorrencia);
                $ocorrencia = $ocorrencia['object'][0];
            }
            Session::put('ocorrencia', $ocorrencia);
            return view('ocorrencias.details',["ocorrencia" => $ocorrencia]);
        
    }

    public function ocorrenciasList()
    {
        return view('ocorrencias.clientes');
    }

}
