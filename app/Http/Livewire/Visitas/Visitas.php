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

class Visitas extends Component
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
    public ?string $estadoVisita = '';

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

    public ?string $clienteVisitaID = "";

    public $idAgendar;


    //PARTE GERAL
    protected ?object $visitas = NULL;

    public $clientesListagem;
  

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

        $this->nomeCliente = Session::get('nomeClienteVisitas');
        $this->numeroCliente = Session::get('numeroClienteVisitas');
        $this->zonaCliente = Session::get('zonaClienteVisitas');
        $this->telemovelCliente = Session::get('telemovelClienteVisitas');
        $this->emailCliente = Session::get('emailClienteVisitas');
        $this->nifCliente = Session::get('nifClienteVisitas');

        $this->estadoVisita = Session::get('estadoVisitaVisitas');


        // $this->clientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPages($this->perPage);

        // $this->numberMaxPages = $getInfoClientes["nr_paginas"] + 1;
        // $this->totalRecords = $getInfoClientes["nr_registos"];
        //$this->clientesListagem = [$this->clientesRepository->getListagemClientes(9999999,1)];

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
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro(9999999,1,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        $this->clientes = $arrayClientes["paginator"];

        Session::put('nomeClienteVisitas', $this->nomeCliente);
    }

    public function updatedNumeroCliente()
    {
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro(9999999,1,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        $this->clientes = $arrayClientes["paginator"];

        Session::put('numeroClienteVisitas', $this->numeroCliente);
        
    }

    public function updatedZonaCliente()
    {
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro(9999999,1,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        $this->clientes = $arrayClientes["paginator"];
        
        Session::put('zonaClienteVisitas', $this->zonaCliente);
    }

    public function updatedNifCliente()
    {
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro(9999999,1,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        $this->clientes = $arrayClientes["paginator"];
        
        Session::put('nifClienteVisitas', $this->nifCliente);
    }

    public function updatedTelemovelCliente()
    {
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro(9999999,1,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        $this->clientes = $arrayClientes["paginator"];
        
        Session::put('telemovelClienteVisitas', $this->telemovelCliente);
    
    }

    public function updatedEmailCliente()
    {
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro(9999999,1,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        $this->clientes = $arrayClientes["paginator"];
        
        Session::put('emailClienteVisitas', $this->emailCliente);
    }
    public function updatedEstadoVisita()
    {
        Session::put('estadoVisitaVisitas', $this->estadoVisita);
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
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function agendarVisita()
    {
        Session::put('activeModalFinalizado', '');

        $this->initProperties();

        $this->tipoVisita = TiposVisitas::all();

        $arrayClientes = $this->clientesRepository->getListagemClientes(9999999,1);
        $this->clientesListagem = [$arrayClientes["paginator"]];

        $this->dispatchBrowserEvent('modalAgendar');
    }

    public function finalizarVisita($clientID)
    {
        $this->initProperties();

        $arrayClientes = $this->clientesRepository->getListagemClientes(9999999,1);
        $this->clientesListagem = [$arrayClientes["paginator"]];

        $this->clientID = $clientID;

        $this->dispatchBrowserEvent('listagemVisitasModal');
    }
   

    public function newVisita()
    {
        $this->initProperties();

        $arrayClientes = $this->clientesRepository->getListagemClientes(9999999,1);
        $this->clientesListagem = [$arrayClientes["paginator"]];
    
        if($this->clienteVisitaID == "" ||$this->dataInicial == "" ||$this->horaInicial == "" || $this->horaFinal == "" || $this->tipoVisitaEscolhido == "" || $this->assuntoText == "" )
        {
            $this->dispatchBrowserEvent('openToastMessage', ["message" => "Tem de preencher todos os campos", "status" => "error"]);
            return false;
        }

        if(strtotime($this->horaInicial) > strtotime($this->horaFinal))
        {
            $this->dispatchBrowserEvent('openToastMessage', ["message" => "Hora final tem de ser superior á hora inicial", "status" => "error"]);
            return false;
        }

      

        $arrayCliente = $this->clientesRepository->getDetalhesCliente(json_decode($this->clienteVisitaID));
        $cliente = $arrayCliente["object"];


        $response = $this->visitasRepository->addVisitaDatabase($cliente->customers[0]->id, $cliente->customers[0]->name,preg_replace('/[a-zA-Z]/', '', $this->dataInicial), preg_replace('/[a-zA-Z]/', '', $this->horaInicial), preg_replace('/[a-zA-Z]/', '', $this->horaFinal), $this->tipoVisitaEscolhido, $this->assuntoText);

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

        $arrayClientes = $this->clientesRepository->getListagemClientes(9999999,1);
        $this->clientesListagem = [$arrayClientes["paginator"]];

        $this->initProperties();
        $this->dispatchBrowserEvent('sendToTeams',["tenant" => $tenant, "clientId" => $clientId, "clientSecret" => $clientSecret, "redirect" => $redirectUri, "visitaID" => json_decode($cliente->customers[0]->id),"visitaName" =>$cliente->customers[0]->name,"data" => preg_replace('/[a-zA-Z]/', '', $this->dataInicial), "horaInicial" =>preg_replace('/[a-zA-Z]/', '', $this->horaInicial), "horaFinal" => preg_replace('/[a-zA-Z]/', '', $this->horaFinal), "tipoVisita" => $this->tipoVisitaEscolhido, "assunto" => $this->assuntoText, "email" => Auth::user()->email, "organizer" => Auth::user()->name ]);
        $this->dispatchBrowserEvent('openToastMessage', ["message" => $message, "status" => $status]);

    }

    public function render()
    {       
       
        $this->visitas = VisitasAgendadas::query()
        ->when($this->nomeCliente, function($query) {

            $nomeCliente = str_replace('*', '%', $this->nomeCliente);
            // $this->nomeCliente = $nomeCliente;
            $query->where('cliente', 'like', '%' . $nomeCliente . '%');
                       
           
        }) ->when($this->estadoVisita, function($query) {

            if($this->estadoVisita == 3)
            {
                $this->estadoVisita = 0;
            }
            
            $query->where('finalizado', $this->estadoVisita);
                   
            if($this->estadoVisita == 0)
            {
                $this->estadoVisita = 3;
            }
           
        })
        ->when($this->numeroCliente, function($query) {

                if($this->numeroCliente != "") {
                
                    if($this->clientes->count() > 0)
                    {
                        $query->where('cliente', 'like', '%' . $this->clientes[0]->name . '%');
                    }  else {
                        $query->whereRaw('1 = 0');
                    }
                    
                }
            

        })->when($this->zonaCliente, function($query) {

           
                if($this->zonaCliente != "") {
                    $query->where(function($subQuery) {

                        if($this->clientes->count() > 0)
                        {
                            foreach($this->clientes as $index => $client)
                            {
                                if ($index == 0) {
                                    $subQuery->where('cliente', 'like', '%' . $client->name . '%');
                                } else {
                                    $subQuery->orWhere('cliente', 'like', '%' . $client->name . '%');
                                }
                            }
                        }

                    });
                
                }
            
        })->when($this->nifCliente, function($query) {

            
                if($this->nifCliente != "") {
                
                    $query->where(function($subQuery) {

                        if($this->clientes->count() > 0)
                        {
                            foreach($this->clientes as $index => $client)
                            {
                                if ($index == 0) {
                                    $subQuery->where('cliente', 'like', '%' . $client->name . '%');
                                } else {
                                    $subQuery->orWhere('cliente', 'like', '%' . $client->name . '%');
                                }
                            }
                        }
                    });
                
                }
            
        })->when($this->telemovelCliente, function($query) {

            
                if($this->telemovelCliente != "") {
                    $query->where(function($subQuery) {

                        if($this->clientes->count() > 0)
                        {
                            foreach($this->clientes as $index => $client)
                            {
                                if ($index == 0) {
                                    $subQuery->where('cliente', 'like', '%' . $client->name . '%');
                                } else {
                                    $subQuery->orWhere('cliente', 'like', '%' . $client->name . '%');
                                }
                            }
                        }

                    });
                
                }
            
        })
        ->when($this->emailCliente, function($query) {

           
                if($this->emailCliente != "") {
                    $query->where(function($subQuery) {

                        if($this->clientes->count() > 0)
                        {
                            foreach($this->clientes as $index => $client)
                            {
                                if ($index == 0) {
                                    $subQuery->where('cliente', 'like', '%' . $client->name . '%');
                                } else {
                                    $subQuery->orWhere('cliente', 'like', '%' . $client->name . '%');
                                }
                            }
                        }

                    });
                
                }
            
        })
        ->when(Auth::user()->nivel == 3, function($query) {
            $query->where('user_id', Auth::user()->id);
        })
       ->orderBy('data_inicial','DESC')
       ->paginate($this->perPage);

        if ($this->visitas == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Nao foi encontrado o cliente da visita. (erro : VT-401)');

            return view('pageErro');
        }

        $this->totalRecords = $this->visitas->total();
        $this->pageChosen = $this->visitas->currentPage();
        $this->numberMaxPages = $this->visitas->lastPage();

        $arrayClientes = $this->clientesRepository->getListagemClientes(9999999,1);
        $this->clientesListagem = [$arrayClientes["paginator"]];
        
        Session::put('activeModalFinalizado', '');
        return view('livewire.visitas.visitas',["visitas" => $this->visitas, "clientesListagem" => $this->clientesListagem]);
    }

}
