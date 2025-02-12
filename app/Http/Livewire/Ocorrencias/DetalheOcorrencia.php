<?php

namespace App\Http\Livewire\Ocorrencias;

use App\Models\Visitas;
use Livewire\Component;
use App\Models\Carrinho;
use Livewire\WithPagination;
use App\Models\VisitasAgendadas;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use App\Interfaces\VisitasInterface;
use App\Models\TiposVisitas;
use Illuminate\Support\Facades\Session;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Models\GrupoEmail;
use App\Mail\SendRelatorio;
use Illuminate\Http\Request;


class DetalheOcorrencia extends Component
{
    use WithPagination;

    private ?object $clientesRepository = NULL;
    private ?object $visitasRepository = NULL;
    protected ?object $clientes = NULL;
    public string $idCliente = "";
    protected object $Cliente;

    public int $perPage = 10;
    public int $perPageRelatorio = 10;
    public $trueAdd = 0;

    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;

    private ?object $detailsClientes = NULL;
    private ?object $analysisClientes = NULL;

    public string $tabDetail = "show active";
    public string $tabAnalysis = "";
    public string $tabEncomendas = "";
    public string $tabPropostas = "";
    public string $tabFinanceiro = "";
    public string $tabOcorrencia = "";
    public string $tabVisitas = "";
    public ?string $tabAssistencias = "";

    //FORM
    public ?string $assunto = "";
    public string $relatorio = "";
    public string $pendentes = "";
    public string $comentario_encomendas = "";
    public string $comentario_propostas = "";
    public string $comentario_financeiro = "";
    public string $comentario_occorencias = "";

    public $emailArray;
    public $emailSend;
    

    public int $checkStatus;

    private ?object $encomendasDetail = NULL;

    public ?string $activeFinalizado = "";

    public $tiposVisitaCollection;
    public int $tipoVisitaSelect;

    public ?int $idVisita;
    public ?string $clientID = "";
    public $anexos = [];
    public $tempPaths = [];
    protected $listeners = ['eventoChamarSaveVisita' => 'saveVisita'];

    public $invoices;
    public $selectedLines = [];
    public $selectedLinesIds = [];
    public ?string $selectedInvoicesJson = "";
    public ?string $tipoOcorrenciaSelect2 = "";
    public int $tipoOcorrenciaSelect1;



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

    }

    public function mount($idcliente)
    {
        // dd($idcliente);
        $this->initProperties();
        $cliente =  $this->clientesRepository->getDetalhesCliente($idcliente);
        // dd($cliente['object']->customers);

        $this->Cliente = $cliente['object']->customers[0];

        session()->put('Cliente', $this->Cliente);

        $this->invoices = $this->clientesRepository->getInvoiceCliente(1000, 1, $this->Cliente->no);
        $this->invoices = $this->invoices['object'];
    
        // Session::put('visitasPropostasAssunto', $this->assunto );
        // Session::put('visitasPropostasRelatorio', $this->relatorio );
        // Session::put('visitasPropostasPendentes', $this->pendentes );
        // Session::put('visitasPropostastipoVisitaSelect', $this->tipoVisitaSelect);
        // Session::put('visitasPropostasAnexos', $this->anexos);

        // $this->restartDetails();

    }


    public function restartDetails()
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
       
        $this->numberMaxPages = $arrayCliente["nr_paginas"] + 1;
        $this->totalRecords = $arrayCliente["nr_registos"];
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function voltarAtras()
    {

        $rota = Session::get('rota');

        $parametro = Session::get('parametro');
        
        if($rota == "visitas.info"){
            $rota = "visitas";
            $parametro = "";
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
    
    public function salvarOcorrencia()
    {
        // dd($this->selectedInvoicesJson, $this->assunto, $this->relatorio, $this->tipoOcorrenciaSelect1, $this->tipoOcorrenciaSelect2);
        if(!isset($this->selectedInvoicesJson) || !isset($this->tipoOcorrenciaSelect2) || !isset($this->tipoOcorrenciaSelect1) || !isset($this->relatorio))
        {
            return redirect()->route('ocorrencias.detail', ['id' => session('Cliente')->id]);
        }
        $client = session('Cliente');
        $selectedInvoicesJson = json_decode($this->selectedInvoicesJson);

        $invoice = $selectedInvoicesJson->invoice;

        $lines = $selectedInvoicesJson->lines;
        $count = 0 ;
        foreach($lines as $line)
        {
            $arrayLines[$count] = [
                "id" => $line->id,
                "reference" => $line->reference,
                "description" => $line->description,
                "quantity" => $line->quantity,
                "unit" => $line->unit,
                "unit_price" => $line->unit_price,
                "discount1" => $line->discount1,
                "discount2" => $line->discount2,
                "total" => $line->total
            ];
            $count++;
        }
        $array = [
            "customer_number" => $client->no,
            "customer_name" => $client->name,
            "address" => $client->address,
            "city" => $client->city,
            "zipcode" => $client->zipcode,
            "description" => $this->relatorio,
            "invoice_id" => $invoice->id,
            "invoice_number" => $invoice->document_number,
            "type_1"=> $this->tipoOcorrenciaSelect1,
            "type_2"=> $this->tipoOcorrenciaSelect2,
            "lines" => array_values($arrayLines)
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/occurrence',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($array),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/documents/occurrence', $array,$response_decoded);
        if($response_decoded->success != true)
        {
            $this->dispatchBrowserEvent('checkToaster', ["message" => "A Ocorrência não foi finalizada", "status" => "error"]);

            return redirect()->route('ocorrencias.detail', ['id' => session('Cliente')->id]);
        }else
        {
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Ocorrência finalizada com sucesso", "status" => "success"]);

            return redirect()->route('ocorrencias.ocorrencia', ['idOcorrencia' => $response_decoded->id_document]);
        }
        
    }
    

    public function render()
    {
        // dd($this->Cliente);
        return view('livewire.ocorrencias.detalhe-ocorrencia',["detalhesCliente" => $this->Cliente, "invoices" => $this->invoices]);
    }
}
