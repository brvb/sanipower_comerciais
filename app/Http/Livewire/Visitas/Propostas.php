<?php

namespace App\Http\Livewire\Visitas;

use Dompdf\Dompdf;
use Livewire\Component;
use App\Models\Visitas;
use App\Models\Carrinho;
use App\Mail\SendProposta;
use App\Models\Comentarios;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\VisitasAgendadas;

class Propostas extends Component
{
    use WithPagination;

    private ?object $clientesRepository = NULL;
    protected ?object $clientes = NULL;
    public string $idCliente = "";
    public string $idVisita = "";

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


    private ?object $detailsClientes = NULL;
    public string $assunto = "";
    public string $relatorio = "";
    public string $pendentes = "";
    public string $comentario_encomendas = "";
    public string $comentario_propostas = "";
    public string $comentario_financeiro = "";
    public string $comentario_occorencias = "";
    public int $tipoVisitaSelect;
    

    public ?string $comentarioProposta = "";

    private ?object $detailsPropostas = NULL;
    public ?object $comentario = NULL;

    public $estadoProposta = "";

    public $anexos = [];
    public $tempPaths = [];
    protected $listeners = ['atualizarPropostas' => 'render'];
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
        // dd($this->idVisita);
        //$this->idCliente = "AJ19073058355,4450000-1";

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
        if(session('visitasPropostasCheckStatus')){
            $this->checkStatus = session('visitasPropostasCheckStatus');
        }
        $this->restartDetails();

    }


    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen, $this->idCliente);
        $this->detailsPropostas = $propostasArray["paginator"];
    }


    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;
            $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
            $this->detailsPropostas = $propostasArray["paginator"];
        }
        else if($this->pageChosen == 1){
            $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
            $this->detailsPropostas = $propostasArray["paginator"];
        }

    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;

            $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
            $this->detailsPropostas = $propostasArray["paginator"];
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

    public function updatedEstadoProposta()
    {
        // $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
        // $this->detailsPropostas = $propostasArray["paginator"];

        $this->pageChosen = 1;
        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta);
   
        $this->detailsPropostas = $propostasArray["paginator"];
        $this->numberMaxPages = $propostasArray["nr_paginas"] + 1;
        $this->totalRecords = $propostasArray["nr_registos"];
    }

    public function restartDetails()
    {
        $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
        // $getInfoClientes = $this->clientesRepository->getNumberOfPagesPropostasCliente($this->perPage,$this->idCliente);
   
        $this->detailsPropostas = $propostasArray["paginator"];
        $this->numberMaxPages = $propostasArray["nr_paginas"] + 1;
        $this->totalRecords = $propostasArray["nr_registos"];

    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function comentarioModal($id,$name)
    {
        $this->restartDetails();

        $this->propostaID = $id;
        $this->propostaName = $name;

        $this->comentarioProposta = "";

        $this->dispatchBrowserEvent('openComentarioModalPropostas');

    }

    public function sendComentario($idProposta)
    {
        if (empty($this->comentarioProposta)) {
            $message = "O campo de comentário está vazio!";
            $status = "error";
        } else {
        $response = $this->clientesRepository->sendComentarios($idProposta,$this->comentarioProposta, "propostas");

        $responseArray = $response->getData(true);

        if($responseArray["success"] == true){
            $message = "Comentário adicionado com sucesso!";
            $status = "success";
         } else {
             $message = "Não foi possivel adicionar o comentário!";
             $status = "error";
         }

        }

        $this->restartDetails();

        $this->dispatchBrowserEvent('checkToaster',["message" => $message, "status" => $status]);
    }


    public function gerarPdfProposta($propostaID, $proposta)
    {
        if (!$proposta) {
            return redirect()->back()->with('error', 'Proposta não encontrada.');
        }
        foreach ($proposta['data'] as $oneProposta) {
            if ($oneProposta['id'] === $propostaID) {
                $proposta = $oneProposta;
            }
        }

        foreach ($proposta['lines'] as $index => $prod) {
            $image_ref = "https://storage.sanipower.pt/storage/produtos/".$prod['family_number']."/".$prod['family_number']."-".$prod['subfamily_number']."-".$prod['product_number'].".jpg";
            $proposta['lines'][$index]['image_ref'] = $image_ref;
        }

        $pdf = PDF::loadView('pdf.pdfTabelaPropostas', ["proposta" => json_encode($proposta)]);

        $this->dispatchBrowserEvent('checkToaster');

        $this->restartDetails();


        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'pdfTabelaPropostas.pdf');
    }

    public function verComentario($idProposta)
    {
        // Carrega o comentário correspondente
        $comentario = Comentarios::with('user')->where('stamp', $idProposta)->where('tipo', 'propostas')->orderBy('id','DESC')->get();

        // Define o comentário para exibir no modal
        $this->comentario = $comentario;

        $this->restartDetails();
        // Dispara o evento para abrir o modal
        $this->dispatchBrowserEvent('abrirModalVerComentarioProposta');
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
        Session::put('visitasPropostasComentario_encomendas', $this->comentario_encomendas );
        Session::put('visitasPropostasComentario_propostas', $this->comentario_propostas );
        Session::put('visitasPropostasComentario_financeiro', $this->comentario_financeiro );
        Session::put('visitasPropostasComentario_occorencias', $this->comentario_occorencias );
        // dd($this->assunto, $this->relatorio, $this->pendentes, $this->comentario_encomendas, $this->comentario_propostas,  $this->comentario_financeiro, $this->comentario_occorencias,$this->tipoVisitaSelect);



        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        $visitas = Visitas::where('id_visita_agendada',intval($this->idVisita))->first();


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
                Session::put('rota','visitas.info');
                Session::put('parametro',$agenda->id);

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
                Session::put('rota','visitas.info');
                Session::put('parametro',$getId->id);
            }
            // dd($this, $getId, $visitas);
           
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
    public function detalhePropostaModal($proposta)
    {
        // dd($this->idVisita);
        $getId = VisitasAgendadas::where('id',$this->idVisita)->first();
        // dd($getId);
        if ($getId != null){
            if($getId->finalizado != 1)
            {
                $this->guardarVisita();

            }
        }else
        {
            $this->guardarVisita();
        }

        if($this->idVisita == 0)
        {

           
        } else {

            Session::put('rota','visitas.info');
            Session::put('parametro',$this->idVisita);
           
        }
        

       

        $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
        $this->detailsPropostas = $propostasArray["paginator"];

        

        foreach($this->detailsPropostas as $det)
        {
            if($det->id == $proposta["id"])
            {
                $propSend = $det;
            }
        }

        

        Session::put('proposta',$propSend);

        return redirect()->route('propostas.proposta',["idProposta" => $propSend->id]);
        
        // $this->propostaID = $id;

        // $this->comentarioProposta = "";

        // $this->restartDetails();

        // $this->dispatchBrowserEvent('openDetalhePropostaModal');
    }

    public function adjudicarProposta($detalheProposta,$propostaID)
    {       
        foreach($detalheProposta["data"] as $pr)
        {
            if($propostaID == $pr["id"])
            {
                $proposta = $pr;
            }
        }

        foreach($proposta["lines"] as $prop)
        {
           
            Carrinho::create([
                "id_proposta" => "",
                "id_encomenda" => $proposta["id"],
                "id_cliente" => $proposta["number"],
                "id_user" => Auth::user()->id,
                "referencia" => $prop["reference"],
                "designacao" => $prop["description"],
                "price" => $prop["price"],
                "discount" => $prop["discount1"],
                "discount2" => $prop["discount2"],
                "qtd" => $prop["quantity"],
                "iva" => $prop["tax"],
                "pvp" => $prop["pvp"],
                "model" => $prop["model"],
                "image_ref" => "https://storage.sanipower.pt/storage/produtos/".$prop["family_number"]."/".$prop["family_number"]."-".$prop["subfamily_number"]."-".$prop["product_number"].".jpg",
                "proposta_info" => $proposta["budget"]
            ]);
        }

        
        $this->clientes = $this->clientesRepository->getListagemClienteFiltro(10,1,"",$proposta["number"],"","","","");


        session()->flash("success", "Proposta adjudicada com sucesso");
        return redirect()->route('encomendas.detail',["id" => $this->clientes[0]->id]);
      

    }

    public function enviarEmail($detalheProposta,$propostaID)
    {
       
        foreach($detalheProposta["data"] as $pr)
        {
            if($propostaID == $pr["id"])
            {
                $proposta = $pr;
            }
        }

        if (!$proposta) {
            dd("Não há valor na variável \$proposta");
            return redirect()->back()->with('error', 'Proposta não encontrada.');
        }

 
        $pdf = new Dompdf();
        $pdf = PDF::loadView('pdf.pdfTabelaPropostas', ["proposta" => json_encode($proposta)]);
    
        $pdf->render();
    
        $pdfContent = $pdf->output();
    
       ; 
    
        try {
             Mail::to(Auth::user()->email)->send(new SendProposta($pdfContent));
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Email enviado!", "status" => "success"]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('checkToaster', ["message" => $e->getMessage(), "status" => "warning"]);
        }

        $this->restartDetails();
    }
    public function updatedComentarioPropostas()
    {
        Session::put('visitasPropostasComentario_propostas', $this->comentario_propostas );
    }
    public function render()
    {
        $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
        $this->detailsPropostas = $propostasArray["paginator"];

        if( session('visitasPropostasComentario_propostas')){
            $this->comentario_propostas = session('visitasPropostasComentario_propostas');
        }
        return view('livewire.visitas.propostas',["detalhesPropostas" => $this->detailsPropostas]);
    }
}
