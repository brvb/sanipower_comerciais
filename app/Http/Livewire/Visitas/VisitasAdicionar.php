<?php

namespace App\Http\Livewire\Visitas;

use App\Models\User;
use Livewire\Component;
use App\Models\TiposVisitas;
use Livewire\WithPagination;
use App\Models\VisitasAgendadas;
use App\Interfaces\VisitasInterface;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;

class VisitasAdicionar extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;
    private ?object $clientesRepository = NULL;
    private ?object $visitasRepository = NULL;
    protected ?object $clientes = NULL;

    public ?string $nomeCliente = '';
    public ?string $numeroCliente = '';
    public ?string $zonaCliente = '';
    public ?string $telemovelCliente = '';
    public ?string $emailCliente = '';
    public ?string $nifCliente = '';

    public ?object $tipoVisita = NULL;
    public ?string $nomeClienteVisitaTemp = "";
    public ?string $idClienteVisitaTemp = "";

    //Parte do Modal da Visita
    public ?string $dataInicial = "";
    public ?string $horaInicial = "";
    public ?string $horaFinal = "";
    public ?string $tipoVisitaEscolhido = "";

    public ?string $assuntoText = "";

    protected $listagemVisitas;
    public ?string $clientID = "";

    public $idAgendar;


    //PARTE GERAL
    protected ?object $visitas = NULL;
   

    public function boot(ClientesInterface $clientesRepository, VisitasInterface $visitasRepository)
    {
        $this->clientesRepository = $clientesRepository;
        $this->visitasRepository = $visitasRepository;
    }

    private function initProperties(): void
    {
        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }

        // $this->nomeCliente = '';
        // $this->numeroCliente = '';
        // $this->zonaCliente = '';
        // $this->telemovelCliente = '';
        // $this->emailCliente = '';
        // $this->nifCliente = '';

        $this->nomeCliente = Session::get('nomeClienteVisitasCreate');
        $this->numeroCliente = Session::get('numeroClienteVisitasCreate');
        $this->zonaCliente = Session::get('zonaClienteVisitasCreate');
        $this->telemovelCliente = Session::get('telemovelClienteVisitasCreate');
        $this->emailCliente = Session::get('emailClienteVisitasCreate');
        $this->nifCliente = Session::get('nifClienteVisitasCreate');

   

        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"];
        $this->totalRecords = $arrayClientes["nr_registos"];



    }


    public function mount($idAgendar)
    {
        $this->initProperties();
       

        if($idAgendar != "") {
            $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idAgendar);
            $infoCliente = $arrayCliente["object"];
 
            $this->clientID = $idAgendar;

            $this->agendarVisita($idAgendar,$infoCliente->customers[0]->name);
        }

    }


    public function updatedNomeCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"];
        $this->totalRecords = $arrayClientes["nr_registos"];
        Session::put('nomeClienteVisitasCreate', $this->nomeCliente);
    }

    public function updatedNumeroCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"];
        $this->totalRecords = $arrayClientes["nr_registos"];
        Session::put('numeroClienteVisitasCreate', $this->numeroCliente);
    }

    public function updatedZonaCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"];
        $this->totalRecords = $arrayClientes["nr_registos"];
        Session::put('zonaClienteVisitasCreate', $this->zonaCliente);
    }

    public function updatedNifCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"];
        $this->totalRecords = $arrayClientes["nr_registos"];
        Session::put('nifClienteVisitasCreate', $this->nifCliente);
    }

    public function updatedTelemovelCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"];
        $this->totalRecords = $arrayClientes["nr_registos"];
        Session::put('telemovelClienteVisitasCreate', $this->telemovelCliente);
    }

    public function updatedEmailCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"];
        $this->totalRecords = $arrayClientes["nr_registos"];
        Session::put('emailClienteVisitasCreate', $this->emailCliente);
    }

    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        
        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
            $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
            $this->clientes = $arrayClientes["paginator"];
          
        } else {
            $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);

            $this->clientes = $arrayClientes["paginator"];
        }
      
    }


    public function previousPage()
    {
      
        if ($this->pageChosen > 1) {

            $this->pageChosen--;

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
                $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
                $this->clientes = $arrayClientes["paginator"];
            } else {
                $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
                $this->clientes = $arrayClientes["paginator"];
            }
            
        }
        else if($this->pageChosen == 1){

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
                $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
                $this->clientes = $arrayClientes["paginator"];
            } else {
                $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
                $this->clientes = $arrayClientes["paginator"];
            }
            
        }
    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {

            $this->pageChosen++;
            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
                $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
                $this->clientes = $arrayClientes["paginator"];
            } else {
                $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
                $this->clientes = $arrayClientes["paginator"];
            }
            
        }
    }

    public function getPageRange()
    {
        $currentPage = $this->pageChosen;
        
        $lastPage = $this->numberMaxPages;

        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);

        return range($start, $end);
    }

    public function isCurrentPage($page)
    {
        return $page == $this->pageChosen;
    }



    public function updatedPerPage(): void
    {
        $this->resetPage();
        session()->put('perPage', $this->perPage);

        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
            $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
            $this->clientes = $arrayClientes["paginator"];
            $this->numberMaxPages = $arrayClientes["nr_paginas"];
            $this->totalRecords = $arrayClientes["nr_registos"];
        } else {
            $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
            
            $this->clientes = $arrayClientes["paginator"];
            $this->numberMaxPages = $arrayClientes["nr_paginas"];
            $this->totalRecords = $arrayClientes["nr_registos"];
        }

    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function agendarVisita($clientID,$nome)
    {
        Session::put('activeModalFinalizado', '');

        $this->initProperties();

        $this->nomeClienteVisitaTemp = $nome;

        $this->idClienteVisitaTemp = $clientID;

        $this->tipoVisita = TiposVisitas::all();

        $this->dispatchBrowserEvent('modalAgendar',["clienteid" => $clientID, "nome" => json_encode($nome)]);
    }

    public function finalizarVisita($clientID)
    {
        $this->initProperties();

        $this->clientID = $clientID;

        $this->dispatchBrowserEvent('listagemVisitasModal');
    }
   

    public function newVisita($clienteID,$ClienteVisitaTemp)
    {
        $this->initProperties();

        if($this->dataInicial == "" ||$this->horaInicial == "" || $this->horaFinal == "" || $this->tipoVisitaEscolhido == "" || $this->assuntoText == "" )
        {
            $this->dispatchBrowserEvent('openToastMessage', ["message" => "Tem de preencher todos os campos", "status" => "error"]);
            return false;
        }

        if(strtotime($this->horaInicial) > strtotime($this->horaFinal))
        {
            $this->dispatchBrowserEvent('openToastMessage', ["message" => "Hora final tem de ser superior á hora inicial", "status" => "error"]);
            return false;
        }

        // dd($clienteVisitaID);

        $arrayCliente = $this->clientesRepository->getDetalhesCliente(json_decode($clienteID));
        $cliente = $arrayCliente["object"];

        $noClient = $cliente->customers[0]->no;

        $response = $this->visitasRepository->addVisitaDatabase($noClient,$clienteID,$ClienteVisitaTemp, preg_replace('/[a-zA-Z]/', '', $this->dataInicial), preg_replace('/[a-zA-Z]/', '', $this->horaInicial), preg_replace('/[a-zA-Z]/', '', $this->horaFinal), $this->tipoVisitaEscolhido, $this->assuntoText);

        $tenant = env('MICROSOFT_TENANT');
        $clientId = env('MICROSOFT_CLIENT_ID');
        $clientSecret = env('MICROSOFT_CLIENT_SECRET');
        $redirectUri = env('MICROSOFT_REDIRECT');
        
        $responseArray = $response->getData(true);

        if ($responseArray["success"] == true) {
            $message = "Visita agendada com sucesso";
            $status = "success";
        } else {
            $message = "Não foi possivel adicionar a visita!";
            $status = "error";
        }

        $this->emit('reloadNotification');

        $this->dispatchBrowserEvent('sendToTeams',["tenant" => $tenant, "clientId" => $clientId, "clientSecret" => $clientSecret, "redirect" => $redirectUri, "visitaID" => json_decode($clienteID),"visitaName" =>$ClienteVisitaTemp,"data" => preg_replace('/[a-zA-Z]/', '', $this->dataInicial), "horaInicial" =>preg_replace('/[a-zA-Z]/', '', $this->horaInicial), "horaFinal" => preg_replace('/[a-zA-Z]/', '', $this->horaFinal), "tipoVisita" => $this->tipoVisitaEscolhido, "assunto" => $this->assuntoText, "email" => Auth::user()->email, "organizer" => Auth::user()->name ]);
        $this->dispatchBrowserEvent('openToastMessage', ["message" => $message, "status" => $status]);

    }


    public function render()
    {        
        Session::put('activeModalFinalizado', '');
        return view('livewire.visitas.visitas-adicionar',["clientes" => $this->clientes]);
    }

}
