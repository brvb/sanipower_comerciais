<?php

namespace App\Http\Livewire\Propostas;

use DateTime;
use stdClass;
use Dompdf\Dompdf;
use Livewire\Component;
use App\Models\Carrinho;
use App\Mail\SendProposta;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ComentariosProdutos;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\ClientesInterface;
use App\Interfaces\PropostasInterface;
use App\Interfaces\EncomendasInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Campanhas;
use App\Models\GrupoEmail;
use App\Models\ProdutosDB;
use App\Mail\SendAprovacao;




class DetalheProposta extends Component
{
    use WithPagination; 

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
    public $codvisita = null;

    public bool $showLoaderPrincipal = true;

    public $selectedItemsAddKit = [];
    public $selectedItemsRemoveKit = [];
    public $valueIvaInKit = 0;


    public string $tabDetail = "";
    public string $tabProdutos = "show active";
    public string $tabDetalhesPropostas = "";
    public string $tabFinalizar = "";
    public string $tabDetalhesCampanhas = "";

    public int $specificProduct = 0;
    public string $idFamilyInfo = "";
    public string $idCategoryInfo = "";


    public string $idSubFamilyRecuar = "";
    public string $idFamilyRecuar = "";
    public string $idCategoryRecuar = "";
    public $iteration = 0;

    public ?string $searchProduct = "";
    public ?string $actualCategory = "";
    public ?string $actualFamily = "";
    public ?string $actualSubFamily = "";


    public ?string $nomeCliente = '';
    public ?string $numeroCliente = '';
    public ?string $zonaCliente = '';
    public ?string $telemovelCliente = '';
    public ?string $emailCliente = '';
    public ?string $nifCliente = '';
    public $startDate = '';
    public $endDate = '';
    public int $statusProposta = 0;

    protected ?object $quickBuyProducts = null;
    public $iterationQuickBuy = 0;

    public int $quantidadeLines = 0;

    private ?object $detailProduto = null;

    public $modalShow = false;

    public $iterationDelete = 0;

    /** PARTE DO FINALIZAR **/

    public $transportadora;
    public $viaturaSanipower;
    public $levantamentoLoja;
    public $observacaoFinalizar = "";
    public $observacaoFinalizarPDF = "";
    public $referenciaFinalizar = "";
    public $validadeProposta;

    public $lojaFinalizar;

    public $condicoesFinalizar;
    public $chequeFinalizar;
    public $pagamentoFinalizar;
    public $transferenciaFinalizar;

    public $enviarCliente;

    public $enviarClienteBool = false;

    public $enviarAprovacao;
    public $emailArray;
    public $emailSend;
    public $visitaCheck;
    public $prodtQTD = [];
    public $isMobile = false;

    public ?array $lojas = NULL;

    /******** */

    /** PARTE DA COMPRA */

    public ?array $produtosRapida = [];
    public $produtosComment = [];
    

    /***** */

    public $kitCheck;

    public int $perPage = 10;
    protected $listeners = ["rechargeFamily" => "rechargeFamily", "cleanModal" => "cleanModal",'setIsMobile'];

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

    public function mount($codvisita, $cliente, $codEncomenda)
    {
        if(session('Camp1') != 1)
        {
            session(['Camp' => 0]);
            $this->searchProduct = "";
            session(['searchProduct' => null]);
            session(['searchNameCategory' => ""]);
            session(['searchNameFamily' => ""]);
            session(['searchNameSubFamily' => ""]);
            session(['Category' => null]);
            session(['Family' => null]);
            $this->specificProduct = 0;
            session(['specificProduct' => $this->specificProduct]);
        }
        $this->initProperties();
        $this->idCliente = $cliente;
        $this->codEncomenda = $codEncomenda;
        $this->codvisita = $codvisita;

        $this->specificProduct = 0;
        $this->filter = false;
        if($this->validadeProposta == null){
            $dataIndicada = new DateTime();
            $this->validadeProposta = $dataIndicada->modify('+8 days');
            $this->validadeProposta = $dataIndicada->format('d-m-Y');
        }

        $this->showLoaderPrincipal = true;
    }
    public function setIsMobile($isMobile)
    {
        $this->isMobile = $isMobile;
    }
    public function rechargeFamily($id)
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        // $this->getCategories = $this->PropostasRepository->getCategorias();
        $this->getCategoriesAll = $this->PropostasRepository->getCategorias();

        $this->searchProduct = "";
        $this->familyInfo = false;
        $this->dispatchBrowserEvent('refreshComponent', ["id" => $id]);
    }

    public function openDetailProduto($idCategory, $idFamily, $idSubFamily, $productNumber, $idCustomer, $productName)
    {
        $this->specificProduct = 1;
        session(['specificProduct' => $this->specificProduct]);

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesPropostas = "";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";

        $this->idCategoryRecuar = $idCategory;
        $this->idFamilyRecuar = $idFamily;
        $this->idSubFamilyRecuar = $idSubFamily;

        $this->detailProduto = $this->PropostasRepository->getProdutos($idCategory, $idFamily, $idSubFamily, $productNumber, $idCustomer);
    
        session(['quickBuyProducts' => $this->detailProduto]);

        session(['detailProduto' => $this->detailProduto]);
        session(['productNameDetail' => $productName]);

        session(['family' => $idFamily]);
        session(['subFamily' => $idSubFamily]);
        session(['productNumber' => $productNumber]);

        $this->filter = false;
    }

    public function recuarLista()
    {
        $this->specificProduct = 0;
        // return redirect()->route('propostas.detail', ['id' => $this->idCliente]);
    }
    public function adicionarProduto($categoryNumber, $familyNumber, $subFamilyNumber, $productNumber, $customerNumber, $productName)
    {
        
        $this->quickBuyProducts = $this->PropostasRepository->getProdutos($categoryNumber, $familyNumber, $subFamilyNumber, $productNumber, $customerNumber);
        // dd($categoryNumber, $familyNumber, $subFamilyNumber, $productNumber, $customerNumber, $productName, $this->quickBuyProducts );
        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesPropostas = "";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";

        $this->specificProduct = 0;

        session(['quickBuyProducts' => $this->quickBuyProducts]);
        session(['productName' => $productName]);

        session(['detailProduto' => $this->detailProduto]);
        session(['productNameDetail' => $productName]);
        
        session(['family' => $familyNumber]);
        session(['subFamily' => $subFamilyNumber]);
        session(['productNumber' => $productNumber]);

        $this->produtosRapida = [];

        $this->dispatchBrowserEvent('compraRapida');
    }

    public function verEncomenda()
    {
        // Atualizar abas
        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesPropostas = "";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";

        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        // $this->getCategories = $this->PropostasRepository->getCategorias();
        $this->getCategoriesAll = $this->PropostasRepository->getCategorias();

        // Disparar evento para o navegador
        $this->dispatchBrowserEvent('encomendaAtual');
    }
    public function Limpar()
    {
        Carrinho::where('id_proposta', $this->codEncomenda)->where("id_user", Auth::user()->id)->delete();
        ComentariosProdutos::where('id_proposta', $this->codEncomenda)->where("id_user", Auth::user()->id)->delete();

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesPropostas = "show active";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";

        $this->quantidadeLines = 0;
    }
    public function cancelarProposta()
    {
        Carrinho::where('id_proposta', $this->codEncomenda)->where("id_user", Auth::user()->id)->delete();
        ComentariosProdutos::where('id_proposta', $this->codEncomenda)->where("id_user", Auth::user()->id)->delete();

        $rota = Session::get('rota');
        
        $parametro = Session::get('parametro');

        if($rota != "")
        {
            if($parametro != "")
            {   
                return redirect()->route($rota,$parametro);
            }
            return redirect()->route($rota);
        }else
        {
            return redirect()->route('propostas');
        }
    }
    public function delete($itemId)
    {
        Carrinho::where('id', $itemId)->delete();

        $this->dispatchBrowserEvent('itemDeleted', ['itemId' => $itemId]);

    }

    public function deletar($referencia,$designacao, $model, $price)
    {
        Carrinho::where('id_proposta', $this->codEncomenda)
                ->where('referencia', $referencia)
                ->where('designacao', $designacao)
                ->where('model', $model)
                ->where('price', $price)
        ->delete();

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesPropostas = "show active";
        $this->tabFinalizar = "";
    }


    public function deletartodos()
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        Carrinho::where('id_cliente', $this->detailsClientes->customers[0]->no)->where('id_user',Auth::user()->id)->delete();

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesPropostas = "show active";
        $this->tabFinalizar = "";
    }

    public function searchCategory($idCategory, $idFamily)
    {
        $this->getCategoriesAll = $this->PropostasRepository->getCategorias();

        // $this->getCategories = $this->PropostasRepository->getCategoriasSearched($this->getCategoriesAll->category[$idCategory - 1]->id, $idFamily);
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesPropostas = "";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";

        $this->searchProduct = "";
        //unset($_SESSION['searchProduct']);
        // session()->forget('searchProduct');

        $this->filter = true;
        $this->familyInfo = true;
        $this->idFamilyInfo = $idFamily;
        $this->idCategoryInfo = $idCategory;


        $this->showLoaderPrincipal = true;

        $this->specificProduct = 0;

        $this->iteration++;

        $this->dispatchBrowserEvent('refreshComponent', ["id" => $idCategory]);
    }

    public function addProdCamp($referense)
    {
        // $this->quickBuyProducts = $this->encomendasRepository->getProdutos($categoryNumber, $familyNumber, $subFamilyNumber, $productNumber, $customerNumber);

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesPropostas = "";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";

        $this->specificProduct = 0;

        // session(['quickBuyProducts' => $this->quickBuyProducts]);
        // session(['productName' => $productName]);

        // session(['detailProduto' => $this->detailProduto]);
        // session(['productNameDetail' => $productName]);

        // session(['family' => $familyNumber]);
        // session(['subFamily' => $subFamilyNumber]);
        // session(['productNumber' => $productNumber]);

        $this->produtosRapida = [];

        $this->dispatchBrowserEvent('compraRapida');

    }

    public function searchSubFamily($idCategory, $idFamily, $idSubFamily)
    {
        session(['Camp' => 1]);
        session(['Camp1' => 1]);
        session(['CampProds' => null]);
        $this->searchProduct = "";
        session(['Category' => null]);
        session(['Family' => null]);
        session(['searchProduct' => $this->searchProduct]);

        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        // $this->getCategories = $this->PropostasRepository->getCategorias();
        $this->getCategoriesAll = $this->PropostasRepository->getCategorias();
        $this->searchSubFamily = $this->PropostasRepository->getSubFamily($idCategory, $idFamily, $idSubFamily);

        $this->actualCategory = $idCategory;
        $this->actualFamily = $idFamily;
        $this->actualSubFamily = $idSubFamily;

        session(['searchSubFamily' => $this->searchSubFamily]);
        // dd($this->getCategories->category[]);
        foreach ($this->getCategoriesAll->category as $index => $idCtgry) {

            if ($idCtgry->id == $idCategory) {
                session(['searchNameCategory' => $idCtgry->name]);
                session(['CatID' => $idCategory]);
                foreach ($idCtgry->family as $idFmly) {
                    if ($idFmly->id === $idFamily) {
                        session(['searchNameFamily' => $idFmly->name]);
                        session(['FamilyID' => $idFamily]);

                        foreach ($idFmly->subfamily as $idSubFmly) {
                            if ($idSubFmly->id === $idSubFamily) {
                                session(['searchNameSubFamily' => $idSubFmly->name]);
                            }
                        }

                    }
                }

            }
        }

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesPropostas = "";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";

        $this->idCategoryRecuar = $idCategory;
        $this->idFamilyRecuar = $idFamily;
        $this->idSubFamilyRecuar = $idSubFamily;

        $this->filter = true;
        $this->familyInfo = true;

        $this->idFamilyInfo = "";
        $this->idCategoryInfo = "";


        $this->showLoaderPrincipal = true;

        $this->specificProduct = 0;
        session(['specificProduct' => $this->specificProduct]);

        $this->iteration++;

        return redirect()->route('propostas.detail', ['id' => $this->idCliente]);

        // $this->dispatchBrowserEvent('refreshPage');
        // $this->dispatchBrowserEvent('refreshAllComponent');

    }

    public function updatedSearchProduct()
    {

        $this->getCategoriesAll = $this->PropostasRepository->getCategorias();
        $this->getCategoriesAll = $this->PropostasRepository->getCategorias();
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        if ($this->searchProduct != "") {
            $this->searchSubFamily = $this->PropostasRepository->getSubFamilySearch($this->searchProduct);
           
            session(['searchSubFamily' => $this->searchSubFamily]);
            // dd($this->searchProduct , $this->searchSubFamily);

            session(['searchProduct' => $this->searchProduct]);
            $this->specificProduct = 0;
            session(['specificProduct' => $this->specificProduct]);
            session(['CampProds' => null]);
            session(['Category' => null]);
            session(['Family' => null]);
            session(['Camp' => 1]);
            session(['Camp1' => 1]);
        } else {
            $this->searchSubFamily = $this->PropostasRepository->getSubFamily($this->actualCategory, $this->actualFamily, $this->actualSubFamily);
            session(['searchSubFamily' => $this->searchSubFamily]);

            //unset($_SESSION['searchProduct']);
            session()->forget('searchProduct');

        }
        $this->showLoaderPrincipal = false;

        $this->specificProduct = 0;
        $this->iteration++;

        // $this->dispatchBrowserEvent('refreshAllComponent');

        return redirect()->route('propostas.detail', ['id' => $this->idCliente]);

    }

    public function GetprodCamp($bostamp)
    {
        // dd($bostamp);
        session(['Camp' => 1]);
        session(['Camp1' => 1]);
        session(['CampProds' => $bostamp]);
        return redirect()->route('propostas.detail', ['id' => $this->idCliente]);
    }

    public function ShowCampanhas()
    {
        // dd('AQUI');
        session(['Camp' => 0]);

        $this->searchProduct = "";
        session(['searchProduct' => null]);
        session(['searchNameCategory' => ""]);
        session(['searchNameFamily' => ""]);
        session(['searchNameSubFamily' => ""]);
        $this->specificProduct = 0;
        session(['specificProduct' => $this->specificProduct]);
        session(['Category' => null]);
        session(['Family' => null]);

        // $sessions = session()->all();
    
        // Exibe todas as sessões
        // dd($sessions); // Isso irá parar a execução e mostrar as sessões
    }

    public function ShowFamily($id)
    {
        // dd($id);
         session(['Category' => $id]);
         $this->getCategoriesAll = $this->PropostasRepository->getCategorias();
         foreach ($this->getCategoriesAll->category as $index => $idCtgry) {

            if ($idCtgry->id == $id) {
                session(['searchNameCategory' => $idCtgry->name]);
            }
        }
         session(['CatID' => $id]);
         $this->searchProduct = "";
         session(['searchProduct' => null]);
         session(['searchNameFamily' => ""]);
         session(['searchNameSubFamily' => ""]);
         $this->specificProduct = 0;
         session(['specificProduct' => $this->specificProduct]);
         session(['Camp' => 1]);
         session(['Camp1' => 1]);
         session(['CampProds' => null]);
         session(['Family' => null]);
         session(['searchProduct' => null]);
 
         // $sessions = session()->all();
     
         // Exibe todas as sessões
         // dd($sessions); // Isso irá parar a execução e mostrar as sessões
    }

    public function ShowSubFamily($id, $idCat)
    {
        $this->getCategoriesAll = $this->PropostasRepository->getCategorias();
        // dd($this->getCategories);
        foreach ($this->getCategoriesAll->category as $index => $idCtgry) {

            if ($idCtgry->id == $idCat) {
                session(['searchNameCategory' => $idCtgry->name]);
            }
            foreach ($idCtgry->family as $idFmly) {
                if ($idFmly->id === $id) {
                    session(['searchNameFamily' => $idFmly->name]);
                }
            }

        }

        //  dd($id, $idCat);
         session(['Family' => $id]);
         session(['CatID' => $idCat]);
         session(['FamilyID' => $id]);
         session(['Category' => null]);
         $this->searchProduct = "";
         session(['searchProduct' => null]);
         session(['searchNameSubFamily' => ""]);
         $this->specificProduct = 0;
         session(['specificProduct' => $this->specificProduct]);
         session(['Camp' => 1]);
         session(['Camp1' => 1]);
         session(['CampProds' => null]);
         session(['searchProduct' => null]);
 
         $sessions = session()->all();
     
         // Exibe todas as sessões
        //  dd($sessions); // Isso irá parar a execução e mostrar as sessões
    }

    public function resetFilter($idCategory)
    {
        // $this->getCategories = $this->PropostasRepository->getCategorias();
        $this->getCategoriesAll = $this->PropostasRepository->getCategorias();
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        $this->familyInfo = false;

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesPropostas = "";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";

        $this->specificProduct = 0;

        $this->showLoaderPrincipal = true;

        $this->dispatchBrowserEvent('refreshComponent2', ["id" => $this->getCategoriesAll->category[$idCategory - 1]->id]);
    }

    public function addProductQuickBuyEncomenda($prodID, $nameProduct, $no, $ref, $codEncomenda)
    {
        $quickBuyProducts = session('quickBuyProducts');

        $flag = 0;
        if(empty($this->produtosRapida[$prodID]))
        {
            $this->produtosRapida = [];
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
            return false;
        }

        $productChosen = [];
        $productChosenComment = [];

        foreach ($quickBuyProducts->product as $i => $prod) {
            if ($i == $prodID) {
                foreach ($this->produtosRapida as $j => $prodRap) {

                    if ($i == $j) {

                        if ($prodRap == "0" || $prodRap == "") {
                            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
                            $flag = 1;
                            break;
                        } else {

                            // if ($prod->in_stock == false) {
                            //     $this->dispatchBrowserEvent('checkToaster', ["message" => "Não existe quantidades em stock", "status" => "error"]);
                            //     $flag = 1;
                            //     break;
                            // }
                            $productChosen = ["product" => $prod, "quantidade" => $prodRap];
                        }
                    }
                }
                if($this->produtosComment){
                    foreach ($this->produtosComment as $j => $prodComm) {
                        if ($i == $j) {
                            $productChosenComment = ["comentario" => $prodComm];
                        }
                    }
                }
            }

            if ($flag == 1) {
                break;
            }

        }

        if ($flag == 1) {
            return false;
        }

        $response = $this->encomendasRepository->addProductToDatabase($this->codvisita,$this->idCliente, $productChosen, $nameProduct, $no, $ref, $codEncomenda,"encomenda");
        
        $responseArray = $response->getData(true);

        if ($responseArray["success"] == true) {
            if($this->produtosComment){
                $response = $this->encomendasRepository->addCommentToDatabase($responseArray["data"]["id"],$this->idCliente, $productChosen, $nameProduct, $no, $ref, $codEncomenda,"encomenda", $productChosenComment["comentario"]);
                $this->produtosComment = [];
            }
            if($responseArray["encomenda"] != "") {
                $message = "Produto adicionado á encomenda!";
            } else {
                $message = "Produto adicionado á proposta!";
            }
            $status = "success";
        } else {
            $message = "Não foi possivel adicionar o produto!";
            $status = "error";
        }
        $this->produtosRapida = [];
        $this->produtosComment = [];

        $this->dispatchBrowserEvent('checkToaster', ["message" => $message, "status" => $status]);
    }
    public function editProductQuickBuyProposta($prodID, $referense, $nameProduct, $no, $ref, $codEncomenda, $price)
    {
        $quickBuyProducts = session('quickBuyProducts');
        // dd($prodID, $nameProduct, $no, $ref, $codEncomenda, $this->produtosRapida, $this->prodtQTD, $this->codvisita, $this->idCliente,$price);
        if( $this->prodtQTD != null )
        {
            $this->produtosRapida[$prodID] = $this->prodtQTD[$prodID];
            // dd($this->produtosRapida);
        }

        $flag = 0;
        if(empty($this->produtosRapida[$prodID]))
        {
            $this->produtosRapida = [];
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
            return false;
        }
        
        $productChosen = [];
        $productChosenComment = [];
        // dd($prodID, $nameProduct, $no, $ref, $codEncomenda, $this->produtosRapida, $this->prodtQTD, $this->codvisita, $this->idCliente);

        // dd($quickBuyProducts->product);
        foreach ($quickBuyProducts->product as $i => $prod) {
            if ($i == $prodID) {
                foreach ($this->produtosRapida as $j => $prodRap) {

                    if ($i == $j) {

                        if ($prodRap == "0" || $prodRap == "") {
                            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
                            $flag = 1;
                            break;
                        } else {
                            $productChosen = ["product" => $prod, "quantidade" => $prodRap];
                        }
                    }
                }
                if($this->produtosComment){
                    foreach ($this->produtosComment as $j => $prodComm) {
                        if ($i == $j) {
                            $productChosenComment = ["comentario" => $prodComm];
                        }
                    }
                }
            }

            if ($flag == 1) {
                break;
            }

        }
        if ($flag == 1) {
            return false;
        }

        if( $this->prodtQTD != null )
        {
            // dd($productChosen);
            // dd('id_encomenda', $codEncomenda, 'referencia', $productChosen['product']->referense, 'designacao', $nameProduct, 'model', $productChosen['product']->model, 'price', $productChosen['product']->price);
            // $price = $productChosen['product']->price;
            $itensSemProposta = Carrinho::where('id_proposta', $codEncomenda)
                ->where('referencia', $referense)
                ->where('price', $price)
                ->where('designacao', $nameProduct)
                ->where('id_proposta', '')
                ->get();
            if ($itensSemProposta->count() > 1) {
                // Inicializa a variável para consolidar os dados
                $quantidadeTotal = 0;
                $primeiroItem = null;
            
                foreach ($itensSemProposta as $index => $item) {
                    if ($index === 0) {
                        // O primeiro item será usado como base para consolidar os dados
                        $primeiroItem = $item;
                    } else {
                        // Somar a quantidade dos demais itens
                        $quantidadeTotal += $item->qtd;
            
                        // Remover o item extra
                        $item->delete();
                    }
                }
            
                // Atualiza o primeiro item com a quantidade total consolidada
                if ($primeiroItem) {
                    $primeiroItem->qtd += $quantidadeTotal;
                    $primeiroItem->save();
                }
            }
            $itemAtualizado = Carrinho::updateOrCreate(
            [
                'id_proposta' => $codEncomenda,
                'referencia' => $referense,
                'designacao' => $nameProduct,
                'price' => $price,
            ],
            [
                'qtd' => $this->produtosRapida[$prodID],
            ]
            );
            // $itemAtualizado = Carrinho::updateOrCreate(
            // [
            //     'id_proposta' => $codEncomenda,
            //     'referencia' => $productChosen['product']->referense,
            //     'model' => $productChosen['product']->model,
            //     'price' => $price,
            // ],
            // [
            //     'qtd' => $this->produtosRapida[$prodID],
            // ]
            // );

            // // Remover itens duplicados, exceto o que foi atualizado
            // Carrinho::where('id_proposta', $codEncomenda)
            // ->where('referencia', $productChosen['product']->referense)
            // ->where('model', $productChosen['product']->model)
            // ->where('price', $price)
            // ->where('id', '!=', $itemAtualizado->id)
            // ->delete();

            // Resetar a quantidade local (se necessário)
            $this->prodtQTD = null;
          
        }
               
        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesPropostas = "show active";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";
        // dd($this->codvisita, $this->idCliente, $productChosen, $nameProduct, $no, $ref, $codEncomenda,"encomenda");

        // $response = $this->encomendasRepository->addProductToDatabase($this->codvisita, $this->idCliente, $productChosen, $nameProduct, $no, $ref, $codEncomenda,"encomenda");

        // $responseArray = $response->getData(true);

        

        // if ($responseArray["success"] == true) {
    
        //     if($this->produtosComment){
        //         $response = $this->encomendasRepository->addCommentToDatabase($responseArray["data"]["id"],$this->idCliente, $productChosen, $nameProduct, $no, $ref, $codEncomenda,"encomenda", $productChosenComment["comentario"]);
        //         $this->produtosComment = [];
        //     }

        //     if($responseArray["encomenda"] != "") {
        //         $message = "Produto adicionado á encomenda!";
        //     } else {
        //         $message = "Produto adicionado á proposta!";
        //     }
        //     $status = "success";
        // } else {
        //     $message = "Não foi possivel adicionar o produto!";
        //     $status = "error";
        // }
        // $this->produtosRapida = [];
        // $this->produtosComment = [];
        
        // $this->dispatchBrowserEvent('checkToaster', ["message" => $message, "status" => $status]);
    }
    public function addProductQuickBuyProposta($prodID, $nameProduct, $no, $ref, $codProposta)
    {
        $quickBuyProducts = session('quickBuyProducts');

        $flag = 0;
        if(empty($this->produtosRapida[$prodID]))
        {
            $this->produtosRapida = [];
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
            return false;
        }

        $productChosen = [];
        $productChosenComment = [];


        foreach ($quickBuyProducts->product as $i => $prod) {
            if ($i == $prodID) {
                foreach ($this->produtosRapida as $j => $prodRap) {

                    if ($i == $j) {

                        if ($prodRap == "0" || $prodRap == "") {
                            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
                            $flag = 1;
                            break;
                        } else {

                            // if ($prod->in_stock == false) {
                            //     $this->dispatchBrowserEvent('checkToaster', ["message" => "Não existe quantidades em stock", "status" => "error"]);
                            //     $flag = 1;
                            //     break;
                            // }
                            $productChosen = ["product" => $prod, "quantidade" => $prodRap];
                        }
                    }
                }
                if($this->produtosComment){
                    foreach ($this->produtosComment as $j => $prodComm) {
                        if ($i == $j) {
                            $productChosenComment = ["comentario" => $prodComm];
                        }
                    }
                }
            }

            if ($flag == 1) {
                break;
            }

        }

        if ($flag == 1) {
            return false;
        }
        $response = $this->PropostasRepository->addProductToDatabase($this->codvisita, $this->idCliente, $productChosen, $nameProduct, $no, $ref, $codProposta, "proposta");

        $responseArray = $response->getData(true);

        if ($responseArray["success"] == true) {
            if($this->produtosComment){
                $response = $this->PropostasRepository->addCommentToDatabase($responseArray["data"]["id"],$this->idCliente, $productChosen, $nameProduct, $no, $ref, $codProposta,"proposta", $productChosenComment["comentario"]);
                $this->produtosComment = [];
            }
            if($responseArray["encomenda"] != "") {
                $message = "Produto adicionado á encomenda!";
            } else {
                $message = "Produto adicionado á proposta!";
            }
            $status = "success";
        } else {
            $message = "Não foi possivel adicionar o produto!";
            $status = "error";
        }
        $this->produtosRapida = [];
        $this->produtosComment = [];

        $this->dispatchBrowserEvent('checkToaster', ["message" => $message, "status" => $status]);
    }

    public function CleanAll()
    {
        $this->produtosRapida = [];
        $this->produtosComment = [];
    }
    public function addAll($nameProduct,$no, $ref ,$codEncomenda)
    {
        $quickBuyProducts = session('quickBuyProducts');

        $productChosen = [];
        $productChosenComment = [];
        $count = 0;

        if (empty($this->produtosRapida)) {
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
            return false;
        }

        foreach ($quickBuyProducts->product as $i => $prod) {
            foreach ($this->produtosRapida as $j => $prodRap) {
                if ($i == $j) {
                    if ($prodRap != "0" && $prodRap != "") {
                        // if ($prod->in_stock == true) {
                            $productChosen[$count] = [
                                "product" => $prod,
                                "quantidade" => $prodRap,
                            ];

                            $count++;
                        // }

                    }else  if ($prodRap == "0") {
                        $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
                        return false;
                    }
                }
            }
            foreach ($this->produtosComment as $j => $prodComm) {
                if ($i == $j) {
                    if ($prodComm != "0" && $prodComm != "") {
                        if ($prod->in_stock == true) {
                            $productChosenComment[$count] = [
                                "product" => $prod,
                                "comentario" => $prodComm,
                            ];
                            $count++;
                        }
                    }else  if ($prodComm == "0") {
                        $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
                        return false;
                    }
                }
            }
        }

        $response = [];


        foreach($productChosen as $prodId){
            $response = $this->PropostasRepository->addProductToDatabase($this->codvisita, $this->idCliente,$prodId,$nameProduct,$no,$ref,$codEncomenda, "proposta");
            
            $responseArray = $response->getData(true);

            foreach($productChosenComment as $comeProd){
               
                if(($prodId["product"]->referense == $comeProd["product"]->referense) && ($prodId["product"]->model == $comeProd["product"]->model) && ($prodId["product"]->price == $comeProd["product"]->price))
                {
                    $response = $this->PropostasRepository->addCommentToDatabase($responseArray["data"]["id"], $this->idCliente, $prodId, $nameProduct, $no, $ref, $codEncomenda,"proposta", $comeProd["comentario"]);
                }
            }
          

        }

        // foreach($productChosenComment as $prodId){
        //     $response = $this->PropostasRepository->addCommentToDatabase($this->idCliente, $prodId, $nameProduct, $no, $ref, $codEncomenda,"proposta", $prodId["comentario"]);
        // }
        if($response){
            $responseArray = $response->getData(true);
        }else{
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
            return false;
        }

        if ($responseArray["success"] == true) {
            $message = "Produto adicionado á proposta!";
            $status = "success";
        } else {
            $message = "Não foi possivel adicionar o produto!";
            $status = "error";
        }
        $this->produtosRapida = [];
        $this->produtosComment = [];

        $this->dispatchBrowserEvent('checkToaster', ["message" => $message, "status" => $status]);

    }

    public function cleanModal()
    {
        $this->produtosRapida = [];
        $this->produtosComment = [];

        $this->dispatchBrowserEvent('compraRapida');

        $this->skipRender();
    }

    public function finalizarencomenda()
    {
        // public $transportadora;
        // public $viaturaSanipower;
        // public $levantamentoLoja;
        // public $observacaoFinalizar;
        // public $referenciaFinalizar;
    
        // public $lojaFinalizar;
    
        // public $condicoesFinalizar;
        // public $chequeFinalizar;
        // public $pagamentoFinalizar;
        // public $transferenciaFinalizar;

        //FAZER VALIDAÇÃO PARA ESTES AQUI DE CIMA

        dd("finaliza");
        $arrayProdutos = [];

        $valorTotal = 0;
        $valorTotalComIva = 0;
        $count = 0;
    
        foreach($this->carrinhoCompras as $prod)
        {
            $count++;

            $totalItem = $prod->price * $prod->qtd;
            $totalItemComIva = $totalItem + ($totalItem * ($prod->iva / 100));
            $valorTotal += $totalItem;
            $valorTotalComIva += $totalItemComIva;




            $arrayProdutos[$count] = [
                "linha_id" => $count,
                "ref" => $prod->referencia,
                "design" => $prod->designacao,
                "qtt" => $prod->qtd,
                "iva" => $prod->iva,
                "ivaincl" => false,
                "edebito" => "",
                "desconto" => $prod->discount,
                "desc2" => "",
                "desc3" => "",
                "ettdeb" => "",
                "notas" => "sample string 12"
            ];
        }

        

        $array = [
                    "data" => date('Y-m-d'), 
                    "no" => $this->carrinhoCompras[0]->id_encomenda,
                    "etotal_siva" => number_format($valorTotal, 2, ',', '.'),
                    "etotal" => number_format($valorTotalComIva, 2, ',', '.'),
                    "referencia" => $this->referenciaFinalizar,
                    "observacoes" => $this->observacaoFinalizar,
                    "entrega" => "sample string 9",
                    "loja" => "sample string 10",
                    "pagamento" => "sample string 11",
                    "vendedor_id" =>  Auth::user()->id_phc, 
                    "produtos" => $arrayProdutos
        ];
              
        
        $encoded_finalizar = json_encode($array);

        dd($encoded_finalizar);


    }
    public function AdicionarItemKit()
    {
        $selectedProductIds = array_keys(array_filter($this->selectedItemsAddKit));
        $codEncomenda = $this->codEncomenda;
        foreach ($selectedProductIds as $itemId) {
            $selectedItemsArray = json_decode($itemId, true);

            $designacao = $selectedItemsArray[2];
            $designacao = str_replace('£', '.', $designacao);

            $referencia = $selectedItemsArray[1];
            $referencia = str_replace('£', '.', $referencia);

            $novosValores = [
                'inkit' => 1,
            ];
            Carrinho::where('id_proposta', $codEncomenda)
                                ->where('referencia', $referencia)
                                ->where('designacao', $designacao)
                                ->update($novosValores);
        }

        $this->selectedItems = [];

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesPropostas = "show active";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";
        $this->dispatchBrowserEvent('checkToaster');
    }
    public function RemoverItemKit()
    {
        $selectedProductIds = array_keys(array_filter($this->selectedItemsRemoveKit));
        $codEncomenda = $this->codEncomenda;
        
        foreach ($selectedProductIds as $itemId) {
            $selectedItemsArray = json_decode($itemId, true);

            $designacao = $selectedItemsArray[2];
            $designacao = str_replace('£', '.', $designacao);

            $referencia = $selectedItemsArray[1];
            $referencia = str_replace('£', '.', $referencia);

            $novosValores = [
                'inkit' => 0,
                'iva2' => 0,

            ];
            Carrinho::where('id_proposta', $codEncomenda)
                                ->where('referencia', $referencia)
                                ->where('designacao', $designacao)
                                ->update($novosValores);
        }

        $this->selectedItems = [];

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesPropostas = "show active";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";
        $this->dispatchBrowserEvent('checkToaster');
    }
    
    public function ivaInKit()
    {
    
        $codEncomenda = $this->codEncomenda;
        $valueIvaInKit = $this->valueIvaInKit;
        $novosValores = [
            'iva2' => intval($valueIvaInKit),
        ];
        Carrinho::where('id_proposta', $codEncomenda)
        ->where('inKit', 1)
        ->update($novosValores);
        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesPropostas = "show active";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";
    }

    public function updatedKitCheck()
    {
        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesPropostas = "show active";
        $this->tabFinalizar = "";
        $this->tabDetalhesCampanhas = "";
    }

    public function goBack()
    {
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

    public function voltarAtras()
    {
        // $this->dispatchBrowserEvent('changeRoute');

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

    public function enviarEmail()
    { 
        $EmailForeach = $this->emailArray;
        $this->emailArray = [];
        foreach($EmailForeach as $i => $email)
        {
            $emailParts = explode(" - ", $email);
            $emailAddress = $emailParts[0];
            if(isset($this->emailSend[$i]))
            {
                if($this->emailSend[$i] == true)
                {
                    // Mail::to($emailAddress)->send(new SendProposta($pdfContent, $proposta['budget']));
                    array_push($this->emailArray, $emailAddress);
                }
            }
        }
        $this->enviarClienteBool = true;
        $this->enviarCliente = false;
        $this->finalizarproposta();
        // dd($this->emailArray);
    }

    public function finalizarproposta()
    {
        if($this->enviarCliente == true)
        {
            $emailCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
            $this->emailArray = explode("; ", $emailCliente["object"]->customers[0]->email);
            $this->emailArray = array_map(function($email) {
                return $email . " - Cliente";
            }, $this->emailArray);
    
            // array_push($this->emailArray, Auth::user()->email . " - Utilizador");
            
            // dd($emailArray);
    
    
            $this->dispatchBrowserEvent('chooseEmail');
        } else{
        $count = 0;
        $valorTotal = 0;
        $valorTotalComIva = 0;
       

        $idCliente = "";
        // dd($this->carrinhoCompras);
        foreach($this->carrinhoCompras as $prod)
        {
            $count++;

            $idCliente = $prod->id_cliente;


            $totalItem = $prod->price * $prod->qtd;
            $totalItemComIva = $totalItem + ($totalItem * ($prod->iva / 100));
            $valorTotal += $totalItem;
            $valorTotalComIva += $totalItemComIva;

            $comentarioCheck = ComentariosProdutos::where('id_proposta', $this->codEncomenda)
            ->where('tipo','proposta')
            ->where('id_carrinho_compras', $prod->id)
            ->first();

            if(empty($comentarioCheck))
            {
                $comentario = "";
            } else {
                $comentario = $comentarioCheck->comentario;
            }
            
            if($prod->id_visita == null)
            {
                $visitaCheck = 0;
                $this->visitaCheck =  0;
            } 
            else {
                $visitaCheck = $prod->id_visita;
                $this->visitaCheck = $visitaCheck;
            }
            // dd( $prod);
            $arrayProdutos[$count] = [
                "id" => $count,
                "reference" => $prod->referencia,
                "description" => $prod->designacao,
                "quantity" => $prod->qtd,
                "tax" => $prod->iva,
                "tax_included" => false,
                "pvp" => $prod->pvp,
                "price" => $prod->price,
                "discount1" => $prod->discount,
                "discount2" => $prod->discount2,
                "discount3" => 0,
                "total" => $totalItem,
                "notes" => $comentario,
                "visit_id" => $visitaCheck,
                "budgets_id" => ""
            ];
        }
        if ($count <= 0){
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Não foi selecionado artigos!", "status" => "error"]);
            return false;
        }
       
        $randomNumber = '';
        for ($i = 0; $i < 8; $i++) {
            $randomNumber .= rand(0, 9);
        }

        // dd($arrayProdutos, $randomNumber);
        $condicaoPagamento = "";

        // if($this->transferenciaFinalizar == true)
        // {
        //     $condicaoPagamento = "Transferência Bancária";
        // }
        // if($this->pagamentoFinalizar == true)
        // {
        //     $condicaoPagamento = "Pronto Pagamento";
        // }
        // if($this->chequeFinalizar == true)
        // {
        //     $condicaoPagamento = "Cheque a 30 dias";
        // }
        // if($this->condicoesFinalizar == true)
        // {
        //     $condicaoPagamento = "Condições acordadas";
        // }
       

        // if($condicaoPagamento == "")
        // {
        //     $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma condição de pagamento", "status" => "error"]);
        //     return false;
        // }

        if (new DateTime($this->validadeProposta) < new DateTime('today')) {
            $this->tabDetail = "";
            $this->tabProdutos = "";
            $this->tabDetalhesPropostas = "";
            $this->tabFinalizar = "show active";
            $this->tabDetalhesCampanhas = "";
        
            $this->dispatchBrowserEvent('checkToaster', ["message" => "A data de validade da proposta deve ser igual ou superior à data atual!", "status" => "error"]);
            return false;
        }
        

        if($this->validadeProposta == null){

            $this->tabDetail = "";
            $this->tabProdutos = "";
            $this->tabDetalhesPropostas = "";
            $this->tabFinalizar = "show active";
            $this->tabDetalhesCampanhas = "";
    
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Campo Validade da Proposta está vazio!", "status" => "error"]);
            return false;
        }else{
            if (DateTime::createFromFormat('Y-m-d', $this->validadeProposta) === false) {
                $this->validadeProposta = DateTime::createFromFormat('d-m-Y', $this->validadeProposta);
                
                if ($this->validadeProposta) {
                    $this->validadeProposta = $this->validadeProposta->format('Y-m-d');
                } 
            }
        }
        
        $array = [
            "id" => $randomNumber,
            "date" => date('Y-m-d').'T'.date('H:i:s'), 
            "customer_number" => $idCliente,
            "total_without_tax" => $valorTotal,
            "total" => $valorTotalComIva,
            "reference" => $this->referenciaFinalizar,
            "comments" => $this->observacaoFinalizar,
            "obs" => $this->observacaoFinalizarPDF,
            "payment_conditions" => "",
            "salesman_number" => Auth::user()->id_phc,
            "type" => "budget",
            "validity" => $this->validadeProposta.'T'.date('H:i:s'),
            "visit_id" => $this->visitaCheck,
            "lines" => array_values($arrayProdutos)
        ];
        // dd(json_encode($array), $array);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/budgets',
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
        // dd($response_decoded);

        if($this->enviarClienteBool == true)
        {

            if ($response_decoded->success == true) {

                $proposta = $this->clientesRepository->getPropostaID($response_decoded->id_document);
                // dd($proposta->budgets[0]->budget);
                $pdf = new Dompdf();
                $pdf = PDF::loadView('pdf.pdfTabelaPropostas', ["proposta" => json_encode($proposta->budgets[0])]);

                $pdf->render();

                $pdfContent = $pdf->output();

                $emailCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);

                // $emailArray = explode("; ", $emailCliente["object"]->customers[0]->email);

                // dd($this->emailArray);

                $emailUsuarioLogado = Auth::user()->email;

                if (!empty($this->emailArray)) {
                    Mail::to($this->emailArray)
                        ->bcc($emailUsuarioLogado)
                        ->send(new SendProposta($pdfContent, $proposta->budgets[0]->budget));
                }
            }
        }

        if($this->enviarAprovacao == true)
        {

            if ($response_decoded->success == true) {
                // dd($response_decoded->id_document);
                $proposta = $this->clientesRepository->getPropostaID($response_decoded->id_document);


                $pdf = new Dompdf();
                $pdf = PDF::loadView('pdf.pdfTabelaPropostas', ["proposta" => json_encode($proposta->budgets[0])]);
            
                $pdf->render();
            
                $pdfContent = $pdf->output();
                
                if (property_exists($proposta, 'budgets') && isset($proposta->budgets[0])) {
                    $grupos = GrupoEmail::where('local_funcionamento', 'aprov_propostas')->get();
                    if(isset($grupos)){
                        $this->emailArray = [];

                        foreach ($grupos as $grupo) {
                            $emails = array_map('trim', explode(',', $grupo->emails));
                    
                            $this->emailArray = array_merge($this->emailArray, $emails);
                        }
                        
                        $this->emailArray = array_unique($this->emailArray);

                        if (!empty($this->emailArray)) {
                            Mail::to(Auth::user()->email)
                                ->bcc($this->emailArray)
                                ->send(new SendAprovacao($pdfContent, $proposta));
                        }
                    }
                }
            }  
            
        }

        if ($response_decoded->success == true) {

            $proposta = $this->clientesRepository->getPropostaID($response_decoded->id_document);

            // dd($proposta);
                $pdf = new Dompdf();
                $pdf = PDF::loadView('pdf.pdfTabelaPropostas', ["proposta" => json_encode($proposta->budgets[0])]);
            
                $pdf->render();
            
                $pdfContent = $pdf->output();
                
                if (property_exists($proposta, 'budgets') && isset($proposta->budgets[0]) && $this->enviarAprovacao == false) {
                    $grupos = GrupoEmail::where('local_funcionamento', 'nova_propostas')->get();
                    if(isset($grupos)){
                        $this->emailArray = [];

                        foreach ($grupos as $grupo) {
                            $emails = array_map('trim', explode(',', $grupo->emails));
                    
                            $this->emailArray = array_merge($this->emailArray, $emails);
                        }
                        

                        $this->emailArray = array_unique($this->emailArray);
                        // dd($this->emailArray);
                        if (!empty($this->emailArray)) {
                            Mail::to(Auth::user()->email)
                                ->bcc($this->emailArray)
                                ->send(new SendProposta($pdfContent, $proposta->budgets[0]->budget));
                        }
                    }
                }
           
            $getEncomenda = Carrinho::where('id_proposta','!=', "")->where('id_cliente',$idCliente)->first();


            ComentariosProdutos::where('id_proposta', $getEncomenda->id_proposta)->delete();
            Carrinho::where('id_proposta', $getEncomenda->id_proposta)->delete();
    
            $propostasArray = $this->clientesRepository->getPropostasClienteFiltro(100,1,$this->idCliente,$this->nomeCliente,$idCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,"0","0",$this->startDate,$this->endDate,$this->statusProposta);
            
            foreach($propostasArray["paginator"] as $proposta){
                $resultadoBudget = str_replace(' Nº', '', $proposta->budget);
                // dd($proposta->budget, $resultadoBudget, $response_decoded->document);
                if($resultadoBudget == $response_decoded->document){

                    $json = json_encode($proposta);
                    $object = json_decode($json, false);
                    Session::put('proposta', $object);
                    // Session::put('rota','propostas');

                    $this->dispatchBrowserEvent('checkToaster', ["message" => "Proposta finalizada com sucesso", "status" => "success"]);
                    return redirect()->route('propostas.proposta', ['idProposta' => $response_decoded->id_document]);
                }
                
            }

            $this->dispatchBrowserEvent('checkToaster', ["message" => "Proposta finalizada com sucesso", "status" => "success"]);
        }
        else {
            // dd($response_decoded);
            $this->tabDetail = "";
            $this->tabProdutos = "";
            $this->tabDetalhesPropostas = "";
            $this->tabFinalizar = "show active";
            $this->tabDetalhesCampanhas = "";
            $this->dispatchBrowserEvent('checkToaster', ["message" => "A proposta não foi finalizada", "status" => "error"]);
        }
        return false;
        }
    }

    public function render()
    {
        $this->quantidadeLines = 0;
        $detailProduto = session('detailProduto');
        if (!isset($detailProduto->product)){
            session()->forget('detailProduto');
        }
        $quickBuyProducts = session('quickBuyProducts');
        if (!isset($quickBuyProducts->product)){
            session()->forget('quickBuyProducts');
        }

        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];


        $this->getCategoriesAll = $this->PropostasRepository->getCategorias();

        

        if (session('searchSubFamily') !== null) {
            $sessao = session('searchSubFamily');
            

           

            $productsList = []; 


            if (isset($sessao->categories)) {
                
                $category = new stdClass();
               
    
                $category = $sessao->categories;
                
                    foreach ($category as $catIndex => $cat) {

                        if (isset($cat->families)) {
                            $category[$catIndex]->family = $cat->families;
                            unset($category[$catIndex]->families);

                            foreach ($category[$catIndex]->family as $famIndex => $family) {

                                if (isset($family->subamilies)) {
                                    $category[$catIndex]->family[$famIndex]->subfamily = $family->subamilies;
                                    unset($category[$catIndex]->family[$famIndex]->subamilies);
                                }
                            }
                        }
                    }                    
                    
                    $response = [
                        "success" => $sessao->success,
                        "message" => $sessao->message,
                        "total_pages" => $sessao->total_pages,
                        "page" => $sessao->page,
                        "records" => count($sessao->categories),
                        "total_records" => count($sessao->categories),
                        "category" => $category
                    ];
    
                     $this->getCategoriesAll = (object) $response;
               
                


                $productsList = [];
               
                foreach ($sessao->categories as $category) {
                    $categoryId = $category->id;
                    
                    foreach ($category->family as $family) {
                        $familyId = $family->id;
                    
                        foreach ($family->subfamily as $subfamily) {
                            $subfamilyId = $subfamily->id;
                    
                            foreach ($subfamily->products as $product) {
                                $productsList[] = [
                                    'product_number' => $product->id,
                                    'product_name' => $product->name,
                                    'category_number' => $categoryId,
                                    'family_number' => $familyId,
                                    'subfamily_number' => $subfamilyId
                                ];
                            }
                        }
                    }
                }
                    
                session(['searchNameFamily' => "$this->searchProduct"]);
    
                session(['searchNameSubFamily' => ""]);


                $productsListObjects = array_map(function($product) {
                    return (object) $product;
                }, $productsList);
                

                $response = [
                    "success" => $sessao->success,
                    "message" => $sessao->message,
                    "total_pages" => $sessao->total_pages,
                    "page" => $sessao->page,
                    "records" => count($productsListObjects),
                    "total_records" => count($productsListObjects),
                    "product" => $productsListObjects
                ];
                

                $this->searchSubFamily = (object) $response;

                session(['searchSubFamily' => $this->searchSubFamily]);

            }
        } else {

            $firstCategories = $this->getCategoriesAll->category[0];
            session(['searchNameCategory' => $firstCategories->name]);

            $firstFamily = $firstCategories->family[0];
            session(['searchNameFamily' => $firstFamily->name]);

            $firstSubFamily = $firstFamily->subfamily[0];
            session(['searchNameSubFamily' => $firstSubFamily->name]);

            $this->searchSubFamily = $this->PropostasRepository->getSubFamily($firstCategories->id, $firstFamily->id, $firstSubFamily->id);
            
            session(['searchSubFamily' => $this->searchSubFamily]);
        }

        $this->searchSubFamily = session('searchSubFamily');
        
        $productsArray = $this->searchSubFamily->product;
        $productsCollection = new Collection($productsArray);

        $perPage = 12;
        $currentPage = $this->page;

        $currentItems = $productsCollection->forPage($currentPage, $perPage);

           $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $productsCollection->count(),
            $perPage,
            $currentPage,
            [
                'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
            ]
        );


        if (session('searchProduct') !== null) {
            $this->searchProduct = session('searchProduct');
            // if ($this->searchProduct != "") {
            //     $this->searchSubFamily = $this->PropostasRepository->getSubFamilySearch($this->searchProduct);
            //     session(['Camp' => 1]);
            //     session(['Category' => null]);
            //     session(['Family' => null]);
            // }
        }
        if ($this->searchProduct != "") {

            $this->searchSubFamily = $this->PropostasRepository->getSubFamilySearch($this->searchProduct);
            session(['Camp' => 1]);
            session(['Category' => null]);
            session(['Family' => null]);
        }

        if (session('CampProds') !== null) {

            $this->searchProduct = session('CampProds');

            if ($this->searchProduct != "") {
                $products = $this->encomendasRepository->getprodCamp($this->searchProduct);
             
                $products = isset($products->product) ? collect($products->product) : collect([]);
                
            }
        }

        $this->carrinhoCompras = Carrinho::where('id_cliente', $this->detailsClientes->customers[0]->no)
            ->where('id_user', Auth::user()->id)
            ->where('id_proposta', '!=', '')
            ->where('id_proposta', $this->codEncomenda)
            ->orderBy('inkit', 'desc')
            ->get();

        $arrayCart = [];
        $onkit = 0;
        $allkit = 0;

        if($this->carrinhoCompras->count() > 0) {
            foreach ($this->carrinhoCompras as $cart) {
                if ($cart->inkit) {
                    $onkit = $cart->inkit;
                }
                if ($cart->inkit == 0) {
                    $allkit = 1;
                }

                $found = false;
                foreach ($arrayCart as &$item) {
                    if (($item->referencia == $cart->referencia) && ($item->designacao == $cart->designacao) && ($item->price == $cart->price) && ($item->model == $cart->model)) {
                        if (isset($cart->qtd)) {
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
                    array_push($arrayCart, $cart);
                    $this->quantidadeLines++;
                }
            }
        }

       $campanhas = Campanhas::where('ativa', 1)
        ->where('destaque', 1)
        ->where('dh_fim', '>', now())
        ->get();

        if(session('Camp1') != 1 || session('Camp') == 0)
        {
            session(['Camp' => 0]);
            $this->searchProduct = "";
            session(['searchProduct' => null]);
            session(['searchNameCategory' => ""]);
            session(['searchNameFamily' => ""]);
            session(['searchNameSubFamily' => ""]);
            session(['Category' => null]);
            session(['Family' => null]);
        }
        $this->searchProduct = "";

        // $this->getCategoriesAll = $this->PropostasRepository->getCategorias();
        // dd($detailProduto);

        // if($detailProduto != "")
        // {
        //     $link = ProdutosDB::where('ref', $detailProduto->product[0]->referense)
        //     ->value('link');
        //     $descricao = ProdutosDB::where('ref', $detailProduto->product[0]->referense)
        //     ->value('seo_descricao');

        //     session(['link' => $link]);
        //     session(['descricao' => $descricao]);
        // }

        return view('livewire.propostas.detalhe-proposta', [
            "products" => $products,
            "onkit" => $onkit,
            "allkit" => $allkit,
            "detalhesCliente" => $this->detailsClientes,
            // "getCategories" => $this->getCategories,
            "getCategoriesAll" => $this->getCategoriesAll,
            "searchSubFamily" => $this->searchSubFamily,
            "arrayCart" => $arrayCart,
            "codEncomenda" => $this->codEncomenda,
            "campanhas" => $campanhas
        ]);

    }
}
