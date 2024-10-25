<?php

namespace App\Http\Livewire\Encomendas;

use App\Mail\SendComentario;


use Dompdf\Dompdf;
use Livewire\Component;
use App\Models\Carrinho;
use App\Models\GrupoEmail;
use App\Mail\SendEncomenda;
use App\Models\Comentarios;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ComentariosProdutos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\ClientesInterface;
use Illuminate\Http\RedirectResponse;
use App\Interfaces\PropostasInterface;
use App\Interfaces\EncomendasInterface;
use Illuminate\Support\Facades\Session;

class EncomendaInfo extends Component
{
    use WithPagination;

    public $carrinhoCompras = [];
    private ?object $clientesRepository = null;
    private ?object $encomendasRepository = null;
    private ?object $propostasRepository = null;

    protected ?object $clientes = null;
    public string $addProductQuickBuy = "";

    private ?object $detailsClientes = null;
    private ?object $searchSubFamily = null;
    private ?object $getCategories = null;
    private ?object $getCategoriesAll = null;
    private ?object $products = null;
    public ?string $searchTextCategory = "";
    public bool $filter;
    public bool $familyInfo = false;

    public bool $showLoaderPrincipal = true;

    public string $tabDetail = "";
    public string $tabDetalhesEncomendas = "show active";
    

    public int $specificProduct = 0;
    public string $idFamilyInfo = "";

    public string $idSubFamilyRecuar = "";
    public string $idFamilyRecuar = "";
    public string $idCategoryRecuar = "";
    public $iteration = 0;

    public ?string $searchProduct = "";
    public ?string $actualCategory = "";
    public ?string $actualFamily = "";
    public ?string $actualSubFamily = "";

    protected ?object $quickBuyProducts = null;
    public $iterationQuickBuy = 0;

    private ?object $detailProduto = null;

    public $modalShow = false;

    public $iterationDelete = 0;


    /** PARTE DO FINALIZAR **/

    public $transportadora;
    public $viaturaSanipower;
    public $levantamentoLoja;
    public $observacaoFinalizar;
    public $referenciaFinalizar;

    public $lojaFinalizar;

    public $condicoesFinalizar;
    public $chequeFinalizar;
    public $pagamentoFinalizar;
    public $transferenciaFinalizar;

    public ?array $lojas = NULL;

    /******** */


    /** PARTE DA COMPRA */
    public $produtosRapida = [];
    public $produtosComment = [];

    /***** */

    protected ?object $encomenda = NULL;

    public int $perPage = 10;

    public ?object $comentario = NULL;
    public ?object $firstComentario = NULL;

    public $comentarioEncomenda = "";

    public $emailArray;
    public $emailSend;


    public $encomendaComentarioId;
   

    public function boot(ClientesInterface $clientesRepository, EncomendasInterface $encomendasRepository, PropostasInterface $propostasRepository)
    {
        $this->clientesRepository = $clientesRepository;
        $this->encomendasRepository = $encomendasRepository;
        $this->propostasRepository = $propostasRepository;
    }

    public function initProperties()
    {
        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }

        
    }

    public function mount($encomenda)
    {   
        // dd($encomenda);
        $this->initProperties();
        $this->encomenda = $encomenda;
        
        $encomendas = $this->clientesRepository->getEncomendaID($encomenda->id);
        //  dd($encomenda);
        if (property_exists($encomendas, 'orders') && isset($encomendas->orders[0])) {
            Session::put('encomendaINFO', $encomendas->orders[0]);
        } else {
            session()->put('encomendaINFO', $this->encomenda);
        }
        
    
        $this->specificProduct = 0;
        $this->filter = false;

        $this->showLoaderPrincipal = true;
    }

    public function openComentario($idEncomenda)
    {
        $this->encomendaComentarioId = $idEncomenda;

        $this->tabDetail = "show active";
        $this->tabDetalhesEncomendas = "";

        $this->dispatchBrowserEvent('openComentario');
    }

    public function sendComentario($idEncomenda)
    {   
        $encomendas = $this->clientesRepository->getEncomendaID($idEncomenda);
        // dd($encomendas);
        if (empty($this->comentarioEncomenda)) {
            $message = "O campo de comentário está vazio!";
            $status = "error";
        } else {
            $response = $this->clientesRepository->sendComentarios($idEncomenda, $this->comentarioEncomenda, "encomendas");
     
            $responseArray = $response->getData(true);
        
            if ($responseArray["success"] == true) {
            
                $message = "Comentário adicionado com sucesso!";
                $status = "success";
                if (property_exists($encomendas, 'orders') && isset($encomendas->orders[0])) {
                    $grupos = GrupoEmail::where('local_funcionamento', 'comentarios_encomendas')->get();
                    if(isset($grupos)){
                        $this->emailArray = [];
                        foreach ($grupos as $grupo) {
                            $emails = array_map('trim', explode(',', $grupo->emails));
                            
                            $this->emailArray = array_merge($this->emailArray, $emails);
                        }
                        // array_push($this->emailArray,Auth::user()->email);
                    
                        $this->emailArray = array_unique($this->emailArray);

                        foreach($this->emailArray as $i => $email)
                        {
                            Mail::to($email)->send(new SendComentario($encomendas, $this->comentarioEncomenda));
                        }
                    }
                }
            } else {
                $message = "Não foi possível adicionar o comentário!";
                $status = "error";
            }
        } 
        // dd($idEncomenda);
        
        // Session::put('encomendaINFO',$encomendas->orders[0]);
        if (property_exists($encomendas, 'orders') && isset($encomendas->orders[0])) {
            Session::put('encomendaINFO', $encomendas->orders[0]);
        } else {
            $message = "Comentário não salvo, Encomenda está fechada!";
            $status = "error";
            $this->dispatchBrowserEvent('checkToaster', ["message" => $message, "status" => $status]);
            return;
        }
        // Reinicia os detalhes da encomenda
        $this->comentarioEncomenda = "";
        // Exibe a mensagem usando o evento do navegador
        $this->dispatchBrowserEvent('checkToaster', ["message" => $message, "status" => $status]);
    }

    public function gerarPdfProposta($encomenda)
    {

        if (!$encomenda) {
            return redirect()->back()->with('error', 'Proposta não encontrada.');
        }

        $pdf = PDF::loadView('pdf.pdfTabelaEncomenda', ["encomenda" => json_encode($encomenda)]);
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'pdfTabelaEncomendas.pdf');
    }

    public function enviarEmail($encomenda)
    {

        

        $emailArray = explode("; ", $encomenda["email"]);

        $this->emailArray = $emailArray;

        array_push($this->emailArray,Auth::user()->email);
        
        $this->dispatchBrowserEvent('chooseEmail');

    }

    public function enviarEmailClientes($encomenda)
    {
       

        if (!$encomenda) {
            dd("Não há valor na variável \$encomenda");
            return redirect()->back()->with('error', 'Encomenda não encontrada.');
        }
    
        $pdf = new Dompdf();
        $pdf = PDF::loadView('pdf.pdfTabelaEncomenda', ["encomenda" => json_encode($encomenda)]);
    
        $pdf->render();
    
        $pdfContent = $pdf->output();
    
        
   
        foreach($this->emailArray as $i => $email)
        {
            if(isset($this->emailSend[$i]))
            {
                if($this->emailSend[$i] == true)
                {
                    // dd(json_encode($encomenda));
                    Mail::to($email)->send(new SendEncomenda($pdfContent, $encomenda));
                }
            }
           
        }

        $this->emailArray = [];

        $this->dispatchBrowserEvent('checkToaster', ["message" => "Email enviado!", "status" => "success"]);
        
    }

    public function goBack()
    {
        $rota = Session::get('rota');
        $rota = Session::get('rota');
        $parametro = Session::get('parametro');
     
        if($rota != "")
        {
            
            if($parametro != "")
            {
                return redirect()->route($rota,$parametro);
            }

            return redirect()->route($rota);

        
        }
        
    }
       
    
    public function render()
    {
        $encomenda = session('encomendaINFO');
        $comentario = Comentarios::with('user')->where('stamp', $encomenda->id)->where('tipo', 'encomendas')->orderBy('id','DESC')->skip(env('COMENTARIO_NUMBER'))->take(PHP_INT_MAX)->get();

        $this->firstComentario = Comentarios::with('user')->where('stamp', $encomenda->id)->where('tipo', 'encomendas')->orderBy('id','DESC')->take(env('COMENTARIO_NUMBER'))->get();
    
        $this->comentario = $comentario;

        foreach ($encomenda->lines as $prod){
             $image_ref = "https://storage.sanipower.pt/storage/produtos/".$prod->family_number."/".$prod->family_number."-".$prod->subfamily_number."-".$prod->product_number.".jpg";
             $prod->image_ref = $image_ref;
        }
        $imagens = [];
        foreach($encomenda->lines as $carrinho){
            array_push($imagens,$carrinho->image_ref);
        }
        
        $iamgens_unique = array_unique($imagens);


        $arrayCart = [];

        foreach ($iamgens_unique as $img) {
            $arrayCart[$img] = [];
            foreach ($encomenda->lines as $cart) {
                if ($img == $cart->image_ref) {
                    $found = false;
                    foreach ($arrayCart[$img] as &$item) {
                        
                        if ($item->reference == $cart->reference) {
                            if(isset($cart->qtd)) {
                                if (is_numeric($item->qtd) && is_numeric($cart->qtd)) {
                                    $item->qtd += $cart->qtd;
                                } else {
                                    break;
                                }
                                $found = true;
                                break;
                            }
                        }
                    }
                    if (!$found) {
                        array_push($arrayCart[$img], $cart);
                    }
                }
            }
        }
        return view('livewire.encomendas.encomenda-info',["encomenda" => $encomenda,"arrayCart" =>$arrayCart]);
    }
}
