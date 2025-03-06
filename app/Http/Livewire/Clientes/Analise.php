<?php

namespace App\Http\Livewire\Clientes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;


class Analise extends Component
{
    use WithPagination;

    private ?object $clientesRepository = NULL;
    protected ?object $clientes = NULL;
    public string $idCliente = "";

    public int $perPage = 10;
    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;

    private ?object $detailsClientes = NULL;

    public $analysisClientes;
    public $analysisAnualClientes;

    public string $tabDetail = "show active";
    public string $tabAnalysis = "";
    public string $tabEncomendas = "";
    public string $tabPropostas = "";
    public string $tabFinanceiro = "";
    public string $tabOcorrencias = "";
    public string $tabVisitas = "";
    public string $tabAssistencias = "";
    public string $tabCampanhas = "";

    public $DateIniAnalise;
    public $DateEndAnalise;

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

    }

    public function mount($cliente)
    {
        $this->initProperties();
        $this->idCliente = $cliente;
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        $this->DateIniAnalise = Session::get('DateIniAnalise') ?? now()->startOfMonth()->format('Y-m-d');
        $this->DateEndAnalise = Session::get('DateEndAnalise') ?? now()->format('Y-m-d');

        $this->analysisClientes = $this->clientesRepository->getListagemAnaliseFamily($this->DateIniAnalise, $this->DateEndAnalise, $this->detailsClientes->customers[0]->no, 0);
        if(isset($this->analysisClientes['message']))
        {
            $this->analysisClientes = null;
        }
        $this->analysisAnualClientes = $this->clientesRepository->getListagemAnaliseAnual(0, $this->detailsClientes->customers[0]->no);
        if(isset($this->analysisAnualClientes['message']))
        {
            $this->analysisAnualClientes = null;
        }

        Session::put('rota','clientes.detail');
        Session::put('parametro',$this->idCliente);

        $rota = Session::get('rotaTab');

        if($rota == 'tabEncomendas')
        {
            $this->tabDetail = "";
            $this->tabAnalysis = "";
            $this->tabEncomendas = "show active";
            $this->tabPropostas = "";
            $this->tabFinanceiro = "";
            $this->tabOcorrencias = "";
            $this->tabVisitas = "";
            $this->tabAssistencias = "";
            $this->tabCampanhas = "";
            Session::forget('rotaTab');
        } 
        elseif($rota == 'tabPropostas')
        {
            $this->tabDetail = "";
            $this->tabAnalysis = "";
            $this->tabEncomendas = "";
            $this->tabPropostas = "show active";
            $this->tabFinanceiro = "";
            $this->tabOcorrencias = "";
            $this->tabVisitas = "";
            $this->tabAssistencias = "";
            $this->tabCampanhas = "";
            Session::forget('rotaTab');
        }
    }

    public function AlterDateIniAnalise($date)
    {

        $this->DateIniAnalise = $date;
        Session::put('DateIniAnalise', $this->DateIniAnalise);

        return redirect()->route('clientes.detail',["id" => $this->idCliente]);
    }

    public function AlterDateEndAnalise($date)
    {

        $this->DateEndAnalise = $date;
        Session::put('DateEndAnalise', $this->DateEndAnalise);

        return redirect()->route('clientes.detail',["id" => $this->idCliente]);
    }
    
    public function gotoPage($page)
    {
        // $this->pageChosen = $page;
        // $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        // $this->detailsClientes = $arrayCliente["object"];

        // $arrayAna = $this->clientesRepository->getListagemAnalisesCliente($this->perPage,$this->pageChosen,$this->idCliente);
        // $this->analysisClientes = $arrayAna["paginator"];


        // $this->tabDetail = "";
        // $this->tabAnalysis = "show active";
        // $this->tabEncomendas = "";
        // $this->tabPropostas = "";
        // $this->tabFinanceiro = "";
        // $this->tabOcorrencias = "";
        // $this->tabVisitas = "";
        // $this->tabAssistencias = "";
        // $this->tabCampanhas = "";
    }

   
    public function previousPage()
    {
        // $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        // $this->detailsClientes = $arrayCliente["object"];

        // if ($this->pageChosen > 1) {
        //     $this->pageChosen--;
        //     $arrayAna = $this->clientesRepository->getListagemAnalisesCliente($this->perPage,$this->pageChosen,$this->idCliente);
        //     $this->analysisClientes = $arrayAna["paginator"];
        // }
        // else if($this->pageChosen == 1){
        //     $arrayAna = $this->clientesRepository->getListagemAnalisesCliente($this->perPage,$this->pageChosen,$this->idCliente);
        //     $this->analysisClientes = $arrayAna["paginator"];
        // }

        // $this->tabDetail = "";
        // $this->tabAnalysis = "show active";
        // $this->tabEncomendas = "";
        // $this->tabPropostas = "";
        // $this->tabFinanceiro = "";
        // $this->tabOcorrencias = "";
        // $this->tabVisitas = "";
        // $this->tabAssistencias = "";
        // $this->tabCampanhas = "";
    }

    public function nextPage()
    {
        // $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        // $this->detailsClientes = $arrayCliente["object"];

        // if ($this->pageChosen < $this->numberMaxPages) {
        //     $this->pageChosen++;
        //     $arrayAna = $this->clientesRepository->getListagemAnalisesCliente($this->perPage,$this->pageChosen,$this->idCliente);
        //     $this->analysisClientes = $arrayAna["paginator"];
        // }

        // $this->tabDetail = "";
        // $this->tabAnalysis = "show active";
        // $this->tabEncomendas = "";
        // $this->tabPropostas = "";
        // $this->tabFinanceiro = "";
        // $this->tabOcorrencias = "";
        // $this->tabVisitas = "";
        // $this->tabAssistencias = "";
        // $this->tabCampanhas = "";
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
        // $this->resetPage();
        // session()->put('perPage', $this->perPage);

        // $this->tabDetail = "";
        // $this->tabAnalysis = "show active";
        // $this->tabEncomendas = "";
        // $this->tabPropostas = "";
        // $this->tabFinanceiro = "";
        // $this->tabOcorrencias = "";
        // $this->tabVisitas = "";
        // $this->tabAssistencias = "";
        // $this->tabCampanhas = "";

        // $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        // $this->detailsClientes = $arrayCliente["object"];

        // $arrayAna = $this->clientesRepository->getListagemAnalisesCliente($this->perPage,$this->pageChosen,$this->idCliente);
        // $this->analysisClientes = $arrayAna["paginator"];

        // $this->numberMaxPages = $arrayAna["nr_paginas"]  + 1;
        // $this->totalRecords = $arrayAna["nr_registos"];
    }

    public function voltarAtras()
    {
        // $this->dispatchBrowserEvent('changeRoute');
        // $this->skipRender();

        $rota = Session::get('rota');
        
        $parametro = Session::get('parametro');
        
        if($rota == "clientes.detail"){
            $rota = "clientes";
            $parametro = "" ;
        }

        if($rota != "")
        {
            
            if($parametro != "")
            {
                
                return redirect()->route($rota,$parametro);
            }
            return redirect()->route($rota);
        }
    }
    
    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function render()
    {
        return view('livewire.clientes.analises',["detalhesCliente" => $this->detailsClientes, "analisesCliente" =>$this->analysisClientes, "vendasAnuais" =>$this->analysisAnualClientes ]);
    }
}
