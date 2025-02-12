<?php

namespace App\Http\Livewire\Ocorrencias;

use Livewire\Component;
use Livewire\WithPagination;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;
use App\Interfaces\PropostasInterface;


class OcorrenciasAdicionar extends Component
{
    use WithPagination;
    
    public int $perPage = 10;
    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;
    private ?object $clientesRepository = NULL;
    private ?object $PropostasRepository = null;
    protected ?object $clientes = NULL;

    public ?string $nomeCliente = '';
    public ?string $numeroCliente = '';
    public ?string $zonaCliente = '';
    public ?string $telemovelCliente = '';
    public ?string $emailCliente = '';
    public ?string $nifCliente = '';
    

    public function boot(ClientesInterface $clientesRepository, PropostasInterface $PropostasRepository)
    {
        $this->clientesRepository = $clientesRepository;
        $this->PropostasRepository = $PropostasRepository;

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


        $this->nomeCliente = session('AdiOcorrenciaNomeCliente');
        $this->numeroCliente = session('AdiOcorrenciaNumeroCliente');
        $this->zonaCliente = session('AdiOcorrenciaZonaCliente');
        $this->telemovelCliente = session('AdiOcorrenciaTelemovelCliente');
        $this->emailCliente = session('AdiOcorrenciaEmailCliente');
        $this->nifCliente = session('AdiOcorrenciaNifCliente');
    }

    public function mount()
    {
        $this->initProperties();

        if(session('AdiOcorrenciaPaginator')){
            $this->clientes = session('AdiOcorrenciaPaginator');
            
            if(session('AdiOcorrenciaNr_paginas') == 0 || session('AdiOcorrenciaNr_paginas')){
                
                $this->numberMaxPages = session('AdiOcorrenciaNr_paginas');
                
            }
            if(session('AdiOcorrenciaNr_registos')){
                $this->totalRecords = session('AdiOcorrenciaNr_registos');
            }
            if(session('AdiOcorrenciaPageChosen')){
                $this->pageChosen = session('AdiOcorrenciaPageChosen');
            }
        }else{
            $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
            Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
            Session::put('AdiOcorrenciaNr_paginas', $arrayClientes["nr_paginas"]);
            Session::put('AdiOcorrenciaNr_registos', $arrayClientes["nr_registos"]);
            
    

            $this->clientes = session('AdiOcorrenciaPaginator');
            $this->numberMaxPages = session('AdiOcorrenciaNr_paginas');
            $this->totalRecords = session('AdiOcorrenciaNr_registos');


            // $this->clientes = $arrayClientes["paginator"];
            // $this->numberMaxPages = $arrayClientes["nr_paginas"];
            // $this->totalRecords = $arrayClientes["nr_registos"];
        }
        
    }

    
    public function rotaDetailOcorrencias($id){

        $this->clientes = session('AdiOcorrenciaPaginator');
        return redirect()->route('ocorrencias.detail', ['id' => $id]);

    }

    public function updatedNomeCliente()
    {
        $this->pageChosen = 1;
        Session::put('AdiOcorrenciaPageChosen', $this->pageChosen);

        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        Session::put('AdiOcorrenciaNomeCliente',$this->nomeCliente);


        Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
        Session::put('AdiOcorrenciaNr_paginas', $arrayClientes["nr_paginas"]);
        Session::put('AdiOcorrenciaNr_registos', $arrayClientes["nr_registos"]);


        $this->clientes = session('AdiOcorrenciaPaginator');
        $this->numberMaxPages = session('AdiOcorrenciaNr_paginas');
        $this->totalRecords = session('AdiOcorrenciaNr_registos');

        // $this->clientes = $arrayClientes["paginator"];
        // $this->numberMaxPages = $arrayClientes["nr_paginas"];
        // $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function updatedNumeroCliente()
    {
        $this->pageChosen = 1;
        Session::put('AdiOcorrenciaPageChosen', $this->pageChosen);

        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        Session::put('AdiOcorrenciaNumeroCliente',$this->numeroCliente);

        Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
        Session::put('AdiOcorrenciaNr_paginas', $arrayClientes["nr_paginas"]);
        Session::put('AdiOcorrenciaNr_registos', $arrayClientes["nr_registos"]);

        $this->clientes = session('AdiOcorrenciaPaginator');
        $this->numberMaxPages = session('AdiOcorrenciaNr_paginas');
        $this->totalRecords = session('AdiOcorrenciaNr_registos');

        // $this->clientes = $arrayClientes["paginator"];
        // $this->numberMaxPages = $arrayClientes["nr_paginas"];
        // $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function updatedZonaCliente()
    {
        $this->pageChosen = 1;
        Session::put('AdiOcorrenciaPageChosen', $this->pageChosen);

        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        Session::put('AdiOcorrenciaZonaCliente',$this->zonaCliente);

        Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
        Session::put('AdiOcorrenciaNr_paginas', $arrayClientes["nr_paginas"]);
        Session::put('AdiOcorrenciaNr_registos', $arrayClientes["nr_registos"]);


        $this->clientes = session('AdiOcorrenciaPaginator');
        $this->numberMaxPages = session('AdiOcorrenciaNr_paginas');
        $this->totalRecords = session('AdiOcorrenciaNr_registos');

        // $this->clientes = $arrayClientes["paginator"];
        // $this->numberMaxPages = $arrayClientes["nr_paginas"];
        // $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function updatedNifCliente()
    {
        $this->pageChosen = 1;
        Session::put('AdiOcorrenciaPageChosen', $this->pageChosen);

        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        Session::put('AdiOcorrenciaNifCliente',$this->nifCliente);

        Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
        Session::put('AdiOcorrenciaNr_paginas', $arrayClientes["nr_paginas"]);
        Session::put('AdiOcorrenciaNr_registos', $arrayClientes["nr_registos"]);


        $this->clientes = session('AdiOcorrenciaPaginator');
        $this->numberMaxPages = session('AdiOcorrenciaNr_paginas');
        $this->totalRecords = session('AdiOcorrenciaNr_registos');

        // $this->clientes = $arrayClientes["paginator"];
        // $this->numberMaxPages = $arrayClientes["nr_paginas"];
        // $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function updatedTelemovelCliente()
    {
        $this->pageChosen = 1;
        Session::put('AdiOcorrenciaPageChosen', $this->pageChosen);

        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        Session::put('AdiOcorrenciaTelemovelCliente',$this->telemovelCliente);

        Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
        Session::put('AdiOcorrenciaNr_paginas', $arrayClientes["nr_paginas"]);
        Session::put('AdiOcorrenciaNr_registos', $arrayClientes["nr_registos"]);

        $this->clientes = session('AdiOcorrenciaPaginator');
        $this->numberMaxPages = session('AdiOcorrenciaNr_paginas');
        $this->totalRecords = session('AdiOcorrenciaNr_registos');

        // $this->clientes = $arrayClientes["paginator"];
        // $this->numberMaxPages = $arrayClientes["nr_paginas"];
        // $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function updatedEmailCliente()
    {
        $this->pageChosen = 1;
        Session::put('AdiOcorrenciaPageChosen', $this->pageChosen);

        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        Session::put('AdiOcorrenciaEmailCliente',$this->emailCliente);

        Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
        Session::put('AdiOcorrenciaNr_paginas', $arrayClientes["nr_paginas"]);
        Session::put('AdiOcorrenciaNr_registos', $arrayClientes["nr_registos"]);

        $this->clientes = session('AdiOcorrenciaPaginator');
        $this->numberMaxPages = session('AdiOcorrenciaNr_paginas');
        $this->totalRecords = session('AdiOcorrenciaNr_registos');

        // $this->clientes = $arrayClientes["paginator"];
        // $this->numberMaxPages = $arrayClientes["nr_paginas"];
        // $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        Session::put('AdiOcorrenciaPageChosen', $this->pageChosen);


        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
            $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
            
            Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
            $this->clientes = session('AdiOcorrenciaPaginator');
            
            // $this->clientes = $arrayClientes["paginator"];
        } else {
            $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
                        
            Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
            $this->clientes = session('AdiOcorrenciaPaginator');
            
            // $this->clientes = $arrayClientes["paginator"];
        }
        
    }

   
    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;
            Session::put('AdiOcorrenciaPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
                $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
                             
                Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
                $this->clientes = session('AdiOcorrenciaPaginator');
                
                // $this->clientes = $arrayClientes["paginator"];
            } else {
                $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);

                Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
                $this->clientes = session('AdiOcorrenciaPaginator');

                // $this->clientes = $arrayClientes["paginator"];
            }
        }
        else if($this->pageChosen == 1){
            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
                $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
                
                Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
                $this->clientes = session('AdiOcorrenciaPaginator');

                // $this->clientes = $arrayClientes["paginator"];
            } else {
                $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);

                Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
                $this->clientes = session('AdiOcorrenciaPaginator');

                // $this->clientes = $arrayClientes["paginator"];
            }
        }
    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;
            Session::put('AdiOcorrenciaPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
                $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
                
                Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
                $this->clientes = session('AdiOcorrenciaPaginator');

                // $this->clientes = $arrayClientes["paginator"];
            } else {
                $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
                                
                Session::put('AdiOcorrenciaPaginator', $arrayClientes["paginator"]);
                $this->clientes = session('AdiOcorrenciaPaginator');

                // $this->clientes = $arrayClientes["paginator"];
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

        
    public function render()
    {
        return view('livewire.ocorrencias.ocorrencias-adicionar',["clientes" => $this->clientes]);
    }
}
