<?php

namespace App\Http\Livewire\Encomendas;

use Livewire\Component;
use App\Models\Comentarios;
use Livewire\WithPagination;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class Encomendas extends Component
{
    use WithPagination;
    
    public int $perPage = 10;
    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;
    private ?object $clientesRepository = NULL;
    protected ?object $clientes = NULL;
    protected ?object $encomendas = NULL;

    public ?array $encomendasByClient = NULL;

    public ?string $nomeCliente = '';
    public ?string $numeroCliente = '';
    public ?string $zonaCliente = '';
    public ?string $telemovelCliente = '';
    public ?string $emailCliente = '';
    public ?string $nifCliente = '';
    public $startDate = '';
    public $endDate = '';
    public int $statusEncomenda = 1;


    
    public $idCliente;

    public $estadoEncomenda = "0";

    public function boot(ClientesInterface $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
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

        $this->nomeCliente = session('verEncomendaNomeCliente');
        $this->numeroCliente = session('verEncomendaNumeroCliente');
        $this->zonaCliente = session('verEncomendaZonaCliente');
        $this->telemovelCliente = session('verEncomendaTelemovelCliente');
        $this->emailCliente = session('verEncomendaEmailCliente');
        $this->nifCliente = session('verEncomendaNifCliente');
        if(session('verEncomendaStartDate')){
            $this->startDate = session('verEncomendaStartDate');
        }
        if(session('verEncomendaEndDate')){
            $this->endDate = session('verEncomendaEndDate');
        }
        if(session('verEncomendaStatusEncomenda')){
            $this->statusEncomenda = session('verEncomendaStatusEncomenda');
        }
        
        $this->idCliente = '';

    }

    public function mount()
    {
        $this->initProperties();

        // $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        
        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];
        
        if(session('verEncoemendaPaginator')){
            $this->encomendas = session('verEncoemendaPaginator');
            if(session('verEncoemendaNr_paginas') == 0 || session('verEncoemendaNr_paginas')){
                $this->numberMaxPages = session('verEncoemendaNr_paginas');
            }
            if(session('verEncoemendaNr_registos')){
                $this->totalRecords = session('verEncoemendaNr_registos');
            }
            if(session('verEncomendaPageChosen')){
                $this->pageChosen = session('verEncomendaPageChosen');
            }
        }else{
            $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
            // $this->propostas = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
            // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasCliente($this->perPage,$this->idCliente);
            Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
            Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
            Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);
            
            $this->encomendas = session('verEncoemendaPaginator');
            $this->numberMaxPages = session('verEncoemendaNr_paginas');
            $this->totalRecords = session('verEncoemendaNr_registos');
        }
    }
    
   
    public function updatedNomeCliente()
    {
        $this->pageChosen = 1;
        Session::put('verEncomendaPageChosen', $this->pageChosen);
        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
        Session::put('verEncomendaNomeCliente',$this->nomeCliente);

        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];
    }

    public function updatedNumeroCliente()
    {
        $this->pageChosen = 1;
        Session::put('verEncomendaPageChosen', $this->pageChosen);

        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
        Session::put('verEncomendaNumeroCliente',$this->numeroCliente);
       
        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];

    }

    public function updatedZonaCliente()
    {
        $this->pageChosen = 1;
        Session::put('verEncomendaPageChosen', $this->pageChosen);

        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
        Session::put('verEncomendaZonaCliente',$this->zonaCliente);
       
        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];

    }

    public function updatedNifCliente()
    {
        $this->pageChosen = 1;
        Session::put('verEncomendaPageChosen', $this->pageChosen);

        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
        Session::put('verEncomendaNifCliente',$this->nifCliente);
       
        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];

    }

    public function updatedTelemovelCliente()
    {
        $this->pageChosen = 1;
        Session::put('verEncomendaPageChosen', $this->pageChosen);

        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
        Session::put('telemovelCliente',$this->telemovelCliente);
       
        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];

    }


    public function updatedEmailCliente()
    {
        $this->pageChosen = 1;
        Session::put('verEncomendaPageChosen', $this->pageChosen);

        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
        Session::put('verEncomendaEmailCliente',$this->emailCliente);
       
        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];
    }

    public function updatedEstadoEncomenda()
    {
        $this->pageChosen = 1;
        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
       
        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];

    }
    public function updatedStartDate()
    {
        $this->pageChosen = 1;
        Session::put('verEncomendaPageChosen', $this->pageChosen);

        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
        Session::put('verEncomendaStartDate',$this->startDate);
       
        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];

    }
    public function updatedEndDate()
    {
        $this->pageChosen = 1;
        Session::put('verEncomendaPageChosen', $this->pageChosen);

        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
        Session::put('verEncomendaEndDate',$this->endDate);
       
        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];

    }
    public function updatedStatusEncomenda()
    {
        $this->pageChosen = 1;
        Session::put('verEncomendaPageChosen', $this->pageChosen);

        $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
        Session::put('verEncomendaStatusEncomenda',$this->statusEncomenda);
       
        Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
        Session::put('verEncoemendaNr_paginas', $encomendasArray["nr_paginas"] + 1);
        Session::put('verEncoemendaNr_registos', $encomendasArray["nr_registos"]);

        $this->encomendas = session('verEncoemendaPaginator');
        $this->numberMaxPages = session('verEncoemendaNr_paginas');
        $this->totalRecords = session('verEncoemendaNr_registos');

        // $this->encomendas = $encomendasArray["paginator"];
        // $this->numberMaxPages = $encomendasArray["nr_paginas"];
        // $this->totalRecords = $encomendasArray["nr_registos"];

    }
    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        // dd($this->pageChosen);
        Session::put('verEncomendaPageChosen', $this->pageChosen);
 
        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoEncomenda != "0"){
            $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
            Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
            $this->encomendas = session('verEncoemendaPaginator');

            // $this->encomendas = $encomendasArray["paginator"];
        } else {
            $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);

            Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
            $this->encomendas = session('verEncoemendaPaginator');

            // $this->encomendas = $encomendasArray["paginator"];
        }
        
    }

   
    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;
            Session::put('verEncomendaPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoEncomenda != "0"){
                $type = 0;
             $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
                Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
                $this->encomendas = session('verEncoemendaPaginator');

                // $this->encomendas = $encomendasArray["paginator"];
            } else {
                $encomendasArray =  $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
                Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
                $this->encomendas = session('verEncoemendaPaginator');

                // $this->encomendas = $encomendasArray["paginator"];
            }
            }
            else if($this->pageChosen == 1){
                // Session::put('verEncomendaPageChosen', $this->pageChosen);

                if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoEncomenda != "0"){
                    $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
                    Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
                    $this->encomendas = session('verEncoemendaPaginator');

                    // $this->encomendas = $encomendasArray["paginator"];
                } else {
                    $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
                    Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
                    $this->encomendas = session('verEncoemendaPaginator');

                    // $this->encomendas = $encomendasArray["paginator"];
                }
            }
    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;
            Session::put('verEncomendaPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoEncomenda != "0"){
                $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
                Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
                $this->encomendas = session('verEncoemendaPaginator');

                // $this->encomendas = $encomendasArray["paginator"];
            } else {
                $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
                Session::put('verEncoemendaPaginator', $encomendasArray["paginator"]);
                $this->encomendas = session('verEncoemendaPaginator');

                // $this->encomendas = $encomendasArray["paginator"];
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

        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoEncomenda != "0"){
            $type = 0;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda,$type,$this->startDate,$this->endDate,$this->statusEncomenda);
       

            $this->encomendas = $encomendasArray["paginator"];
            $this->numberMaxPages = $encomendasArray["nr_paginas"] + 1;
            $this->totalRecords = $encomendasArray["nr_registos"];
        } else {
            
            $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        
            $this->encomendas = $encomendasArray["paginator"];
            $this->numberMaxPages = $encomendasArray["nr_paginas"] + 1;
            $this->totalRecords = $encomendasArray["nr_registos"];
        }
        

    }

    public function checkOrder($idEncomenda, $encomenda)
    {
        // if($this->estadoEncomenda != "")
        // {
        //     $this->encomendas = $this->clientesRepository->getEncomendasClienteFiltro(9999999,$this->pageChosen,"",$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
            
        // } else {
        //     $this->encomendas = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen,$this->idCliente);
        // }
     

        // foreach($this->encomendas as $enc)
        // {
        //     if($enc->id == $idEncomenda)
        //     {
        if ($encomenda == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Nao foi encontrado os detalhes dessa encomenda! (erro : EC-404)');

            return redirect()->route('encomendas');
        }
      

        $json = json_encode($encomenda);
        $object = json_decode($json, false);
     
        // dd($object);
                Session::put('rota','encomendas');
                Session::put('encomenda', $object);
                return redirect()->route('encomendas.encomenda', ['idEncomenda' => $idEncomenda]);
        //     }
        // }
    }
    public function redirectNewEncomenda($id)
    {
        session()->forget('searchSubFamily');

        session(['rota' => "encomendas"]);
        session(['parametro' => ""]);
        return redirect()->route('encomendas.detail', ['id' => $id]);
    }
    public function adicionarEncomenda()
    {
        Session::forget('encomenda');
        return redirect()->route('encomendas.nova');
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

        
    public function render()
    {
        if ($this->encomendas == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Erro ao consultar as encomendas! (erro : EC-401)');

            return view('pageErro');
        }
      
        return view('livewire.encomendas.encomendas',["encomendas" => $this->encomendas]);
    }
}
