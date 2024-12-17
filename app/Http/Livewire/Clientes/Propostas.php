<?php

namespace App\Http\Livewire\Clientes;

use Dompdf\Dompdf;
use Livewire\Component;
use App\Models\Carrinho;
use App\Mail\SendProposta;
use App\Models\Comentarios;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;


class Propostas extends Component
{
    use WithPagination;

    private ?object $clientesRepository = NULL;
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

    public ?string $comentarioProposta = "";

    private ?object $detailsPropostas = NULL;
    public ?object $comentario = NULL;

    public $estadoProposta = "";
    public $typeProposta = "";

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

        //$this->idCliente = "AJ19073058355,4450000-1";

        $this->restartDetails();

    }


    public function gotoPage($page)
    {
        $this->pageChosen = $page;
        // $this->detailsPropostas = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
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
        $startDate = '';
        $endDate = '';
        $statusProsposta = '';
        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$this->typeProposta,$startDate,$endDate,$statusProsposta);
 
        $this->detailsPropostas = $propostasArray["paginator"];
        $this->numberMaxPages = $propostasArray["nr_paginas"] + 1;
        $this->totalRecords = $propostasArray["nr_registos"];

    }
    public function updatedTypeProposta()
    {
        // $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
        // $this->detailsPropostas = $propostasArray["paginator"];

        $this->pageChosen = 1;
        $startDate = '';
        $endDate = '';
        $statusProsposta = '';
        $propostasArray = $this->clientesRepository->getPropostasClienteFiltro($this->perPage,$this->pageChosen,$this->idCliente,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,$this->estadoProposta,$this->typeProposta,$startDate,$endDate,$statusProsposta);
 
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

    public function detalhePropostaModal($proposta)
    {
      
        Session::put('rota','clientes.detail');
        Session::put('rotaTab','tabPropostas');
        Session::put('parametro',$this->idCliente);

        $propostasArray = $this->clientesRepository->getPropostasCliente($this->perPage,$this->pageChosen,$this->idCliente);
        $this->detailsPropostas = $propostasArray["paginator"];
        
        // dd($this->idCliente);
        // dd($proposta);
        foreach($this->detailsPropostas as $det)
        {
            if($det->id == $proposta["id"])
            {
                $propSend = $det;
                // dd($propSend);
            }
        }

        
        // dd($proposta);
        $proposta = (object) $proposta;
        Session::put('proposta',$proposta);

        return redirect()->route('propostas.proposta',["idProposta" => $proposta->id]);

        // $this->propostaID = $id;

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
    
       
        
    
        try {
             Mail::to(Auth::user()->email)->send(new SendProposta($pdfContent));
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Email enviado!", "status" => "success"]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('checkToaster', ["message" => $e->getMessage(), "status" => "warning"]);
        }

        $this->restartDetails();
    }

    public function render()
    {
   
  
        return view('livewire.clientes.propostas',["detalhesPropostas" => $this->detailsPropostas]);
    }
}
