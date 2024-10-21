<?php

namespace App\Http\Livewire\Propostas;

use Livewire\Component;
use App\Models\Comentarios;
use Livewire\WithPagination;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Route;
use App\Interfaces\PropostasInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class Propostas extends Component
{
    use WithPagination;
    
    public int $perPage = 10;
    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;
    private ?object $clientesRepository = NULL;

    protected ?object $clientes = NULL;
    protected $propostas = NULL;

    public ?string $nomeCliente = '';
    public ?string $numeroCliente = '';
    public ?string $zonaCliente = '';
    public ?string $telemovelCliente = '';
    public ?string $emailCliente = '';
    public ?string $nifCliente = '';
    public $startDate = '';
    public $endDate = '';
    public int $statusProsposta = 1;



    public $idCliente;

    public $estadoProposta = "0";
    

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

        $this->nomeCliente = session('verPropostaNomeCliente');
        $this->numeroCliente = session('verPropostaNumeroCliente');
        $this->zonaCliente = session('verPropostaZonaCliente');
        $this->telemovelCliente = session('verPropostaTelemovelCliente');
        $this->emailCliente = session('verPropostaEmailCliente');
        $this->nifCliente = session('verPropostaNifCliente');
        if(session('verPropostaStartDate')){
            $this->startDate = session('verPropostaStartDate');
        }
        if(session('verPropostaEndDate')){
            $this->endDate = session('verPropostaEndDate');
        }
        if(session('verPropostaStatusProsposta')){
            $this->statusProsposta = session('verPropostaStatusProsposta');
        }


        $this->idCliente = '';
    }

    public function mount()
    {
        // dd('Aqui');
        $this->initProperties();
        // $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        // $this->propostas = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasCliente($this->perPage,$this->idCliente);
        // $this->propostas = $propostasArray["paginator"];
        // $this->numberMaxPages = $propostasArray["nr_paginas"];
        // $this->totalRecords = $propostasArray["nr_registos"];

        // $this->propostas = session('verPropostaPaginator');
        // $this->numberMaxPages = session('verPropostaNr_paginas');
        // $this->totalRecords = session('verPropostaNr_registos');
        
        // $this->pageChosen = session('verPropostaPageChosen');



        if(session('verPropostaPaginator')){
            $type = 0;

            $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
            Session::put('verPropostaNomeCliente',$this->nomeCliente);
            Session::put('verPropostaNumeroCliente',$this->numeroCliente);
            Session::put('verPropostaZonaCliente',$this->zonaCliente);
            Session::put('verPropostaTelemovelCliente',$this->telemovelCliente);
            Session::put('verPropostaNifCliente',$this->nifCliente);

            Session::put('verPropostaPaginator', $propostasArray["paginator"]);
            Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
            Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);


            $this->propostas = session('verPropostaPaginator');
            $this->numberMaxPages = session('verPropostaNr_paginas');
            $this->totalRecords = session('verPropostaNr_registos');
        }else{
            $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
            // $this->propostas = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
            // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasCliente($this->perPage,$this->idCliente);
            Session::put('verPropostaPaginator', $propostasArray["paginator"]);
            Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
            Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);
            
            $this->propostas = session('verPropostaPaginator');
            $this->numberMaxPages = session('verPropostaNr_paginas');
            $this->totalRecords = session('verPropostaNr_registos');
        }
        
        
    }

    public function updatedNomeCliente()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        Session::put('verPropostaNomeCliente',$this->nomeCliente);

        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);


        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');

        // $this->propostas = $propostasArray["paginator"];
        // $this->numberMaxPages = $propostasArray["nr_paginas"];
        // $this->totalRecords = $propostasArray["nr_registos"];
    }

    public function updatedNumeroCliente()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        Session::put('verPropostaNumeroCliente',$this->numeroCliente);

        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);


        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');

        // $this->propostas = $propostasArray["paginator"];
        // $this->numberMaxPages = $propostasArray["nr_paginas"];
        // $this->totalRecords = $propostasArray["nr_registos"];
    }

    public function updatedZonaCliente()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        Session::put('verPropostaZonaCliente',$this->zonaCliente);

        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);


        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');

        // $this->propostas = $propostasArray["paginator"];
        // $this->numberMaxPages = $propostasArray["nr_paginas"];
        // $this->totalRecords = $propostasArray["nr_registos"];
    }

    public function updatedNifCliente()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);

        Session::put('verPropostaNifCliente',$this->nifCliente);

        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);


        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');

        // $this->propostas = $propostasArray["paginator"];
        // $this->numberMaxPages = $propostasArray["nr_paginas"];
        // $this->totalRecords = $propostasArray["nr_registos"];
    }

    public function updatedTelemovelCliente()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        Session::put('verPropostaTelemovelCliente',$this->telemovelCliente);

        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);


        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');

        // $this->propostas = $propostasArray["paginator"];
        // $this->numberMaxPages = $propostasArray["nr_paginas"];
        // $this->totalRecords = $propostasArray["nr_registos"];
    }

    public function updatedEmailCliente()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        Session::put('verPropostaEmailCliente',$this->emailCliente);

        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);


        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');

        // $this->propostas = $propostasArray["paginator"];
        // $this->numberMaxPages = $propostasArray["nr_paginas"];
        // $this->totalRecords = $propostasArray["nr_registos"];
    }

    public function updatedEstadoProposta()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        
        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);

        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');
    
    }

    public function updatedStartDate()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        Session::put('verPropostaStartDate',$this->startDate);
        

        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);

        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');
    
    }
    public function updatedEndDate()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        Session::put('verPropostaEndDate',$this->endDate);
        

        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);

        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');
    
    }
    public function updatedStatusProsposta()
    {
        $this->pageChosen = 1;
        Session::put('verPropostaPageChosen', $this->pageChosen);

        $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
        // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
        Session::put('verPropostaStatusProsposta',$this->statusProsposta);
        

        Session::put('verPropostaPaginator', $propostasArray["paginator"]);
        Session::put('verPropostaNr_paginas', $propostasArray["nr_paginas"] + 1);
        Session::put('verPropostaNr_registos', $propostasArray["nr_registos"]);

        $this->propostas = session('verPropostaPaginator');
        $this->numberMaxPages = session('verPropostaNr_paginas');
        $this->totalRecords = session('verPropostaNr_registos');
    
    }

    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        Session::put('verPropostaPageChosen', $this->pageChosen);
        
        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoProposta != "0"){
            $type = 0;

        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
            
            Session::put('verPropostaPaginator', $propostasArray["paginator"]);
            $this->propostas = session('verPropostaPaginator');

            // $this->propostas = $propostasArray["paginator"];
        } else {
            $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
            
            Session::put('verPropostaPaginator', $propostasArray["paginator"]);
            $this->propostas = session('verPropostaPaginator');

            // $this->propostas = $propostasArray["paginator"];
        }
        
    }

   
    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;
            Session::put('verPropostaPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoProposta != "0"){
                $type = 0;

                $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
                
                Session::put('verPropostaPaginator', $propostasArray["paginator"]);
                $this->propostas = session('verPropostaPaginator');
                
                // $this->propostas = $propostasArray["paginator"];
            } else {
                $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
                
                Session::put('verPropostaPaginator', $propostasArray["paginator"]);
                $this->propostas = session('verPropostaPaginator');
                
                // $this->propostas = $propostasArray["paginator"];
            }
        }
        else if($this->pageChosen == 1){
            Session::put('verEncomendaPageChosen', $this->pageChosen);
            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoProposta != "0"){
                $type = 0;

                $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
                
                Session::put('verPropostaPaginator', $propostasArray["paginator"]);
                $this->propostas = session('verPropostaPaginator');
                
                // $this->propostas = $propostasArray["paginator"];
            } else {
                $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
                                
                Session::put('verPropostaPaginator', $propostasArray["paginator"]);
                $this->propostas = session('verPropostaPaginator');
                
                // $this->propostas = $propostasArray["paginator"];
            }
        }
    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;
            Session::put('verPropostaPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoProposta != "0"){
                $type = 0;

                $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
                                
                Session::put('verPropostaPaginator', $propostasArray["paginator"]);
                $this->propostas = session('verPropostaPaginator');
                
                // $this->propostas = $propostasArray["paginator"];
            } else {
                $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
                                
                Session::put('verPropostaPaginator', $propostasArray["paginator"]);
                $this->propostas = session('verPropostaPaginator');
                
                // $this->propostas = $propostasArray["paginator"];
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

        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->estadoProposta != "0"){
            // $this->propostas = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
            // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasFiltro($this->perPage,1,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);

            // $this->numberMaxPages = $getInfoClientes["nr_paginas"];
            // $this->totalRecords = $getInfoClientes["nr_registos"];

            $type = 0;

            $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$type,$this->startDate,$this->endDate,$this->statusProsposta);
          
            $this->propostas = $propostasArray["paginator"];
            $this->numberMaxPages = $propostasArray["nr_paginas"] + 1;
            $this->totalRecords = $propostasArray["nr_registos"];
        } else {
            $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
           
            $this->propostas = $propostasArray["paginator"];
            $this->numberMaxPages = $propostasArray["nr_paginas"] + 1;
            $this->totalRecords = $propostasArray["nr_registos"];
           
            // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasCliente($this->perPage,$this->idCliente);

            // $this->numberMaxPages = $getInfoClientes["nr_paginas"];
            // $this->totalRecords = $getInfoClientes["nr_registos"];
        }
        

    }
    public function redirectNewProposta($id)
    {
        session()->forget('searchSubFamily');

        session(['rota' => "propostas"]);
        session(['parametro' => ""]);

        return redirect()->route('propostas.detail', ['id' => $id]);
    }
    public function adicionarProposta()
    {
        Session::forget('proposta');
        return redirect()->route('propostas.nova');
    }

    public function checkOrder($idProposta, $proposta)
    {
        // dd($idProposta);
        // if($this->estadoProposta != "0")
        // {
        //     $this->propostas = $this->clientesRepository->getPropostasCliente(999999,$this->pageChosen,"");
        // } 
        // else 
        // {   
        //     $this->propostas = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
        // }
       
       
        // foreach($this->propostas as $enc)
        // {
        //     dD($enc);
        //     if($enc->id == $idProposta)
        //     {
            
        if ($proposta == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Nao foi encontrado os detalhes dessa proposta! (erro : EC-404)');

            return redirect()->route('propostas');
        }
        $json = json_encode($proposta);
        $object = json_decode($json, false);


        Session::put('proposta', $object);
        Session::put('rota','propostas');
        return redirect()->route('propostas.proposta', ['idProposta' => $idProposta]);
        //     }
        // }
    }


    public function paginationView()
    {
        return 'livewire.pagination';
    }

        
    public function render()
    {
        if ($this->propostas == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Erro ao consultar as propostas! (erro : PT-401)');

            return view('pageErro');
        }

        return view('livewire.propostas.propostas',["propostas" => $this->propostas]);
    }
}
