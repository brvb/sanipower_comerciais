<?php

namespace App\Http\Livewire\Clientes;

use Dompdf\Dompdf;
use Livewire\Component;
use App\Models\Carrinho;
use App\Mail\SendProposta;
use App\Models\Comentarios;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Interfaces\VisitasInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class Financeiro extends Component
{
    use WithPagination;

    private ?object $visitasRepository = NULL;
    private ?object $clientesRepository = NULL;
    protected ?object $clientes = NULL;
    public string $idCliente = "";
    public string $idVisita = "";

    private ?object $propostasDetail = NULL;
    public ?string $propostaID = "";
    public ?string $propostaName = "";

    public $perPagePendente;
    public $pageChosenPendente;

    private ?object $detailsClientes = NULL;

    public $FinanceirosPendente;

    public int $perPage = 10;
    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;

    
    public ?string $nomeCliente = '';
    public ?string $numeroCliente = '';
    public ?string $zonaCliente = '';
    public ?string $telemovelCliente = '';
    public ?string $emailCliente = '';
    public ?string $nifCliente = '';

    public ?string $comentarioProposta = "";

    private ?object $detailsfinanceiro = NULL;
    public ?object $comentario = NULL;

    public $estadoProposta = "";


    public function boot(VisitasInterface $visitasRepository, ClientesInterface $clientesRepository)
    {
        $this->visitasRepository = $visitasRepository;
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

        if (isset($this->perPagePendente)) {
            session()->put('perPagePendente', $this->perPagePendente);
        } elseif (session('perPagePendente')) {
            $this->perPagePendente = session('perPagePendente');
        } else {
            $this->perPagePendente = 10;
        }
    }

    public function mount($idCliente)
    {
        $this->initProperties();
        $this->idCliente = $idCliente;

        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        $noclient = $this->detailsClientes->customers[0]->no;

        Session::put('noclient', $noclient);

        $FinanceiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, $noclient);
        $this->detailsfinanceiro = $FinanceiroArray["object"];
        Session::put('verFinanceiroPaginator', $FinanceiroArray["object"]);

        $this->perPagePendente = Session::get('perPagePendente') ?? 10;
        $this->pageChosenPendente = Session::get('pageChosenPendente') ?? 1;
        $this->FinanceirosPendente = $this->clientesRepository->getFinanceiroCliente($this->perPagePendente,$this->pageChosenPendente, $idCliente);
        Session::put('FinanceirosPendente', $this->FinanceirosPendente);

        $this->restartDetails();
    }


    public function loadPendentes()
    {
        // $this->perPagePendente = Session::get('perPagePendente') ?? 10;
        // $this->pageChosenPendente = Session::get('pageChosenPendente') ?? 1;
        // $this->FinanceirosPendente = $this->clientesRepository->getFinanceiroCliente($this->perPagePendente,$this->pageChosenPendente, '');
        return redirect()->route('clientes.detail',["id" => $this->idCliente]);
    }

    public function updatedPerPagePendente()
    {
        $this->pageChosenPendente = 1;
        Session::put('perPagePendente', $this->perPagePendente);
        $this->loadPendentes();
    }
   
    public function PerPagePendente($page)
    {
        $this->perPagePendente = $page;
        Session::put('perPagePendente', $this->perPagePendente);
        $this->loadPendentes();
    }

    public function previousPagePendente()
    {
        if ($this->pageChosenPendente > 1) {
            $this->pageChosenPendente--;
            Session::put('pageChosenPendente', $this->pageChosenPendente);
            $this->loadPendentes();
        }
    }

    public function nextPagePendente()
    {
        if ($this->pageChosenPendente < $this->FinanceirosPendente['nr_paginas']) {
            $this->pageChosenPendente++;
            Session::put('pageChosenPendente', $this->pageChosenPendente);
            $this->loadPendentes();
        }
    }

    public function goToPagePendente($page)
    {
        if ($page >= 1 && $page <= $this->FinanceirosPendente['nr_paginas']) {
            $this->pageChosenPendente = $page;
            Session::put('pageChosenPendente', $this->pageChosenPendente);
            $this->loadPendentes();
        }
    }

    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        $financeiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, session('noclient'));
        $this->detailsfinanceiro = $financeiroArray["object"];
    }


    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;
            $financeiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, session('noclient'));
            $this->detailsfinanceiro = $financeiroArray["object"];
        }
        else if($this->pageChosen == 1){
            $financeiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, session('noclient'));

            $this->detailsfinanceiro = $financeiroArray["object"];
        }

    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;

            $financeiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, session('noclient'));

            $this->detailsfinanceiro = $financeiroArray["object"];
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
    public function restartDetails()
    {
        $financeiroArray = $this->clientesRepository->getInvoiceCliente($this->perPage,$this->pageChosen, session('noclient'));


        $this->numberMaxPages = $financeiroArray["nr_paginas"] + 1;
        $this->totalRecords = $financeiroArray["nr_registos"];
        $this->detailsfinanceiro = $financeiroArray["object"];
    }

    public function GerarPdfFinanceiro()
    {
        // Obtendo os dados financeiros
        $FinanceiroArray = $this->clientesRepository->getFinanceiroCliente(9999, 1, $this->idCliente);
        // dd($FinanceiroArray);
        // Extraindo os itens do paginator e agrupando por 'customer_name'
        $financeiro = collect($FinanceiroArray["object"])->groupBy('customer_name');


        // dd($financeiro);
        // Gerando o PDF com a Blade
        $pdf = PDF::loadView('pdf.pdfMapaDividas', ["financeiroAgrupado" => $financeiro]);
        
        redirect()->route('clientes.detail',["id" => $this->idCliente]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'pdfMapaDividas.pdf');
    }

    public function checkOrder($idFinanceiro, $Financeiro)
    {
            
        if ($Financeiro == null) {
            session()->flash('status', 'error');
            session()->flash('message', 'Nao foi encontrado os detalhes dessa Fatura! (erro : EC-404)');

            return redirect()->route('financeiro');
        }
        $json = json_encode($Financeiro);
        $object = json_decode($json, false);


        Session::put('Financeiro', $object);
        Session::put('rota','financeiro');
        return redirect()->route('financeiros.financeiro', ['idFinanceiro' => $idFinanceiro]);

    }

    public function updatedperPage(): void
    {
        $this->resetPage();
        session()->put('perPage', $this->perPage);


        $this->restartDetails();

    }
    public function paginationView()
    {
        return 'livewire.pagination';
    }
    public function render()
    {
        Session::put('FinanceirosPendente', $this->FinanceirosPendente['object']);

        return view('livewire.clientes.financeiro', ["detailsfinanceiro" => $this->detailsfinanceiro, "financeiroPendente" => $this->FinanceirosPendente]);
    }
}
