<?php

namespace App\Http\Livewire\Visitas;

use Dompdf\Dompdf;
use Livewire\Component;
use App\Models\Visitas;
use App\Mail\SendEncomenda;
use App\Models\Comentarios;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;
use App\Models\VisitasAgendadas;

class Encomendas extends Component
{
    use WithPagination;

    private ?object $clientesRepository = NULL;
    protected ?object $clientes = NULL;
    public string $idCliente = "";
    public string $idVisita = "";

    private ?object $encomendasDetail = NULL;
    public ?string $encomendaID = "";
    public ?string $encomendaName = "";

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


    private ?object $detailsClientes = NULL;
    public string $assunto = "";
    public string $relatorio = "";
    public string $pendentes = "";
    public string $comentario_encomendas = "";
    public string $comentario_propostas = "";
    public string $comentario_financeiro = "";
    public string $comentario_occorencias = "";
    public int $tipoVisitaSelect;


    public ?string $comentarioEncomenda = "";

    private ?object $detailsEncomenda = NULL;
    public ?object $comentario = NULL;

    public $estadoEncomenda = "";


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

    public function mount($cliente, $visita)
    {
        $this->initProperties();
        $this->idCliente = $cliente;
        $this->idVisita = $visita;
        //$this->idCliente = "AJ19073058355,4450000-1";

        $this->restartDetails();

    }


    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        $this->detailsEncomenda = $encomendasArray["paginator"];
    }


    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;
            $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        
            $this->detailsEncomenda = $encomendasArray["paginator"];
        }
        else if($this->pageChosen == 1){
            $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        
            $this->detailsEncomenda = $encomendasArray["paginator"];
        }

    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;

            $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        
            $this->detailsEncomenda = $encomendasArray["paginator"];
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

    public function updatedperPage(): void
    {
        $this->resetPage();
        session()->put('perPage', $this->perPage);


        $this->restartDetails();

    }
    public function updatedEstadoEncomenda()
    {
        // $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        
        // $this->detailsEncomenda = $encomendasArray["paginator"];
        $this->pageChosen = 1;
        $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoEncomenda);
       
        $this->detailsEncomenda = $encomendasArray["paginator"];
        $this->numberMaxPages = $encomendasArray["nr_paginas"];
        $this->totalRecords = $encomendasArray["nr_registos"];
    }
    public function restartDetails()
    {
        $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
     
        $this->detailsEncomenda = $encomendasArray["paginator"];
        $this->numberMaxPages = $encomendasArray["nr_paginas"];
        $this->totalRecords = $encomendasArray["nr_registos"];


    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function comentarioModal($id,$name)
    {
        $this->restartDetails();
      
        $this->encomendaID = $id;
        $this->encomendaName = $name;

        $this->comentarioEncomenda = "";

        $this->dispatchBrowserEvent('openComentarioModal');

    }

    public function sendComentario($idEncomenda)
    {
        if (empty($this->comentarioEncomenda)) {
            $message = "O campo de comentário está vazio!";
            $status = "error";
        } else {
            $response = $this->clientesRepository->sendComentarios($idEncomenda, $this->comentarioEncomenda, "encomendas");

            $responseArray = $response->getData(true);

            if ($responseArray["success"] == true) {
                $message = "Comentário adicionado com sucesso!";
                $status = "success";
            } else {
                $message = "Não foi possível adicionar o comentário!";
                $status = "error";
            }
        }


        $this->restartDetails();

        $this->dispatchBrowserEvent('checkToaster',["message" => $message, "status" => $status]);
    }

    public function gerarPdfEncomenda($encomendaID, $encomenda)
    {
        if (!$encomenda) {
            return redirect()->back()->with('error', 'Proposta não encontrada.');
        }
        foreach ($encomenda['data'] as $oneEncomenda) {
            if ($oneEncomenda['id'] === $encomendaID) {
                $encomenda = $oneEncomenda;
            }
        }

        foreach ($encomenda['lines'] as $index => $prod) {
            $image_ref = "https://storage.sanipower.pt/storage/produtos/".$prod['family_number']."/".$prod['family_number']."-".$prod['subfamily_number']."-".$prod['product_number'].".jpg";
            $encomenda['lines'][$index]['image_ref'] = $image_ref;
        }
  
        $pdf = PDF::loadView('pdf.pdfTabelaEncomenda', ["encomenda" => json_encode($encomenda)]);

        $this->dispatchBrowserEvent('checkToaster');

        $this->restartDetails();


        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'pdfTabelaEncomenda.pdf');
    }

    public function verComentario($idEncomenda)
    {
        // Carrega o comentário correspondente
        $comentario = Comentarios::with('user')->where('stamp', $idEncomenda)->where('tipo', 'encomendas')->orderBy('id','DESC')->get();

        // Define o comentário para exibir no modal
        $this->comentario = $comentario;

        $this->restartDetails();
        // Dispara o evento para abrir o modal
        $this->dispatchBrowserEvent('abrirModalVerComentario');
    }

    public function guardarVisita()
    {
        if(session('visitasPropostasAssunto')){
            $this->assunto = session('visitasPropostasAssunto');
        }
        if(session('visitasPropostasRelatorio')){
            $this->relatorio = session('visitasPropostasRelatorio');
        }
        if(session('visitasPropostasPendentes')){
            $this->pendentes = session('visitasPropostasPendentes');
        }
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
        if(session('visitasPropostastipoVisitaSelect')){
            $this->tipoVisitaSelect = session('visitasPropostastipoVisitaSelect');
        }
        // dd($this->assunto, $this->relatorio, $this->pendentes, $this->comentario_encomendas, $this->comentario_propostas,  $this->comentario_financeiro, $this->comentario_occorencias,$this->tipoVisitaSelect);



        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        $visitas = Visitas::where('id_visita_agendada',intval($this->idVisita))->first();

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

        session()->forget('visitasPropostasAssunto');
        session()->forget('visitasPropostasRelatorio');
        session()->forget('visitasPropostasPendentes');
        session()->forget('visitasPropostasComentario_encomendas');
        session()->forget('visitasPropostasComentario_propostas');
        session()->forget('visitasPropostasComentario_financeiro');
        session()->forget('visitasPropostasComentario_occorencias');
        session()->forget('visitasPropostastipoVisitaSelect');
        $this->restartDetails();

    }
    public function detalheEncomendaModal($encomenda)
    {
        $this->guardarVisita();
        if($this->idVisita == 0)
        {

            Session::put('rota','visitas.detail');
            Session::put('parametro',$this->idCliente);
           
        } else {

            Session::put('rota','visitas.info');
            Session::put('parametro',$this->idVisita);
           
        }

        $encomendasArray = $this->clientesRepository->getEncomendasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        
        $this->detailsEncomenda = $encomendasArray["paginator"];

        

        foreach($this->detailsEncomenda as $det)
        {
            if($det->id == $encomenda["id"])
            {
                $propSend = $det;
            }
        }

        

        Session::put('encomenda',$propSend);

        return redirect()->route('encomendas.encomenda',["idEncomenda" => $propSend->id]);
        
        // $this->encomendaID = $id;

        // $this->comentarioEncomenda = "";

        // $this->restartDetails();

        // $this->dispatchBrowserEvent('openDetalheEncomendaModal');
    }

    public function enviarEmail($detalheEncomenda,$encomendaID)
    {
        
        foreach($detalheEncomenda["data"] as $pr)
        {
            if($encomendaID == $pr["id"])
            {
                $encomenda = $pr;
            }
        }

        if (!$encomenda) {
            dd("Não há valor na variável \$proposta");
            return redirect()->back()->with('error', 'Proposta não encontrada.');
        }

 
        $pdf = new Dompdf();
        $pdf = PDF::loadView('pdf.pdfTabelaEncomenda', ["encomenda" => json_encode($encomenda)]);
    
        $pdf->render();
    
        $pdfContent = $pdf->output();
    
      
        try {
             Mail::to(Auth::user()->email)->send(new SendEncomenda($pdfContent));
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Email enviado!", "status" => "success"]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('checkToaster', ["message" => $e->getMessage(), "status" => "warning"]);
        }

        $this->restartDetails();
    }



    public function render()
    {
        return view('livewire.visitas.encomendas',["detalhesEncomenda" => $this->detailsEncomenda]);
    }
}
