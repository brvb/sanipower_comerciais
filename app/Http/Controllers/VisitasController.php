<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitasAgendadas;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;

class VisitasController extends Controller
{
    private ?object $clientesRepository = NULL;
    public function __construct(ClientesInterface $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
    }
    public function index()
    {
        return view('visitas.index',["idAgendar" => ""]);
    }

    public function agendarVisita($id)
    {
        return view('visitas.index', ["idAgendar" => $id]);
    }

    public function showDetail($id)
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($id);
        $detailsClientes = $arrayCliente["object"];
        return view('visitas.details',["idVisita" => 0, "idCliente" => $id, "nameCliente" => $detailsClientes->customers[0]->name, "tst" => "2"]); // adicionar
    }

    public function endVisita($id)
    {
        $visitaAgendada = VisitasAgendadas::where('id',$id)->first();

        $arrayCliente = $this->clientesRepository->getDetalhesCliente($visitaAgendada->client_id);
        $detailsClientes = $arrayCliente["object"];
        return view('visitas.details',["idVisita" => $id, "idCliente" => $visitaAgendada->client_id, "nameCliente" => $detailsClientes->customers[0]->name, "tst" => "1"]); //finalizar
    }

    public function clienteList()
    {
        return view('visitas.clientes', ["idAgendar" => ""]);
    }

    public function visitasInfo($id)
    {
        $visitaAgendada = VisitasAgendadas::where('id',$id)->first();


        if ($visitaAgendada == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Nao foi encontrado a visita. (erro : VT-404)');

            return redirect()->route('visitas');
        }

        // dd($visitaAgendada);
        
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($visitaAgendada->client_id);

        if ($arrayCliente == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Nao foi encontrado o cliente da visita. (erro : VT-405)');

            return redirect()->route('visitas');
        }

        $detailsClientes = $arrayCliente["object"];
        
        return view('visitas.details',["idVisita" => $id, "idCliente" => $visitaAgendada->client_id, "nameCliente" => $detailsClientes->customers[0]->name, "tst" => "1"]);
    }
}