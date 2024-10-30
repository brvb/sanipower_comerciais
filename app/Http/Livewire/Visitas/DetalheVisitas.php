<?php

namespace App\Http\Livewire\Visitas;

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

class DetalheVisitas extends Component
{
    use WithPagination;

    private ?object $clientesRepository = NULL;
    private ?object $visitasRepository = NULL;
    protected ?object $clientes = NULL;
    public string $idCliente = "";

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

    public function mount($cliente, $idVisita = null, $tst)
    {
        $this->initProperties();
        $this->idCliente = $cliente;

        if($idVisita != 0){
            $this->idVisita = $idVisita;
            
            $visita = Visitas::where('id_visita_agendada',$idVisita)->first();
            $visitaAgendada = VisitasAgendadas::where('id', $idVisita)->first();
            // dd($idVisita, $visita, $visitaAgendada);
            Session::put('idVisita', $visita->id);
            Session::put('rota','visitas.info');
            Session::put('parametro',$visita->id);
            if(isset($visita->assunto))
            {
                if($visita->assunto == "")
                {
                    $this->assunto = $visitaAgendada->assunto_text;
                } else {
                    $this->assunto = $visita->assunto;
                }
               
            } else {
                $this->assunto = $visitaAgendada->assunto_text;
            }

            if(isset($visita->relatorio))
            {
                $this->relatorio = $visita->relatorio;
            }

            if(isset($visita->pendentes_proxima_visita))
            {
                $this->pendentes = $visita->pendentes_proxima_visita;
            }

            if(isset($visita->comentario_encomendas))
            {
                $this->comentario_encomendas = $visita->comentario_encomendas;
            }

            if(isset($visita->comentario_propostas))
            {
                $this->comentario_propostas = $visita->comentario_propostas;
            }
         
            if(isset($visita->comentario_financeiro))
            {
                $this->comentario_financeiro = $visita->comentario_financeiro;
            }
          
            if(isset($visita->comentario_ocorrencias))
            {
                $this->comentario_occorencias = $visita->comentario_ocorrencias;
            }

            if(isset($visitaAgendada->finalizado))
            {
                $this->checkStatus = $visitaAgendada->finalizado;
            }

            if(isset($visitaAgendada->id_tipo_visita))
            {
                $this->tipoVisitaSelect = $visitaAgendada->id_tipo_visita;
            }
                if(isset($visita->anexos))
                {
                    $this->anexos = $visita->anexos;
                    $this->anexos = json_decode($this->anexos);
                }
          
        
    
        } else {
            $this->checkStatus = 0;
            $this->tipoVisitaSelect = 1;
            $this->idVisita = 0;
        }

        $this->activeFinalizado = $tst;
    
        Session::put('visitasPropostasAssunto', $this->assunto );
        Session::put('visitasPropostasRelatorio', $this->relatorio );
        Session::put('visitasPropostasPendentes', $this->pendentes );
        Session::put('visitasPropostasComentario_encomendas', $this->comentario_encomendas );
        Session::put('visitasPropostasComentario_propostas', $this->comentario_propostas );
        Session::put('visitasPropostasComentario_financeiro', $this->comentario_financeiro );
        Session::put('visitasPropostasComentario_occorencias', $this->comentario_occorencias );
        Session::put('visitasPropostastipoVisitaSelect', $this->tipoVisitaSelect);
        Session::put('visitasPropostasAnexos', $this->anexos);

        $this->restartDetails();

    }

    public function gerarPdfVisita($visita)
    {
        // dd($visita);

        if (!$visita) {
            return redirect()->back()->with('error', 'Visita não encontrada.');
        }

        $pdf = PDF::loadView('pdf.pdfRelatorioVisita', ["visita" => json_encode($visita)]);
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'pdfRelatorioVisita.pdf');
    }

    public function addSessionDetalhesRelatorio($pagerange){


        if(session('visitasPropostasComentario_encomendas')){
            $this->comentario_encomendas = session('visitasPropostasComentario_encomendas');
        }
        if( session('visitasPropostasComentario_propostas')){
            $this->comentario_propostas = session('visitasPropostasComentario_propostas');
        }
        if(session('visitasPropostasComentario_financeiro')){
            $this->comentario_financeiro = session('visitasPropostasComentario_financeiro');
        }
        if(session('visitasPropostasComentario_occorencias')){
            $this->comentario_occorencias = session('visitasPropostasComentario_occorencias');
        }

        Session::put('visitasPropostasAssunto', $this->assunto );
        Session::put('visitasPropostasRelatorio', $this->relatorio );
        Session::put('visitasPropostasPendentes', $this->pendentes );
        Session::put('visitasPropostasComentario_encomendas', $this->comentario_encomendas );
        Session::put('visitasPropostasComentario_propostas', $this->comentario_propostas );
        
        Session::put('visitasPropostasComentario_financeiro', $this->comentario_financeiro );
        Session::put('visitasPropostasComentario_occorencias', $this->comentario_occorencias );
        Session::put('visitasPropostastipoVisitaSelect', $this->tipoVisitaSelect);

        $this->tabRelatorio = "";
        $this->tabDetail = "";
        $this->tabAnalysis = "";
        $this->tabEncomendas = "";
        $this->tabPropostas = "";
        $this->tabFinanceiro = "";
        $this->tabOcorrencia = "";
        $this->tabVisitas = "";
        $this->tabAssistencias = "";

        if($pagerange == "tabPropostas"){
            $this->tabPropostas = "show active";
        }else if($pagerange == "tabDetail"){
            $this->tabDetail = "show active";
        }else if($pagerange == "tabAnalysis"){
            $this->tabAnalysis = "show active";
        }else if($pagerange == "tabEncomendas"){
            $this->tabEncomendas = "show active";
        }else if($pagerange == "tabFinanceiro"){
            $this->tabFinanceiro = "show active";
        }else if($pagerange == "tabOcorrencia"){
            $this->tabOcorrencia = "show active";
        }else if($pagerange == "tabVisitas"){
            $this->tabVisitas = "show active";
        }else if($pagerange == "tabAssistencias"){
            $this->tabAssistencias = "show active";
        }

        $this->restartDetails();
    }
    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        $arrayAna = $this->clientesRepository->getListagemAnalisesCliente($this->perPage,$this->pageChosen,$this->idCliente);
        // dd($arrayAna);
        $this->analysisClientes = $arrayAna["paginator"];

        $this->tabRelatorio = "";
        $this->tabDetail = "";
        $this->tabAnalysis = "show active";
        $this->tabEncomendas = "";
        $this->tabPropostas = "";
        $this->tabFinanceiro = "";
        $this->tabOcorrencia = "";
        $this->tabVisitas = "";
        $this->tabAssistencias = "";
    }


    public function previousPage()
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];


        $this->tabRelatorio = "";
        $this->tabDetail = "";
        $this->tabAnalysis = "show active";
        $this->tabEncomendas = "";
        $this->tabPropostas = "";
        $this->tabFinanceiro = "";
        $this->tabOcorrencia = "";
        $this->tabVisitas = "";
        $this->tabAssistencias = "";
    }

    public function nextPage()
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];


        $this->tabRelatorio = "";
        $this->tabDetail = "";
        $this->tabAnalysis = "show active";
        $this->tabEncomendas = "";
        $this->tabPropostas = "";
        $this->tabFinanceiro = "";
        $this->tabOcorrencia = "";
        $this->tabVisitas = "";
        $this->tabAssistencias = "";
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


        $this->tabRelatorio = "";
        $this->tabDetail = "";
        $this->tabAnalysis = "show active";
        $this->tabEncomendas = "";
        $this->tabPropostas = "";
        $this->tabFinanceiro = "";
        $this->tabOcorrencia = "";
        $this->tabVisitas = "";
        $this->tabAssistencias = "";

        $this->restartDetails();

    }
    public function updatedPerPageRelatorio(): void
    {
        $this->resetPage();
        session()->put('perPageRelatorio', $this->perPageRelatorio);


        $this->tabRelatorio = "show active";
        $this->tabDetail = "";
        $this->tabAnalysis = "";
        $this->tabEncomendas = "";
        $this->tabPropostas = "";
        $this->tabFinanceiro = "";
        $this->tabOcorrencia = "";
        $this->tabVisitas = "";
        $this->tabAssistencias = "";


        $this->restartDetails();

    }

    public function restartDetails()
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
       
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesAnalisesCliente($this->perPageRelatorio,$this->idCliente);

        $this->numberMaxPages = $arrayCliente["nr_paginas"] + 1;
        $this->totalRecords = $arrayCliente["nr_registos"];
    }

    public function guardarVisita()
    {

        if(session('visitasPropostasComentario_encomendas')){
            $this->comentario_encomendas = session('visitasPropostasComentario_encomendas');
        }
        if( session('visitasPropostasComentario_propostas')){
            $this->comentario_propostas = session('visitasPropostasComentario_propostas');
        }
        if(session('visitasPropostasComentario_financeiro')){
            $this->comentario_financeiro = session('visitasPropostasComentario_financeiro');
        }
        if(session('visitasPropostasComentario_occorencias')){
            $this->comentario_occorencias = session('visitasPropostasComentario_occorencias');
        }
        if(session('visitasPropostasAnexos')){
            $this->anexos = session('visitasPropostasAnexos');
        }
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);

        $this->detailsClientes = $arrayCliente["object"];

        $visitas = Visitas::where('id_visita_agendada',$this->idVisita)->first();

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
        // dd($originalNames);
        if($visitas != null)
        {
            if($visitas->count() > 0)
            {
                
                $agenda = VisitasAgendadas::where('id',$this->idVisita)->update([
                    "finalizado" => "2",
                    "assunto_text" => $this->assunto,
                    "id_tipo_visita" => $this->tipoVisitaSelect
                ]);

                $getId = VisitasAgendadas::where('id',$this->idVisita)->first();

                $visitaCreate = Visitas::where('id_visita_agendada',$this->idVisita)->update([
                    "id_visita_agendada" => $getId->id,
                    "numero_cliente" => $this->detailsClientes->customers[0]->no,
                    "assunto" => $this->assunto,
                    "relatorio" => $this->relatorio,
                    "anexos" => json_encode($originalNames),
                    "pendentes_proxima_visita" => $this->pendentes,
                    "comentario_encomendas" => $this->comentario_encomendas,
                    "comentario_propostas" => $this->comentario_propostas,
                    "comentario_financeiro" => $this->comentario_financeiro,
                    "comentario_ocorrencias" => $this->comentario_occorencias,
                    "data" => date('Y-m-d'),
                    "user_id" => Auth::user()->id
                ]);


                if(!empty($visitaCreate)) {
                    session()->flash('success', "Visita atualizada com sucesso");
                    return redirect()->route('visitas.info',["id" => $this->idVisita]);
        
                } else {
                    session()->flash('warning', "Não foi possivel alterar a visita!");
                    return redirect()->route('visitas.info',["id" => $this->idVisita]);
                }
            }
            else 
            {

                $agenda = VisitasAgendadas::create([
                    "client_id" => $this->detailsClientes->customers[0]->id,
                    "cliente" => $this->detailsClientes->customers[0]->name,
                    "data_inicial" => date('Y-m-d'),
                    "hora_inicial" => date('H:i'),
                    "user_id" => Auth::user()->id,
                    "assunto_text" => $this->assunto,
                    "finalizado" => "2",
                    "id_tipo_visita" => $this->tipoVisitaSelect
                ]);



                $visitaCreate = Visitas::create([
                    "id_visita_agendada" => $agenda->id,
                    "numero_cliente" => $this->detailsClientes->customers[0]->no,
                    "assunto" => $this->assunto,
                    "relatorio" => $this->relatorio,
                    "anexos" => json_encode($originalNames),
                    "pendentes_proxima_visita" => $this->pendentes,
                    "comentario_encomendas" => $this->comentario_encomendas,
                    "comentario_propostas" => $this->comentario_propostas,
                    "comentario_financeiro" => $this->comentario_financeiro,
                    "comentario_ocorrencias" => $this->comentario_occorencias,
                    "data" => date('Y-m-d'),
                    "user_id" => Auth::user()->id
                ]);

        
                
                if(!empty($visitaCreate)) {
                    session()->flash('success', "Visita registada com sucesso");
                    return redirect()->route('visitas.info',["id" => $agenda->id]);
        
                } else {
                    session()->flash('warning', "Não foi possivel adicionar visita!");
                    return redirect()->route('visitas.info',["id" => $agenda->id]);
                }

            }
           
        }
        else 
        {
          
            if($this->idVisita == 0)
            {
                $agenda = VisitasAgendadas::create([
                    "client_id" => $this->detailsClientes->customers[0]->id,
                    "cliente" => $this->detailsClientes->customers[0]->name,
                    "assunto_text" => $this->assunto,
                    "data_inicial" => date('Y-m-d'),
                    "hora_inicial" => date('H:i'),
                    "user_id" => Auth::user()->id,
                    "finalizado" => "2",
                    "id_tipo_visita" => $this->tipoVisitaSelect
                ]);


                $getId = VisitasAgendadas::where('id',$agenda->id)->first();
    
                    
                $visitaCreate = Visitas::create([
                    "id_visita_agendada" => $agenda->id,
                    "numero_cliente" => $this->detailsClientes->customers[0]->no,
                    "assunto" => $this->assunto,
                    "relatorio" => $this->relatorio,
                    "anexos" => json_encode($originalNames),
                    "pendentes_proxima_visita" => $this->pendentes,
                    "comentario_encomendas" => $this->comentario_encomendas,
                    "comentario_propostas" => $this->comentario_propostas,
                    "comentario_financeiro" => $this->comentario_financeiro,
                    "comentario_ocorrencias" => $this->comentario_occorencias,
                    "data" => date('Y-m-d'),
                    "user_id" => Auth::user()->id
                ]);
            }
            else 
            {
                $agenda = VisitasAgendadas::where('id',$this->idVisita)->update([
                    "assunto_text" => $this->assunto,
                    "finalizado" => "2",
                    "id_tipo_visita" => $this->tipoVisitaSelect
                ]);
    
                $getId = VisitasAgendadas::where('id',$this->idVisita)->first();
    
                $visitaCreate = Visitas::create([
                    "id_visita_agendada" => $getId->id,
                    "numero_cliente" => $this->detailsClientes->customers[0]->no,
                    "assunto" => $this->assunto,
                    "relatorio" => $this->relatorio,
                    "anexos" => json_encode($originalNames),
                    "pendentes_proxima_visita" => $this->pendentes,
                    "comentario_encomendas" => $this->comentario_encomendas,
                    "comentario_propostas" => $this->comentario_propostas,
                    "comentario_financeiro" => $this->comentario_financeiro,
                    "comentario_ocorrencias" => $this->comentario_occorencias,
                    "data" => date('Y-m-d'),
                    "user_id" => Auth::user()->id
                ]);
            }
           
           
            if(!empty($visitaCreate)) {
                session()->flash('success', "Visita registada com sucesso");
                return redirect()->route('visitas.info',["id" => $getId->id]);
    
            } else {
                session()->flash('warning', "Não foi possivel adicionar visita!");
                return redirect()->route('visitas.info',["id" => $getId->id]);
            }

        }
       
        

    }

    public function finalizarVisita()
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);

        $this->detailsClientes = $arrayCliente["object"];

        $visitas = Visitas::where('id_visita_agendada',$this->idVisita)->first();

        
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

        if($visitas != null)
        {

            if($visitas->count() > 0)
            {
                // dd('AQUI 1');
                $agenda = VisitasAgendadas::where('id',$this->idVisita)->update([
                    "finalizado" => "1",
                    "data_final" => date('Y-m-d'),
                    "hora_final" => date('H:i'),
                    "assunto_text" => $this->assunto,
                    "id_tipo_visita" => $this->tipoVisitaSelect
                ]);

                $getId = VisitasAgendadas::where('id',$this->idVisita)->first();

                $visitaCreate = Visitas::where('id_visita_agendada',$this->idVisita)->update([
                    "id_visita_agendada" => $getId->id,
                    "numero_cliente" => $this->detailsClientes->customers[0]->no,
                    "assunto" => $this->assunto,
                    "relatorio" => $this->relatorio,
                    "anexos" => json_encode($originalNames),
                    "pendentes_proxima_visita" => $this->pendentes,
                    "comentario_encomendas" => $this->comentario_encomendas,
                    "comentario_propostas" => $this->comentario_propostas,
                    "comentario_financeiro" => $this->comentario_financeiro,
                    "comentario_ocorrencias" => $this->comentario_occorencias,
                    "data" => date('Y-m-d'),
                    "user_id" => Auth::user()->id
                ]);

             
            } 
            else {
                // dd('AQUI 2');
                $agenda = VisitasAgendadas::create([
                    "client_id" => $this->detailsClientes->customers[0]->id,
                    "cliente" => $this->detailsClientes->customers[0]->name,
                    "data_inicial" => date('Y-m-d'),
                    "hora_inicial" => date('H:i'),
                    "data_final" => date('Y-m-d'),
                    "hora_final" => date('H:i'),
                    "user_id" => Auth::user()->id,
                    "assunto_text" => $this->assunto,
                    "finalizado" => "1",
                    "id_tipo_visita" => $this->tipoVisitaSelect
                ]);


                $visitaCreate = Visitas::create([
                    "id_visita_agendada" => $agenda->id,
                    "numero_cliente" => $this->detailsClientes->customers[0]->no,
                    "assunto" => $this->assunto,
                    "relatorio" => $this->relatorio,
                    "anexos" => json_encode($originalNames),
                    "pendentes_proxima_visita" => $this->pendentes,
                    "comentario_encomendas" => $this->comentario_encomendas,
                    "comentario_propostas" => $this->comentario_propostas,
                    "comentario_financeiro" => $this->comentario_financeiro,
                    "comentario_ocorrencias" => $this->comentario_occorencias,
                    "data" => date('Y-m-d'),
                    "user_id" => Auth::user()->id
                ]);

            }
        }
        else {

            if($this->idVisita == 0)
            {
                // dd('AQUI 3');
                $agenda = VisitasAgendadas::create([
                    "client_id" => $this->detailsClientes->customers[0]->id,
                    "cliente" => $this->detailsClientes->customers[0]->name,
                    "assunto_text" => $this->assunto,
                    "data_inicial" => date('Y-m-d'),
                    "hora_inicial" => date('H:i'),
                    "data_final" => date('Y-m-d'),
                    "hora_final" => date('H:i'),
                    "user_id" => Auth::user()->id,
                    "finalizado" => "1",
                    "id_tipo_visita" => $this->tipoVisitaSelect
                ]);
    
                    
                $visitaCreate = Visitas::create([
                    "id_visita_agendada" => $agenda->id,
                    "numero_cliente" => $this->detailsClientes->customers[0]->no,
                    "assunto" => $this->assunto,
                    "relatorio" => $this->relatorio,
                    "anexos" => json_encode($originalNames),
                    "pendentes_proxima_visita" => $this->pendentes,
                    "comentario_encomendas" => $this->comentario_encomendas,
                    "comentario_propostas" => $this->comentario_propostas,
                    "comentario_financeiro" => $this->comentario_financeiro,
                    "comentario_ocorrencias" => $this->comentario_occorencias,
                    "data" => date('Y-m-d'),
                    "user_id" => Auth::user()->id
                ]);

                $this->idVisita = $agenda->id;
            }
            else {
                // dd('AQUI 4');
                $agenda = VisitasAgendadas::where('id',$this->idVisita)->update([
                    "finalizado" => "1",
                    "data_final" => date('Y-m-d'),
                    "hora_final" => date('H:i'),
                    "assunto_text" => $this->assunto,
                    "id_tipo_visita" => $this->tipoVisitaSelect
                ]);
    
                $getId = VisitasAgendadas::where('id',$this->idVisita)->first();
    
                $visitaCreate = Visitas::create([
                    "id_visita_agendada" => $getId->id,
                    "numero_cliente" => $this->detailsClientes->customers[0]->no,
                    "assunto" => $this->assunto,
                    "relatorio" => $this->relatorio,
                    "anexos" => json_encode($originalNames),
                    "pendentes_proxima_visita" => $this->pendentes,
                    "comentario_encomendas" => $this->comentario_encomendas,
                    "comentario_propostas" => $this->comentario_propostas,
                    "comentario_financeiro" => $this->comentario_financeiro,
                    "comentario_ocorrencias" => $this->comentario_occorencias,
                    "data" => date('Y-m-d'),
                    "user_id" => Auth::user()->id
                ]);

            }

        }

        $dataPHC = date('Y-m-d')."T".date('H:i:s');


        $getVisitaID = VisitasAgendadas::where('id',$this->idVisita)->first();
        
        // dd($this->idVisita);

        $tipoVisita = TiposVisitas::where('id',$this->tipoVisitaSelect)->first();

        $sendPHC = $this->visitasRepository->sendVisitaToPhc($getVisitaID->id, $this->detailsClientes->customers[0]->id, $this->assunto, $this->relatorio, $tipoVisita->tipo,$this->pendentes, $this->comentario_encomendas, $this->comentario_propostas, $this->comentario_financeiro, $this->comentario_occorencias, $dataPHC);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/visit?visit_id='.$getVisitaID->id,
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/visit?visit_id=233',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
    
        curl_close($curl);

        $response_decoded = json_decode($response);
        $prop_enc = $response_decoded->documents ?? null;
        // dd($prop_enc);
        $pdfEncomendaContent = [];
        $pdfPropostaContent = [];
        if($prop_enc != null)
        {
            foreach($prop_enc as $item)
            {
                $firstWord = explode(' ', $item->budget)[0];

                if($firstWord == "Encomenda")
                {
                    $pdf = new Dompdf();
                    $pdf = PDF::loadView('pdf.pdfTabelaEncomendaProp', ["encomenda" => json_encode($item)]);
                
                    $pdf->render();
                
                    $pdfEncomendaContent[] = $pdf->output();
                } else
                {
                    $pdf = new Dompdf();
                    $pdf = PDF::loadView('pdf.pdfTabelaPropostas', ["proposta" => json_encode($item)]);
                
                    $pdf->render();
                
                    $pdfPropostaContent[] = $pdf->output();
                }

            }

        }


        $pdf = new Dompdf();
        $pdf = PDF::loadView('pdf.pdfRelatorioVisita', ["visita" => json_encode($getVisitaID)]);
    
        $pdf->render();
    
        $pdfContent = $pdf->output();

        // Primeiro, adicione o PDF único ao array
        $pdfContents = array_merge([$pdfContent], $pdfEncomendaContent, $pdfPropostaContent); // Adiciona $pdfContent no início


        $grupos = GrupoEmail::where('local_funcionamento', 'RelatorioVisita')->get();
        // dd($grupos);
        if(isset($grupos)){
            $this->emailArray = [];
            foreach ($grupos as $grupo) {
                $emails = array_map('trim', explode(',', $grupo->emails));
                
                $this->emailArray = array_merge($this->emailArray, $emails);
            }

        foreach($this->emailArray as $i => $email)
        {
            // dd(json_encode($getVisitaID));
            Mail::to($email)->send(new SendRelatorio($pdfContents, json_encode($getVisitaID)));
        }

        $responseArray = $sendPHC->getData(true);
        
        if($responseArray["success"] == true){
            session()->flash('success', "Visita registada e finalizada com sucesso");
            return redirect()->route('visitas.info',["id" => $getVisitaID->id]);
        }
        else {
            
            session()->flash('warning', "Não foi possivel adicionar visita!");
            return redirect()->route('visitas.info',["id" => $getVisitaID->id]);
        }

    }
}

    public function openModalSaveVisita()
    {
        $this->restartDetails();
        if($this->activeFinalizado == "1"){ //finalizar

        
            $response = $this->clientesRepository->storeVisita($this->idVisita, $this->detailsClientes->customers[0]->no,$this->assunto,$this->relatorio,$this->pendentes,$this->comentario_encomendas,$this->comentario_propostas,$this->comentario_financeiro,$this->comentario_occorencias);
            
            $responseArray = $response->getData(true);
            VisitasAgendadas::where('id', $this->idVisita)->update(['finalizado' => 1]);
            if($responseArray["success"] == true){
                session()->flash('success', "Visita registada com sucesso");
            } else {
                if($responseArray["type"] == "1")
                {
                    session()->flash('error', $responseArray["data"]);
                } else {
                    session()->flash('error', "Não foi possivel adicionar a visita");
                }
            }

            $this->skipRender();
            
            return redirect()->route('visitas');
        }else if($this->activeFinalizado == "2"){ // adicionar
            $this->dispatchBrowserEvent('listagemDetalherVisitasModal');
        }
        
    }
    public function saveVisita($id = null)
    {
        $this->restartDetails();
        if($this->idVisita != 0) {
            $response = $this->clientesRepository->storeVisita($this->idVisita, $this->detailsClientes->customers[0]->no,$this->assunto,$this->relatorio,$this->pendentes,$this->comentario_encomendas,$this->comentario_propostas,$this->comentario_financeiro,$this->comentario_occorencias);
            
        }
        

        if($id != null) {
            $this->idVisita = $id['visitaId'];
            $response = $this->clientesRepository->storeVisita($this->idVisita, $this->detailsClientes->customers[0]->no,$this->assunto,$this->relatorio,$this->pendentes,$this->comentario_encomendas,$this->comentario_propostas,$this->comentario_financeiro,$this->comentario_occorencias);
            VisitasAgendadas::where('id', $id)->update(['finalizado' => 1]);
        }
        $responseArray = $response->getData(true);
        

        if($responseArray["success"] == true){
            session()->flash('success', "Visita registada com sucesso");
        } else {
            if($responseArray["type"] == "1")
            {
                session()->flash('error', $responseArray["data"]);
            } else {
                session()->flash('error', "Não foi possivel adicionar a visita");
            }
        }

        $this->skipRender();
        
        return redirect()->route('visitas');
        

    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }
    public function voltarAtras()
    {
        // $this->dispatchBrowserEvent('changeRoute');
        // $this->skipRender();

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
    public function openEncomenda($idcliente, $idVisita)
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];


        $this->anexos = session('visitasPropostasAnexos');

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


        if($this->idVisita == 0)
        {

            $agenda = VisitasAgendadas::create([
                "client_id" => $this->detailsClientes->customers[0]->id,
                "cliente" => $this->detailsClientes->customers[0]->name,
                "assunto_text" => $this->assunto,
                "data_inicial" => date('Y-m-d'),
                "hora_inicial" => date('H:i'),
                "data_final" => date('Y-m-d'),
                "hora_final" => date('H:i'),
                "user_id" => Auth::user()->id,
                "finalizado" => "2",
                "id_tipo_visita" => $this->tipoVisitaSelect
            ]);

            
            $visitaCreate = Visitas::create([
                "id_visita_agendada" => $agenda->id,
                "numero_cliente" => $this->detailsClientes->customers[0]->no,
                "assunto" => $this->assunto,
                "relatorio" => $this->relatorio,
                "anexos" => json_encode($originalNames),
                "pendentes_proxima_visita" => $this->pendentes,
                "comentario_encomendas" => $this->comentario_encomendas,
                "comentario_propostas" => $this->comentario_propostas,
                "comentario_financeiro" => $this->comentario_financeiro,
                "comentario_ocorrencias" => $this->comentario_occorencias,
                "data" => date('Y-m-d'),
                "user_id" => Auth::user()->id
            ]);
            $idVisita = $agenda->id;
            $this->idVisita = $idVisita;
        }else{
            $agenda = VisitasAgendadas::where('id',$this->idVisita)->update([
                "assunto_text" => $this->assunto,
                "finalizado" => "2",
                "id_tipo_visita" => $this->tipoVisitaSelect
            ]);

            $getId = VisitasAgendadas::where('id',$this->idVisita)->first();

            $visitaCreate = Visitas::where('id_visita_agendada',$this->idVisita)->update([
                "id_visita_agendada" => $getId->id,
                "numero_cliente" => $this->detailsClientes->customers[0]->no,
                "assunto" => $this->assunto,
                "relatorio" => $this->relatorio,
                "anexos" => json_encode($originalNames),
                "pendentes_proxima_visita" => $this->pendentes,
                "comentario_encomendas" => $this->comentario_encomendas,
                "comentario_propostas" => $this->comentario_propostas,
                "comentario_financeiro" => $this->comentario_financeiro,
                "comentario_ocorrencias" => $this->comentario_occorencias,
                "data" => date('Y-m-d'),
                "user_id" => Auth::user()->id
            ]);
        }

        session(['rota' => "visitas.info"]);
        session(['parametro' => $this->idVisita]);

        return redirect()->route('encomendas.detail.visitas', [$idcliente, $idVisita]);
    }
    public function openProposta($idcliente, $idVisita)
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        $this->anexos = session('visitasPropostasAnexos');

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


        if($this->idVisita == 0)
        {

            

            $agenda = VisitasAgendadas::create([
                "client_id" => $this->detailsClientes->customers[0]->id,
                "cliente" => $this->detailsClientes->customers[0]->name,
                "assunto_text" => $this->assunto,
                "data_inicial" => date('Y-m-d'),
                "hora_inicial" => date('H:i'),
                "data_final" => date('Y-m-d'),
                "hora_final" => date('H:i'),
                "user_id" => Auth::user()->id,
                "finalizado" => "2",
                "id_tipo_visita" => $this->tipoVisitaSelect
            ]);

            
            $visitaCreate = Visitas::create([
                "id_visita_agendada" => $agenda->id,
                "numero_cliente" => $this->detailsClientes->customers[0]->no,
                "assunto" => $this->assunto,
                "relatorio" => $this->relatorio,
                "anexos" => json_encode($originalNames),
                "pendentes_proxima_visita" => $this->pendentes,
                "comentario_encomendas" => $this->comentario_encomendas,
                "comentario_propostas" => $this->comentario_propostas,
                "comentario_financeiro" => $this->comentario_financeiro,
                "comentario_ocorrencias" => $this->comentario_occorencias,
                "data" => date('Y-m-d'),
                "user_id" => Auth::user()->id
            ]);
            $idVisita = $agenda->id;
            $this->idVisita = $idVisita;

        }else{
            $agenda = VisitasAgendadas::where('id',$this->idVisita)->update([
                "assunto_text" => $this->assunto,
                "finalizado" => "2",
                "id_tipo_visita" => $this->tipoVisitaSelect
            ]);

            $getId = VisitasAgendadas::where('id',$this->idVisita)->first();

            $visitaCreate = Visitas::where('id_visita_agendada',$this->idVisita)->update([
                "id_visita_agendada" => $getId->id,
                "numero_cliente" => $this->detailsClientes->customers[0]->no,
                "assunto" => $this->assunto,
                "relatorio" => $this->relatorio,
                "anexos" => json_encode($originalNames),
                "pendentes_proxima_visita" => $this->pendentes,
                "comentario_encomendas" => $this->comentario_encomendas,
                "comentario_propostas" => $this->comentario_propostas,
                "comentario_financeiro" => $this->comentario_financeiro,
                "comentario_ocorrencias" => $this->comentario_occorencias,
                "data" => date('Y-m-d'),
                "user_id" => Auth::user()->id
            ]);
        }
        session(['rota' => "visitas.info"]);
        session(['parametro' => $this->idVisita]);

        return redirect()->route('propostas.detail.visitas', [$idcliente, $idVisita]);
    }
    public function updatedComentarioEncomendas()
    {
        $this->emit('atualizarEncomendas');
        Session::put('visitasPropostasComentario_encomendas', $this->comentario_encomendas );
    }
    public function updatedComentarioPropostas()
    {
        $this->emit('atualizarPropostas');
        Session::put('visitasPropostasComentario_propostas', $this->comentario_propostas );
    }
    public function updatedComentarioFinanceiro()
    {
        $this->emit('atualizarFinanceiro');
        Session::put('visitasPropostasComentario_financeiro', $this->comentario_financeiro );
    }
    public function updatedComentarioOccorencias()
    {
        $this->emit('atualizarOccorencias');
        Session::put('visitasPropostasComentario_occorencias', $this->comentario_occorencias );
    }
    public function render()
    {
        Session::put('trueAdd', 0);

        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];



        Session::put('visitasPropostasCheckStatus', $this->checkStatus);

        

        $this->tiposVisitaCollection = TiposVisitas::all();
        
        $getVisitaID = VisitasAgendadas::where('id',$this->idVisita)->first();  
        // $this->analisesCliente ?? collect();
        $arrayAna = $this->clientesRepository->getListagemAnalisesCliente($this->perPage,$this->pageChosen,$this->idCliente);
        
        // dd($arrayAna["paginator"]);
        
        $this->analysisClientes = $arrayAna["paginator"];
        $this->analisesCliente ?? collect();  

        // dd($this->analysisClientes);
        return view('livewire.visitas.detalhe-visitas',["detalhesCliente" => $this->detailsClientes, "analisesCliente" => $this->analysisClientes, "getVisita" => $getVisitaID]);
    }
}
