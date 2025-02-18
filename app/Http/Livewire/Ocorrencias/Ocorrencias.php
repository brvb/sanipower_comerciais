<?php

namespace App\Http\Livewire\Ocorrencias;

use Livewire\Component;
use App\Models\Comentarios;
use Livewire\WithPagination;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Route;
use App\Interfaces\PropostasInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class Ocorrencias extends Component
{
    use WithPagination;
    
    public int $perPage = 10;
    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;
    private ?object $clientesRepository = NULL;

    protected ?object $clientes = NULL;
    protected $ocorrencias = NULL;

    public ?string $nomeCliente = '';
    public ?string $numeroCliente = '';
    public ?string $zonaCliente = '';
    public ?string $telemovelCliente = '';
    public ?string $emailCliente = '';
    public ?string $nifCliente = '';
    public $startDate = '';
    public $endDate = '';
    public int $statusOcorrencia = 0;

    protected $idCliente;
    

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

        $this->nomeCliente = '';
        $this->numeroCliente = '';
        $this->zonaCliente = '';
        $this->telemovelCliente = '';
        $this->emailCliente = '';
        $this->nifCliente = '';
        

        $this->nomeCliente = session('verOcorrenciaNomeCliente');
        $this->numeroCliente = session('verOcorrenciaNumeroCliente');
        $this->zonaCliente = session('verOcorrenciaZonaCliente');
        $this->telemovelCliente = session('verOcorrenciaTelemovelCliente');
        $this->emailCliente = session('verOcorrenciaEmailCliente');
        $this->nifCliente = session('verOcorrenciaNifCliente');
        if(session('verOcorrenciaStartDate')){
            $this->startDate = session('verOcorrenciaStartDate');
        }
        if(session('verOcorrenciaEndDate')){
            $this->endDate = session('verOcorrenciaEndDate');
        }
        if(session('verOcorrenciaStatusOcorrencia')){
            $this->statusOcorrencia = session('verOcorrenciaStatusOcorrencia');
        }


        $this->idCliente = '';
    }

    public function mount()
    {
        // dd('Aqui');
        $this->initProperties();
        // $ocorrenciaArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        // $this->ocorrencias = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasCliente($this->perPage,$this->idCliente);
        // $this->ocorrencias = $ocorrenciaArray["paginator"];
        // $this->numberMaxPages = $ocorrenciaArray["nr_paginas"];
        // $this->totalRecords = $ocorrenciaArray["nr_registos"];

        // $this->ocorrencias = session('verPropostaPaginator');
        // $this->numberMaxPages = session('verPropostaNr_paginas');
        // $this->totalRecords = session('verPropostaNr_registos');
        
        // $this->pageChosen = session('verPropostaPageChosen');



        if(session('verOcorrenciaPaginator')){
            $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
            // dd($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia, $ocorrenciaArray);
            Session::put('verOcorrenciaNomeCliente',$this->nomeCliente);
            Session::put('verOcorrenciaNumeroCliente',$this->numeroCliente);
            Session::put('verOcorrenciaZonaCliente',$this->zonaCliente);
            Session::put('verOcorrenciaTelemovelCliente',$this->telemovelCliente);
            Session::put('verOcorrenciaNifCliente',$this->nifCliente);

            Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
            Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
            Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);


            $this->ocorrencias = session('verOcorrenciaPaginator');
            $this->numberMaxPages = session('verOcorrenciaNr_paginas');
            $this->totalRecords = session('verOcorrenciaNr_registos');
        }else{
            $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
            // dd($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia, $ocorrenciaArray);
            Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
            Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
            Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);
            
            $this->ocorrencias = session('verOcorrenciaPaginator');
            $this->numberMaxPages = session('verOcorrenciaNr_paginas');
            $this->totalRecords = session('verOcorrenciaNr_registos');
        }
        
        
    }

    public function updatedNomeCliente()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);

        Session::put('verOcorrenciaNomeCliente',$this->nomeCliente);

        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);


        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');
    }

    public function updatedNumeroCliente()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
        Session::put('verOcorrenciaNumeroCliente',$this->numeroCliente);

        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);


        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');

    }

    public function updatedZonaCliente()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
        Session::put('verOcorrenciaZonaCliente',$this->zonaCliente);

        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);


        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');
    }

    public function updatedNifCliente()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);

        Session::put('verOcorrenciaNifCliente',$this->nifCliente);

        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);


        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');
    }

    public function updatedTelemovelCliente()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
    
        Session::put('verOcorrenciaTelemovelCliente',$this->telemovelCliente);

        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);


        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');
    }

    public function updatedEmailCliente()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);

        Session::put('verOcorrenciaEmailCliente',$this->emailCliente);

        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);


        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');
    }

    public function updatedEstadoProposta()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
        
        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);

        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');
    
    }

    public function adicionarOcorrencia()
    {
        Session::forget('ocorrencias');
        return redirect()->route('ocorrencias.nova');
    }

    public function updatedStartDate()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);

        Session::put('verOcorrenciaStartDate',$this->startDate);
        

        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);

        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');
    
    }
    public function updatedEndDate()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);


        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
        Session::put('verOcorrenciaEndDate',$this->endDate);
        

        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);

        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');
    
    }
    public function updatedStatusOcorrencia()
    {
        $this->pageChosen = 1;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);

        Session::put('verOcorrenciaStatusOcorrencia',$this->statusOcorrencia);
        

        Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
        Session::put('verOcorrenciaNr_paginas', $ocorrenciaArray["nr_paginas"] + 1);
        Session::put('verOcorrenciaNr_registos', $ocorrenciaArray["nr_registos"]);

        $this->ocorrencias = session('verOcorrenciaPaginator');
        $this->numberMaxPages = session('verOcorrenciaNr_paginas');
        $this->totalRecords = session('verOcorrenciaNr_registos');
    
    }

    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        Session::put('verOcorrenciaPageChosen', $this->pageChosen);
        
        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusOcorrencia != "0"){

        $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
            
            Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
            $this->ocorrencias = session('verOcorrenciaPaginator');

        } else {
            $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
            
            Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
            $this->ocorrencias = session('verOcorrenciaPaginator');

        }
        
    }

   
    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;
            Session::put('verOcorrenciaPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusOcorrencia != "0"){

                $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
                
                Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
                $this->ocorrencias = session('verOcorrenciaPaginator');
                
            } else {
                $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
                
                Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
                $this->ocorrencias = session('verOcorrenciaPaginator');
                
            }
        }
        else if($this->pageChosen == 1){
            Session::put('verEncomendaPageChosen', $this->pageChosen);
            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusOcorrencia != "0"){

                $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
                
                Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
                $this->ocorrencias = session('verOcorrenciaPaginator');
                
            } else {
                $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
                                
                Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
                $this->ocorrencias = session('verOcorrenciaPaginator');
                
            }
        }
    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;
            Session::put('verOcorrenciaPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusOcorrencia != "0"){

                $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
                                
                Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
                $this->ocorrencias = session('verOcorrenciaPaginator');
                
            } else {
                $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
                                
                Session::put('verOcorrenciaPaginator', $ocorrenciaArray["object"]);
                $this->ocorrencias = session('verOcorrenciaPaginator');
                
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

        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusOcorrencia != "0"){

            $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
          
            $this->ocorrencias = $ocorrenciaArray["object"];
            $this->numberMaxPages = $ocorrenciaArray["nr_paginas"] + 1;
            $this->totalRecords = $ocorrenciaArray["nr_registos"];

        } else {
            $ocorrenciaArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusOcorrencia);
           
            $this->ocorrencias = $ocorrenciaArray["object"];
            $this->numberMaxPages = $ocorrenciaArray["nr_paginas"] + 1;
            $this->totalRecords = $ocorrenciaArray["nr_registos"];

        }
        

    }

    public function checkOrder($idOcorrencia, $ocorrencia)
    {
        // dd( $ocorrencia);
            
        if ($ocorrencia == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Nao foi encontrado os detalhes dessa ocorrencia! (erro : EC-404)');

            return redirect()->route('ocorrencias');
        }
        $json = json_encode($ocorrencia);
        $object = json_decode($json, false);
        // dd($ocorrencia);


        Session::put('ocorrencia', $object);
        Session::put('rota','ocorrencias');
        return redirect()->route('ocorrencias.ocorrencia', ['idOcorrencia' => $idOcorrencia]);

    }


    public function paginationView()
    {
        return 'livewire.pagination';
    }

        
    public function render()
    {
        if ($this->ocorrencias == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Erro ao consultar as ocorrencias! (erro : PT-401)');

            return view('pageErro');
        }

        return view('livewire.ocorrencias.ocorrencias',["ocorrencias" => $this->ocorrencias]);
    }
}
