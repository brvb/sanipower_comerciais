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

    public function showDetailOcorrencia($idOcorrencia)
    {
        if($idOcorrencia == "nova")
        {
            return view('ocorrencias.clientes');
        } 
        else
        {
            $ocorrencia = Session::get('ocorrencia');
            return view('ocorrencias.details',["ocorrencia" => $ocorrencia]);
        }
       
    }

}
