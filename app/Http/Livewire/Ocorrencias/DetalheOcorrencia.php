<?php

namespace App\Http\Livewire\Ocorrencias;

use App\Models\Visitas;
use Livewire\Component;
use App\Models\Carrinho;
use App\Models\Anexos;
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
use App\Mail\SendOcorrencia;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;



class DetalheOcorrencia extends Component
{
    use WithPagination,WithFileUploads;

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

    //FORM
    public ?string $assunto = "";
    public string $relatorio = "";
    public ?string $selectedInvoicesJson = "";
    public ?string $tipoOcorrenciaSelect2 = "";
    public int $tipoOcorrenciaSelect1;

    public $emailArray;
    public $emailSend;
    

    public int $checkStatus;

    public ?string $clientID = "";
    public $anexos = [];
    public $tempPaths = [];

    public $invoices;
    public $selectedLines = [];
    public $selectedLinesIds = [];


    

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
        $this->initProperties();
        $cliente =  $this->clientesRepository->getDetalhesCliente($idcliente);

        $this->Cliente = $cliente['object']->customers[0];

        session()->put('Cliente', $this->Cliente);

        $this->invoices = $this->clientesRepository->getInvoiceCliente(1000, 1, $this->Cliente->no);
        $this->invoices = $this->invoices['object'];

        session()->put('invoices', $this->invoices);
        session()->put('OcorrenciasAnexos', null);
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
        
        if($rota == "ocorrencias.info"){
            $rota = "ocorrencias";
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
        return redirect()->route('ocorrencias');
    }
    
    public function salvarOcorrencia()
    {
        $updatedPaths = [];
        if(session('OcorrenciasAnexos')){
            $this->anexos = session('OcorrenciasAnexos');
        }
        foreach ($this->anexos as $file) {
            if(isset($file['path'])){
                $path = $file['path'];

                $newPath = str_replace('temp/', 'anexos/', $path);
        
                if (\Storage::disk('public')->exists($path)) {
                    \Storage::disk('public')->move($path, $newPath);
        
                    $updatedPaths[] = [
                        'path' => $newPath,
                        'original_name' => $file['original_name'],
                    ];
                }
            }else{
                $newPath = str_replace('temp/', 'anexos/', $file);
                $filename = ltrim($file, 'temp/');

                $updatedPaths[] = [
                    'path' => $newPath,
                    'original_name' => $filename,
                ];
            }
        }

        Session::put('OcorrenciasAnexos', $updatedPaths);

        $this->anexos = session('OcorrenciasAnexos');
        
        $originalNames = [];
        foreach ($this->anexos as $anexo) {
            $originalNames[] = $anexo["path"];
        }

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

        if($response_decoded->success != true)
        {
            $this->dispatchBrowserEvent('checkToaster', ["message" => "A Ocorrência não foi finalizada", "status" => "error"]);

            return redirect()->route('ocorrencias.detail', ['id' => session('Cliente')->id]);
        }else
        {

            $anexoCreate = Anexos::create([
                "idOcorrencia" => $response_decoded->id_document,
                "anexo" => json_encode($originalNames),
                "id_user" => Auth::user()->id
            ]);

            $grupos = GrupoEmail::where('local_funcionamento', 'nova_ocorrencia')->get();
            if(isset($grupos)){
                $this->emailArray = [];
                foreach ($grupos as $grupo) {
                    $emails = array_map('trim', explode(',', $grupo->emails));
                    
                    $this->emailArray = array_merge($this->emailArray, $emails);
                }
    
                $this->emailArray[] = Auth::user()->email;
    
                $this->emailArray = array_unique($this->emailArray);
    
            Mail::to(Auth::user()->email)
            ->bcc($this->emailArray)
            ->send(new SendOcorrencia($response_decoded->id_document));
            }

            $this->dispatchBrowserEvent('checkToaster', ["message" => "Ocorrência finalizada com sucesso", "status" => "success"]);

            session()->put('ocorrencia', null);

            return redirect()->route('ocorrencias.ocorrencia', ['idOcorrencia' => $response_decoded->id_document]);
        }
        
    }
    
    public function removeAnexo($filePath)
    {
        $currentAnexos = Session::get('OcorrenciasAnexos', []);
        
        Session::put('trueAdd', 1 );

        $currentAnexos = array_filter($currentAnexos, function($file) use ($filePath) {
            return $file !== $filePath;
        });
        Session::put('OcorrenciasAnexos', $currentAnexos);
    
        if (\Storage::disk('public')->exists($filePath)) {
            \Storage::disk('public')->delete($filePath);
        }
        $this->anexos=  $currentAnexos;
        $this->tempPaths = $currentAnexos;
   
        Session::put('OcorrenciasAnexos', $currentAnexos);

        $updatedPaths = [];
        foreach ($this->anexos as $file) {

            if(isset($file['path'])){
            
                $path = $file['path'];

                $newPath = str_replace('temp/', 'anexos/', $path);
        
                if (\Storage::disk('public')->exists($path)) {
                    \Storage::disk('public')->move($path, $newPath);
        
                    $updatedPaths[] = [
                        'path' => $newPath,
                        'original_name' => $file['original_name'],
                    ];
                }
            }else{
                $newPath = str_replace('temp/', 'anexos/', $file);

                $filename = ltrim($file, 'temp/');

                $updatedPaths[] = [
                    'path' => $newPath,
                    'original_name' => $filename,
                ];
            }
        }
        Session::put('OcorrenciasAnexos', $updatedPaths);

        $this->anexos = session('OcorrenciasAnexos');
        
        $originalNames = [];
        foreach ($this->anexos as $anexo) {
            $originalNames[] = $anexo["path"];
        }
        Visitas::where('id',session('idVisita'))->update([
            "anexos" => json_encode($originalNames),
        ]);
    }
    

    public function updatedAnexos() 
    {
        $currentAnexos = Session::get('OcorrenciasAnexos', []);
        
        $maxFileSize = 10 * 1024 * 1024; 
        foreach ($this->anexos as $anexo) {
            if ($anexo->getSize() > $maxFileSize) {
                $this->dispatchBrowserEvent('sendToaster', ["message" => "O arquivo deve ter no máximo 10 MB.", "status" => "error"]);
                return false;
            }
    
            $originalName = $anexo->getClientOriginalName();
            
            $path = $anexo->storeAs('temp', time() . '&' . $originalName, 'public');
            
            $currentAnexos[] = [
                'path' => $path,
                'original_name' => $originalName,
            ];
        }
        
        Session::put('OcorrenciasAnexos', $currentAnexos);
        $this->tempPaths = $currentAnexos;
    }

    public function render()
    {
        if(!isset($this->Cliente))
        {
            $this->Cliente = session('Cliente');
        }
        if(!isset($this->invoices))
        {
            $this->invoices = session('invoices');
        }
        return view('livewire.ocorrencias.detalhe-ocorrencia',["detalhesCliente" => $this->Cliente, "invoices" => $this->invoices]);
    }
}
