<?php

namespace App\Http\Livewire\Visitas;

use Dompdf\Dompdf;

use Livewire\Component;
use App\Models\Carrinho;
use App\Mail\SendProposta;
use App\Models\Comentarios;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Visitas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\VisitasInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class Financeiro extends Component
{
    use WithPagination,WithFileUploads;
    private ?object $visitasRepository = NULL;
    protected ?object $clientes = NULL;
    public string $idCliente = "";

    private ?object $propostasDetail = NULL;
    public ?string $propostaID = "";
    public ?string $propostaName = "";

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

    public string $assunto = "";
    public string $relatorio = "";
    public string $pendentes = "";
    public string $comentario_encomendas = "";
    public string $comentario_propostas = "";
    public string $comentario_financeiro = "";
    public string $comentario_occorencias = "";
    public int $tipoVisitaSelect;

    public ?string $comentarioProposta = "";

    private ?object $detailsfinanceiro = NULL;
    public ?object $comentario = NULL;

    public $estadoProposta = "";


    public $anexos = [];
    public $tempPaths = [];
    protected $listeners = ['atualizarFinanceiro' => 'render'];

    public function boot( VisitasInterface $visitasRepository)
    {
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

    public function mount($idCliente)
    {
        // Session::forget('visitasPropostasAnexos');
        $this->initProperties();
        $this->idCliente = $idCliente;
        
        if(session('visitasPropostasComentario_financeiro')){
            $this->comentario_financeiro = session('visitasPropostasComentario_financeiro');
        }
        if(session('visitasPropostasCheckStatus')){
            $this->checkStatus = session('visitasPropostasCheckStatus');
        }

        $this->restartDetails();
    }


    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        $financeiroArray = $this->visitasRepository->getFinanceiroCliente($this->perPage,$this->pageChosen,$this->idCliente);

        $this->detailsfinanceiro = $financeiroArray["object"];
    }


    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;
            $financeiroArray = $this->visitasRepository->getFinanceiroCliente($this->perPage,$this->pageChosen,$this->idCliente);
            $this->detailsfinanceiro = $financeiroArray["object"];
        }
        else if($this->pageChosen == 1){
            $financeiroArray = $this->visitasRepository->getFinanceiroCliente($this->perPage,$this->pageChosen,$this->idCliente);

            $this->detailsfinanceiro = $financeiroArray["object"];
        }

    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;

            $financeiroArray = $this->visitasRepository->getFinanceiroCliente($this->perPage,$this->pageChosen,$this->idCliente);

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
        $financeiroArray = $this->visitasRepository->getFinanceiroCliente($this->perPage,$this->pageChosen,$this->idCliente);

        $this->numberMaxPages = $financeiroArray["nr_paginas"] + 1;
        $this->totalRecords = $financeiroArray["nr_registos"];
        $this->detailsfinanceiro = $financeiroArray["object"];
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
    public function updatedComentarioFinanceiro()
    {
        Session::put('visitasPropostasComentario_financeiro', $this->comentario_financeiro );
    }
    public function removeAnexo($filePath)
    {
        $currentAnexos = Session::get('visitasPropostasAnexos', []);
        
        Session::put('trueAdd', 1 );

        // dd($currentAnexos ,$filePath);
        $currentAnexos = array_filter($currentAnexos, function($file) use ($filePath) {
            return $file !== $filePath;
        });
        Session::put('visitasPropostasAnexos', $currentAnexos);
    
        if (\Storage::disk('public')->exists($filePath)) {
            \Storage::disk('public')->delete($filePath);
        }
        $this->anexos=  $currentAnexos;
        $this->tempPaths = $currentAnexos;
   
        Session::put('visitasPropostasAnexos', $currentAnexos);

        $updatedPaths = [];
        foreach ($this->anexos as $file) {

            if(isset($file['path'])){
            
                $path = $file['path'];

                $newPath = str_replace('temp/', 'anexos/', $path);
        
                // Verifica se o arquivo existe no local temporário antes de movê-lo
                if (\Storage::disk('public')->exists($path)) {
                    \Storage::disk('public')->move($path, $newPath);
        
                    // Atualizar os caminhos com o novo local
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
        Session::put('visitasPropostasAnexos', $updatedPaths);

        $this->anexos = session('visitasPropostasAnexos');
        
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
        $currentAnexos = Session::get('visitasPropostasAnexos', []);
        
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
        
        Session::put('visitasPropostasAnexos', $currentAnexos);
        
        $this->tempPaths = $currentAnexos;
    }
    

    public function render()
    {
        $financeiroArray = $this->visitasRepository->getFinanceiroCliente($this->perPage,$this->pageChosen,$this->idCliente);
        $this->detailsfinanceiro = $financeiroArray["object"];

        if(session('visitasPropostasComentario_financeiro')){
            $this->comentario_financeiro = session('visitasPropostasComentario_financeiro');
        }
        if(session('visitasPropostasAnexos')){
            $this->anexos = session('visitasPropostasAnexos');
        }

        return view('livewire.visitas.financeiro', ["detailsfinanceiro" => $this->detailsfinanceiro]);
    }
}
