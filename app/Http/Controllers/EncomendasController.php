<?php

namespace App\Http\Controllers;

use App\Models\Visitas;
use App\Models\Carrinho;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VisitasAgendadas;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;

class EncomendasController extends Controller
{
    
    private ?object $clientesRepository = NULL;

    public function __construct(ClientesInterface $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
    }
    public function index()
    {
        return view('encomendas.index');
    }

    public function showDetail($id)
    {
        // Session::put('rota','encomendas.nova');

        $arrayCliente = $this->clientesRepository->getDetalhesCliente($id);
        $detailsClientes = $arrayCliente["object"];
  
        $checkCarrinho = Carrinho::where("id_user", Auth::user()->id)
                    ->where('id_cliente',$detailsClientes->customers[0]->no)
                    ->first();
        
        if(empty($checkCarrinho->id_encomenda) ){
            $codEncomenda = $detailsClientes->customers[0]->no;
            $randomChar = mt_rand(1000000, 9999999);
            $codEncomenda .= $randomChar;
        }else{
            $codEncomenda = $checkCarrinho->id_encomenda;
          
        }
        return view('encomendas.details',["codvisita" => null,"idCliente" => $id,"nameCliente" => $detailsClientes->customers[0]->name, "codEncomenda" => $codEncomenda, "encomenda" => null]);
    }

    public function showDetailVisitas($id,$idVisita)
    {
        // Session::put('rota','encomendas.nova');

        $arrayCliente = $this->clientesRepository->getDetalhesCliente($id);
        $detailsClientes = $arrayCliente["object"];
     
        $checkCarrinho = Carrinho::where("id_user", Auth::user()->id)
                    ->where('id_cliente',$detailsClientes->customers[0]->no)
                    ->first();

        
        if(empty($checkCarrinho)){
            $codEncomenda = $detailsClientes->customers[0]->no;
            $randomChar = mt_rand(1000000, 9999999);
            $codEncomenda .= $randomChar;
        }else{
            $codEncomenda = $checkCarrinho->id_encomenda;
        }

        return view('encomendas.details',["codvisita"=>$idVisita, "idCliente" => $id,"nameCliente" => $detailsClientes->customers[0]->name, "codEncomenda" => $codEncomenda, "encomenda" => null]);
    }

    public function showDetailEncomenda($idEncomenda)
    {
        if($idEncomenda == "nova")
        {
      
            return view('encomendas.clientes');
        } 
        else
        {
            $encomenda = Session::get('encomenda');   
            return view('encomendas.details',["idCliente" => "", "codEncomenda" => "","encomenda" => $encomenda]);
        }

    }

    public function encomendasList()
    {
        
        return view('encomendas.clientes');
    }
}
