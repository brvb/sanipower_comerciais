<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Interfaces\ClientesInterface;

class ClientesController extends Controller
{

    private ?object $clientesRepository = NULL;
    public function __construct(ClientesInterface $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
    }
    
    public function index()
    {
        return view('clientes.index');
    }

    public function showDetail($id)
    {
        // $detailsClientes = $this->clientesRepository->getDetalhesCliente($id);
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($id);

        if (!$arrayCliente["object"]) {
            session()->flash('status', 'error');
            session()->flash('message', 'Ocorreu um erro ao tentar consultar as informações do cliente.(erro: CL-404)');

            return redirect()->route('clientes');
        }
        $detailsClientes = $arrayCliente["object"];
        return view('clientes.details',["idCliente" => $id ,"nameCliente" => $detailsClientes->customers[0]->name]);
    }
}
