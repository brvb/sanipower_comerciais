<?php

namespace App\Http\Livewire\Financeiro;

use Livewire\Component;
use App\Models\Comentarios;
use Livewire\WithPagination;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Route;
use App\Interfaces\PropostasInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class Financeiro extends Component
{
    use WithPagination;
    
    public int $perPage = 10;
    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;
    private ?object $clientesRepository = NULL;

    protected ?object $clientes = NULL;
    protected $Financeiros = NULL;

    public ?string $nomeCliente = '';
    public ?string $numeroCliente = '';
    public ?string $zonaCliente = '';
    public ?string $telemovelCliente = '';
    public ?string $emailCliente = '';
    public ?string $nifCliente = '';
    public $startDate = '';
    public $endDate = '';
    public int $statusFinanceiro = 0;

    public $idCliente;
    

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
        

        $this->nomeCliente = session('verFinanceiroNomeCliente');
        $this->numeroCliente = session('verFinanceiroNumeroCliente');
        $this->zonaCliente = session('verFinanceiroZonaCliente');
        $this->telemovelCliente = session('verFinanceiroTelemovelCliente');
        $this->emailCliente = session('verFinanceiroEmailCliente');
        $this->nifCliente = session('verFinanceiroNifCliente');
        if(session('verFinanceiroStartDate')){
            $this->startDate = session('verFinanceiroStartDate');
        }
        if(session('verFinanceiroEndDate')){
            $this->endDate = session('verFinanceiroEndDate');
        }
        if(session('verFinanceiroStatusFinanceiro')){
            $this->statusFinanceiro = session('verFinanceiroStatusFinanceiro');
        }


        $this->idCliente = '';
    }

    public function mount()
    {
        $this->initProperties();

        if(session('verFinanceiroPaginator')){
            // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
            $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);
            // dd($FinanceiroArray);
            Session::put('verFinanceiroNomeCliente',$this->nomeCliente);
            Session::put('verFinanceiroNumeroCliente',$this->numeroCliente);
            Session::put('verFinanceiroZonaCliente',$this->zonaCliente);
            Session::put('verFinanceiroTelemovelCliente',$this->telemovelCliente);
            Session::put('verFinanceiroNifCliente',$this->nifCliente);

            Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
            Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
            Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);


            $this->Financeiros = session('verFinanceiroPaginator');
            $this->numberMaxPages = session('verFinanceiroNr_paginas');
            $this->totalRecords = session('verFinanceiroNr_registos');
        }else{
            // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
            $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);
            Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
            Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
            Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);
            
            $this->Financeiros = session('verFinanceiroPaginator');
            $this->numberMaxPages = session('verFinanceiroNr_paginas');
            $this->totalRecords = session('verFinanceiroNr_registos');
        }
        
        
    }

    public function updatedNomeCliente()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);

        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);

        Session::put('verFinanceiroNomeCliente',$this->nomeCliente);

        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);


        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');
    }

    public function updatedNumeroCliente()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);

        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
        Session::put('verFinanceiroNumeroCliente',$this->numeroCliente);

        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);


        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');

    }

    public function updatedZonaCliente()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);

        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
        Session::put('verFinanceiroZonaCliente',$this->zonaCliente);

        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);


        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');
    }

    public function updatedNifCliente()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);

        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);

        Session::put('verFinanceiroNifCliente',$this->nifCliente);

        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);


        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');
    }

    public function updatedTelemovelCliente()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);

        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
    
        Session::put('verFinanceiroTelemovelCliente',$this->telemovelCliente);

        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);


        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');
    }

    public function updatedEmailCliente()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);

        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);

        Session::put('verFinanceiroEmailCliente',$this->emailCliente);

        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);


        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');
    }

    public function updatedEstadoProposta()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);

        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
        
        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);

        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');
    
    }

    public function adicionarFinanceiro()
    {
        Session::forget('Financeiros');
        return redirect()->route('Financeiros.nova');
    }

    public function updatedStartDate()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);

        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);

        Session::put('verFinanceiroStartDate',$this->startDate);
        

        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);

        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');
    
    }
    public function updatedEndDate()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);


        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
        Session::put('verFinanceiroEndDate',$this->endDate);
        

        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);

        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');
    
    }
    public function updatedStatusFinanceiro()
    {
        $this->pageChosen = 1;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);

        $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);

        Session::put('verFinanceiroStatusFinanceiro',$this->statusFinanceiro);
        

        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
        Session::put('verFinanceiroNr_paginas', $FinanceiroArray["nr_paginas"] + 1);
        Session::put('verFinanceiroNr_registos', $FinanceiroArray["nr_registos"]);

        $this->Financeiros = session('verFinanceiroPaginator');
        $this->numberMaxPages = session('verFinanceiroNr_paginas');
        $this->totalRecords = session('verFinanceiroNr_registos');
    
    }

    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        Session::put('verFinanceiroPageChosen', $this->pageChosen);
        
        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusFinanceiro != "0"){

        // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
        $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);
            
            Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
            $this->Financeiros = session('verFinanceiroPaginator');

        } else {
            // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
            $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);

            Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
            $this->Financeiros = session('verFinanceiroPaginator');

        }
        
    }

   
    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;
            Session::put('verFinanceiroPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusFinanceiro != "0"){

                // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
                $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);

                Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
                $this->Financeiros = session('verFinanceiroPaginator');
                
            } else {
                // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
                $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);

                Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
                $this->Financeiros = session('verFinanceiroPaginator');
                
            }
        }
        else if($this->pageChosen == 1){
            Session::put('verEncomendaPageChosen', $this->pageChosen);
            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusFinanceiro != "0"){

                // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
                $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);

                Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
                $this->Financeiros = session('verFinanceiroPaginator');
                
            } else {
                // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
                $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);

                Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
                $this->Financeiros = session('verFinanceiroPaginator');
                
            }
        }
    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;
            Session::put('verFinanceiroPageChosen', $this->pageChosen);

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusFinanceiro != "0"){

                // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
                $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);

                Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
                $this->Financeiros = session('verFinanceiroPaginator');
                
            } else {
                // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
                $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);

                Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);
                $this->Financeiros = session('verFinanceiroPaginator');
                
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

        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != "" || $this->statusFinanceiro != "0"){

            // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
            $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);

            $this->Financeiros = $FinanceiroArray["object"];
            $this->numberMaxPages = $FinanceiroArray["nr_paginas"] + 1;
            $this->totalRecords = $FinanceiroArray["nr_registos"];

        } else {
            // $FinanceiroArray = $this->clientesRepository->getOcorrenciasCliente($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->startDate,$this->endDate,$this->statusFinanceiro);
           
            $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, 0);
            $this->Financeiros = $FinanceiroArray["object"];
            $this->numberMaxPages = $FinanceiroArray["nr_paginas"] + 1;
            $this->totalRecords = $FinanceiroArray["nr_registos"];

        }
        

    }

    public function checkOrder($idFinanceiro, $Financeiro)
    {
            
        if ($Financeiro == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Nao foi encontrado os detalhes dessa Fatura! (erro : EC-404)');

            return redirect()->route('Financeiros');
        }
        $json = json_encode($Financeiro);
        $object = json_decode($json, false);


        Session::put('Financeiro', $object);
        Session::put('rota','financeiro');
        return redirect()->route('financeiros.financeiro', ['idFinanceiro' => $idFinanceiro]);

    }


    public function paginationView()
    {
        return 'livewire.pagination';
    }

        
    public function render()
    {
        if ($this->Financeiros == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Erro ao consultar as Financeiros! (erro : PT-401)');

            return view('pageErro');
        }

        return view('livewire.Financeiro.Financeiro',["financeiro" => $this->Financeiros]);
    }
}
