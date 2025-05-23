<?php

namespace App\Http\Livewire\Ocorrencias;

use App\Mail\SendComentario;

use Dompdf\Dompdf;
use Livewire\Component;
use App\Models\Carrinho;
use App\Models\Anexos;
use App\Models\GrupoEmail;
use App\Mail\SendProposta;
use App\Models\Comentarios;
use Livewire\WithPagination;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ComentariosProdutos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Interfaces\ClientesInterface;
use App\Interfaces\PropostasInterface;


use Illuminate\Queue\SerializesModels;
use App\Interfaces\EncomendasInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class OcorrenciaInfo extends Component
{
    use WithPagination ;


    public $carrinhoCompras = [];
    private ?object $clientesRepository = null;
    private ?object $encomendasRepository = null;
    private ?object $PropostasRepository = null;

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
    public string $tabLine = "";
    public string $tabProdutos = "";
    public string $tabDetalhesOcorrencias = "show active";
    public string $tabFinalizar = "";
    public string $tabDetalhesCampanhas = "";

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
    public $checkBoxTrue = true;


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

    public ?array $produtosRapida = [];
    public $produtosComment = [];
    public $selectedItemsAdjudicar = [];
    public $anexos = [];
    

    /***** */

    private ?object $ocorrencia = NULL;

    public int $perPage = 10;

    public ?object $comentario = NULL;
    public ?object $firstComentario = NULL;

    public $comentarioEncomenda = "";

    public $emailArray;
    public $emailSend;


    public function boot(ClientesInterface $clientesRepository, EncomendasInterface $encomendasRepository, PropostasInterface $PropostasRepository)
    {
        $this->clientesRepository = $clientesRepository;
        $this->encomendasRepository = $encomendasRepository;
        $this->PropostasRepository = $PropostasRepository;
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

    public function mount($ocorrencia)
    {
        // dd($ocorrencia);
        if(session('tabDetail') != '')
        {
            $this->tabDetail = 'show active';
            $this->tabDetalhesOcorrencias = '';
        }
        session()->put('tabDetail', '');
        Session::put('tabDetail', '');
        $this->initProperties();
        $this->ocorrencia = $ocorrencia;

        $Anexos = Anexos::where('idOcorrencia',$ocorrencia->id)->first();

        if(isset($Anexos->anexo))
        {
            $this->anexos = $Anexos->anexo;
            $this->anexos = json_decode($this->anexos);
        }
        Session::put('OcorrenciasAnexos', $this->anexos);
        
    }

    public function goBack()
    {
        $rota = Session::get('rota');
        $parametro = Session::get('parametro');
        // dd($rota, $parametro);
        
        if($rota == "ocorrencias.ocorrencia"){
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
        }else
        {
            return redirect()->route('ocorrencias');
        }
    }

    public function render()
    {
        $ocorrencia = session('ocorrencia');
        
        $this->ocorrencia = session()->get('ocorrencia');

        if(session('OcorrenciasAnexos')){
            $this->anexos = session('OcorrenciasAnexos');
        }

        return view('livewire.ocorrencias.ocorrencia-info',["ocorrencia" => $ocorrencia]);

    }
}
