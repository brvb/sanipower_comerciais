<?php

namespace App\Http\Livewire\Encomendas;

use stdClass;
use Livewire\Component;
use App\Models\Carrinho;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\ComentariosProdutos;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use Illuminate\Http\RedirectResponse;
use App\Interfaces\PropostasInterface;
use App\Interfaces\EncomendasInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Campanhas;

class DetalheEncomenda extends Component
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
    public $codvisita = null;


    public bool $showLoaderPrincipal = true;

    public $selectedItemsAddKit = [];
    public $selectedItemsRemoveKit = [];
    public $valueIvaInKit = 0;

    public string $tabDetail = "";
    public string $tabProdutos = "show active";
    public string $tabDetalhesEncomendas = "";
    public string $tabFinalizar = "";
    public string $tabDetalhesCampanhas = "";
    
    public int $quantidadeLines = 0;

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
    public int $statusEncomenda = 0;

    protected ?object $quickBuyProducts = null;
    public $iterationQuickBuy = 0;

    private ?object $detailProduto = null;

    public $modalShow = false;

    public $iterationDelete = 0;

    private ?object $campanhas = null;

    /** PARTE DO FINALIZAR **/

    public $transportadora = false;
    public $viaturaSanipower = false;
    public $levantamentoLoja = false;
    public $observacaoFinalizar;
    public $referenciaFinalizar;

    public $lojaFinalizar = "";
    
    public $condicoesFinalizar = false;
    public $chequeFinalizar = false;
    public $pagamentoFinalizar = false;
    public $transferenciaFinalizar = false;

    public ?array $lojas = NULL;

    /******** */


    /** PARTE DA COMPRA */
    public $produtosRapida = [];
    public $produtosComment = [];

    /***** */

    public ?object $encomenda = NULL;

    public int $perPage = 10;
    protected $listeners = ["callInputGroup","rechargeFamily" => "rechargeFamily", "cleanModal" => "cleanModal" ,'campoAlterado' =>'campoAlterado', 'addProductCommentEncomenda'=>'addProductCommentEncomenda'];

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

    public function mount($codvisita, $cliente, $codEncomenda)
    {
        if(session('Camp1') != 1)
        {
            session(['Camp' => 0]);
        }
        $this->initProperties();
        $this->idCliente = $cliente;
        $this->codEncomenda = $codEncomenda;
        $this->codvisita = $codvisita;

        $this->specificProduct = 0;
        $this->filter = false;

        if(session('OpenTabAdjudicarda') == "OpentabArtigos"){
            $this->tabDetail = "";
            $this->tabProdutos = "";
            $this->tabDetalhesEncomendas = "show active";
            $this->tabFinalizar = "";
            Session::forget('OpenTabAdjudicarda');
        }

        $this->showLoaderPrincipal = true;
    }
    public function rechargeFamily($id)
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        $this->getCategories = $this->encomendasRepository->getCategorias();
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();

        $this->searchProduct = "";
        $this->familyInfo = false;
        $this->dispatchBrowserEvent('refreshComponent', ["id" => $id]);
    }

    public function openDetailProduto($idCategory, $idFamily, $idSubFamily, $productNumber, $idCustomer, $productName)
    {
        $this->specificProduct = 1;

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesEncomendas = "";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";

        $this->idCategoryRecuar = $idCategory;
        $this->idFamilyRecuar = $idFamily;
        $this->idSubFamilyRecuar = $idSubFamily;

        $this->detailProduto = $this->encomendasRepository->getProdutos($idCategory, $idFamily, $idSubFamily, $productNumber, $idCustomer);

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
        return redirect()->route('encomendas.detail', ['id' => $this->idCliente]);
    }
    public function adicionarProduto($categoryNumber, $familyNumber, $subFamilyNumber, $productNumber, $customerNumber, $productName)
    {
        $this->quickBuyProducts = $this->encomendasRepository->getProdutos($categoryNumber, $familyNumber, $subFamilyNumber, $productNumber, $customerNumber);

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesEncomendas = "";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";

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
        $this->tabDetalhesEncomendas = "";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";

        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        $this->getCategories = $this->encomendasRepository->getCategorias();
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();

        // Disparar evento para o navegador
        $this->dispatchBrowserEvent('encomendaAtual');
    }
    public function Limpar()
    {
        Carrinho::where('id_encomenda', $this->codEncomenda)->where("id_user", Auth::user()->id)->delete();
        ComentariosProdutos::where('id_encomenda', $this->codEncomenda)->where("id_user", Auth::user()->id)->delete();

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesEncomendas = "show active";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";

        $this->quantidadeLines = 0;

    }
    public function cancelarEncomenda()
    {
        Carrinho::where('id_encomenda', $this->codEncomenda)->where("id_user", Auth::user()->id)->delete();
        ComentariosProdutos::where('id_encomenda', $this->codEncomenda)->where("id_user", Auth::user()->id)->delete();

        return redirect()->route('encomendas');
    }

    public function delete($itemId)
    {
        Carrinho::where('id', $itemId)->delete();

        $this->dispatchBrowserEvent('itemDeleted', ['itemId' => $itemId]);

    }

    public function deletar($referencia, $designacao, $model, $price)
    {
        Carrinho::where('id_encomenda', $this->codEncomenda)
                ->where('referencia', $referencia)
                ->where('designacao', $designacao)
                ->where('model', $model)
                ->where('price', $price)
        ->delete();

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesEncomendas = "show active";
        $this->tabFinalizar = "";
    }


    public function deletartodos()
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];
        Carrinho::where('id_cliente', $this->detailsClientes->customers[0]->no)->where('id_user',Auth::user()->id)->delete();

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesEncomendas = "show active";
        $this->tabFinalizar = "";
    }

    public function searchCategory($idCategory, $idFamily)
    {
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();

        $this->getCategories = $this->encomendasRepository->getCategoriasSearched($this->getCategoriesAll->category[$idCategory - 1]->id, $idFamily);
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesEncomendas = "";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";

        $this->searchProduct = "";
        //unset($_SESSION['searchProduct']);
        session()->forget('searchProduct');

        $this->filter = true;
        $this->familyInfo = true;
        $this->idFamilyInfo = $idFamily;
        $this->idCategoryInfo = $idCategory;

        $this->showLoaderPrincipal = true;

        $this->specificProduct = 0;

        $this->iteration++;

        $this->dispatchBrowserEvent('refreshComponent', ["id" => $idCategory]);
    }

    public function searchSubFamily($idCategory, $idFamily, $idSubFamily)
    {
        session(['Camp' => 1]);
        session(['Camp1' => 1]);
        $this->searchProduct = "";
        session(['searchProduct' => $this->searchProduct]);


        // $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        // $this->detailsClientes = $arrayCliente["object"];
        $this->getCategories = $this->encomendasRepository->getCategorias();
        // $this->getCategoriesAll = $this->encomendasRepository->getCategorias();
        $this->searchSubFamily = $this->encomendasRepository->getSubFamily($idCategory, $idFamily, $idSubFamily);

        $this->actualCategory = $idCategory;
        $this->actualFamily = $idFamily;
        $this->actualSubFamily = $idSubFamily;

        session(['searchSubFamily' => $this->searchSubFamily]);
        // dd($this->getCategories->category[]);
        foreach ($this->getCategories->category as $index => $idCtgry) {

            if ($idCtgry->id == $idCategory) {
                session(['searchNameCategory' => $idCtgry->name]);

                foreach ($idCtgry->family as $idFmly) {
                    if ($idFmly->id === $idFamily) {
                        session(['searchNameFamily' => $idFmly->name]);

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
        $this->tabDetalhesEncomendas = "";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";

        $this->idCategoryRecuar = $idCategory;
        $this->idFamilyRecuar = $idFamily;
        $this->idSubFamilyRecuar = $idSubFamily;

        $this->filter = true;
        $this->familyInfo = true;

        $this->idFamilyInfo = "";
        $this->idCategoryInfo = "";


        $this->showLoaderPrincipal = true;

        $this->specificProduct = 0;

        $this->iteration++;
        return redirect()->route('encomendas.detail', ['id' => $this->idCliente]);
        // $this->dispatchBrowserEvent('refreshPage');
        // $this->dispatchBrowserEvent('refreshAllComponent');

    }

    public function ShowCampanhas()
    {
        // dd('AQUI');
        session(['Camp' => 0]);
        session(['Camp1' => 0]);

    }

    public function updatedSearchProduct()
    {

        $this->getCategories = $this->encomendasRepository->getCategorias();
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        if ($this->searchProduct != "") {
            $this->searchSubFamily = $this->encomendasRepository->getSubFamilySearch($this->searchProduct);
            session(['searchSubFamily' => $this->searchSubFamily]);

            session(['searchProduct' => $this->searchProduct]);
        } else {
            $this->searchSubFamily = $this->encomendasRepository->getSubFamily($this->actualCategory, $this->actualFamily, $this->actualSubFamily);
            session(['searchSubFamily' => $this->searchSubFamily]);

            //unset($_SESSION['searchProduct']);
            session()->forget('searchProduct');
        }

        $this->showLoaderPrincipal = false;

        $this->specificProduct = 0;
        $this->iteration++;

        $this->dispatchBrowserEvent('refreshAllComponent');

    }

    public function resetFilterEncomenda($idCategory)
    {
        $this->getCategories = $this->encomendasRepository->getCategorias();
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        $this->familyInfo = false;

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesEncomendas = "";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";

        $this->specificProduct = 0;

        $this->showLoaderPrincipal = true;
        $this->dispatchBrowserEvent('refreshComponentEncomenda2', ["id" => $this->getCategoriesAll->category[$idCategory - 1]->id]);
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

                            if ($prod->in_stock == false) {
                                $this->dispatchBrowserEvent('checkToaster', ["message" => "Não existe quantidades em stock", "status" => "error"]);
                                $flag = 1;
                                break;
                            }
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

        $response = $this->encomendasRepository->addProductToDatabase($this->codvisita, $this->idCliente, $productChosen, $nameProduct, $no, $ref, $codEncomenda,"encomenda");

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

                            if ($prod->in_stock == false) {
                                $this->dispatchBrowserEvent('checkToaster', ["message" => "Não existe quantidades em stock", "status" => "error"]);
                                $flag = 1;
                                break;
                            }
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

        $response = $this->encomendasRepository->addProductToDatabase($this->codvisita, $this->idCliente, $productChosen, $nameProduct, $no, $ref, $codProposta, "proposta");

        $responseArray = $response->getData(true);

        if ($responseArray["success"] == true) {
            if($this->produtosComment){
                $response = $this->propostasRepository->addCommentToDatabase($responseArray["data"]["id"],$this->idCliente, $productChosen, $nameProduct, $no, $ref, $codProposta,"proposta", $productChosenComment["comentario"]);
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
                        if ($prod->in_stock == true) {
                            $productChosen[$count] = [
                                "product" => $prod,
                                "quantidade" => $prodRap,
                            ];
                            $count++;
                        }
                    }
                }else if ($prodRap == "0") {
                    $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
                    return false;
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

       

        // foreach($productChosen as $prodId){
            

        //     $response = $this->encomendasRepository->addProductToDatabase($this->idCliente,$prodId,$nameProduct,$no,$ref,$codEncomenda, "encomenda");
        
        
        // }

        foreach($productChosen as $prodId){
            $response = $this->encomendasRepository->addProductToDatabase($this->codvisita,$this->idCliente,$prodId,$nameProduct,$no,$ref,$codEncomenda, "encomenda");
            
            $responseArray = $response->getData(true);

            foreach($productChosenComment as $comeProd){
               
                if(($prodId["product"]->referense == $comeProd["product"]->referense) && ($prodId["product"]->model == $comeProd["product"]->model) && ($prodId["product"]->price == $comeProd["product"]->price))
                {
                    $response = $this->encomendasRepository->addCommentToDatabase($responseArray["data"]["id"], $this->idCliente, $prodId, $nameProduct, $no, $ref, $codEncomenda,"encomenda", $comeProd["comentario"]);
                }
            }


        }

        // foreach($productChosenComment as $prodId){
        //     $response = $this->encomendasRepository->addCommentToDatabase($this->idCliente, $prodId, $nameProduct, $no, $ref, $codEncomenda,"encomenda", $prodId["comentario"]);
        // }
        
        if($response){
            $responseArray = $response->getData(true);
        }else{
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
            return false;
        }


        if ($responseArray["success"] == true) {
            $message = "Produto adicionado á encomenda!";
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

        $this->dispatchBrowserEvent('compraRapida');

        $this->skipRender();
    }


    public function finalizarencomenda()
    {
        $propertiesLoja = [
            'levantamentoLoja' => $this->levantamentoLoja,
            'viaturaSanipower' => $this->viaturaSanipower,
            'transportadora' => $this->transportadora,
            
        ];
        $propertiesPagamentos = [
           'condicoesFinalizar' => $this->condicoesFinalizar,
            'chequeFinalizar' => $this->chequeFinalizar,
            'pagamentoFinalizar' => $this->pagamentoFinalizar,
            'transferenciaFinalizar' => $this->transferenciaFinalizar,
            
        ];

        $resultLoja = [];
        foreach ($propertiesLoja as $property => $value) {
            if ($value === true) {
                $resultLoja[] = $property;
            }
        }
        if(empty($resultLoja)){
            $resultLoja[0]= "";
        }
        $resultPagamento = [];
        foreach ($propertiesPagamentos as $property => $value) {
            if ($value === true) {
                $resultPagamento[] = $property;
            }
        }
        if(empty($resultPagamento)){
            $resultPagamento[0] = "";
        }


        if($resultPagamento[0] == "" || $resultLoja[0] == "")
        {
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar um dado logistico e um tipo de pagamento", "status" => "error"]);
            return false;
        }
            

        $count = 0;
        $valorTotal = 0;
        $valorTotalComIva = 0;
       

        $idCliente = "";
        foreach($this->carrinhoCompras as $prod)
        {
            $count++;

            $idCliente = $prod->id_cliente;


            $totalItem = $prod->price * $prod->qtd;
            $totalItemComIva = $totalItem + ($totalItem * ($prod->iva / 100));
            $valorTotal += $totalItem;
            $valorTotalComIva += $totalItemComIva;

            $comentarioCheck = ComentariosProdutos::where('id_encomenda', $this->codEncomenda)
                ->where('tipo','encomenda')
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
            } 
            else {
                $visitaCheck = $prod->id_visita;
            }
            if($prod->id_proposta == null){
                $id_proposta = "";
            }else{
                $id_proposta = $prod->id_proposta;
            }
            $arrayProdutos[$count] = [
                "id" => $count,
                "reference" => $prod->referencia,
                "description" => $prod->designacao,
                "quantity" => $prod->qtd,
                "tax" => $prod->iva,
                "tax_included" => false,
                "price" => $prod->price,
                "discount1" => $prod->discount,
                "discount2" => $prod->discount2,
                "discount3" => 0,
                "total" => $totalItem,
                "notes" => $comentario,
                "visit_id" => $visitaCheck, // ou tenho de trazer da base de dados
                "budgets_id" => $id_proposta,
            ];
        }
        // dd($arrayProdutos);
        if ($count <= 0){
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Não foi selecionado artigos!", "status" => "error"]);
            return false;
        }

        $randomNumber = '';
        for ($i = 0; $i < 8; $i++) {
            $randomNumber .= rand(0, 9);
        }

        if($this->transferenciaFinalizar == true)
        {
            $condicaoPagamento = "Transferência Bancária";
        }
        if($this->pagamentoFinalizar == true)
        {
            $condicaoPagamento = "Pronto Pagamento";
        }
        if($this->chequeFinalizar == true)
        {
            $condicaoPagamento = "Cheque a 30 dias";
        }
        if($this->condicoesFinalizar == true)
        {
            $condicaoPagamento = "Condições acordadas";
        }

        if(json_decode($this->lojaFinalizar) == null)
        {
            $loja = "";
        } 
        else {
            $loja = json_decode($this->lojaFinalizar);
        }
        $parametroStatusAdjudicar = session('parametroStatusAdjudicar');
        if($parametroStatusAdjudicar == null){
            $parametroStatusAdjudicar = false;
        }
        $array = [
            "id" => $randomNumber,
            "date" => date('Y-m-d').'T'.date('H:i:s'), 
            "customer_number" => $idCliente,
            "total_without_tax" => number_format($valorTotal, 2, '.', '.'),
            "total" => number_format($valorTotalComIva, 2, '.', '.'),
            "reference" => $this->referenciaFinalizar,
            "comments" => $this->observacaoFinalizar,
            "delivery" => $resultLoja[0],
            "store" => $loja,
            "payment_conditions" => $condicaoPagamento,
            "salesman_number" => Auth::user()->id_phc,
            "type" => "order",
            // "awarded" => $parametroStatusAdjudicar,
            "lines" => array_values($arrayProdutos)
        ];
       
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/orders',
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

        if ($response_decoded->success == true) {
            $getEncomenda = Carrinho::where('id_encomenda','!=', "")->where('id_cliente',$idCliente)->first();

           
            ComentariosProdutos::where('id_encomenda', $getEncomenda->id_encomenda)->delete();
            Carrinho::where('id_encomenda', $getEncomenda->id_encomenda)->delete();   
            $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro(100,1,$this->idCliente,$this->nomeCliente,$idCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,"0","0",$this->startDate,$this->endDate,$this->statusEncomenda);
            
            session(['parametroStatusAdjudicar' => null]);

            foreach($encomendasArray["paginator"] as $encomenda){
                $resultadoBudget = str_replace(' Nº', '', $encomenda->order);
                // dd($proposta->budget, $resultadoBudget, $response_decoded->document);
                if($resultadoBudget == $response_decoded->document){

                    $json = json_encode($encomenda);
                    $object = json_decode($json, false);
                    Session::put('rota','encomendas');
                    Session::put('encomenda', $object);

                    $this->dispatchBrowserEvent('checkToaster', ["message" => "Encomenda finalizada com sucesso", "status" => "success"]);
                    return redirect()->route('encomendas.encomenda', ['idEncomenda' => $response_decoded->id_document]);
                }
                
            }
            

            $this->dispatchBrowserEvent('checkToaster', ["message" => "Encomenda finalizada com sucesso", "status" => "success"]);
        }
        else {
            $this->dispatchBrowserEvent('checkToaster', ["message" => "A encomenda não foi finalizada", "status" => "error"]);
        }

        return false;

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
            
            Carrinho::where('id_encomenda', $codEncomenda)
                                ->where('referencia', $referencia)
                                ->where('designacao', $designacao)
                                ->where(function($query) {
                                    $query->where('proposta_info', null)
                                          ->orWhere('proposta_info', '');
                                })
                                ->update($novosValores);
        }

        $this->selectedItemsAddKit = [];

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesEncomendas = "show active";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";
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
            Carrinho::where('id_encomenda', $codEncomenda)
                                ->where('referencia', $referencia)
                                ->where('designacao', $designacao)
                                ->update($novosValores);
        }

        $this->selectedItems = [];

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesEncomendas = "show active";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";
        $this->dispatchBrowserEvent('checkToaster');
    }
    
    public function ivaInKit()
    {
    
        $codEncomenda = $this->codEncomenda;
        $valueIvaInKit = $this->valueIvaInKit;
        $novosValores = [
            'iva2' => intval($valueIvaInKit),
        ];
        Carrinho::where('id_encomenda', $codEncomenda)
        ->where('inKit', 1)
        ->update($novosValores);
        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesEncomendas = "show active";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";
    }

    public function updatedKitCheck()
    {
       
        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesEncomendas = "show active";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";
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
        
        // $this->detailsClientes = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];


        $this->getCategories = $this->encomendasRepository->getCategorias();
        
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();

        if (session('searchSubFamily') !== null) {
            $sessao = session('searchSubFamily');
            // dd($sessao );
            $productsList = [];  // Inicializa uma lista para armazenar os produtos convertidos

            // Itera sobre as categorias
            if (isset($sessao->categories)) {
                
                $category = new stdClass();
                // dd($sessao,$category);

                $category = $sessao->categories;
                
                   // Iterar pelas categorias para ajustar 'families' e 'subamilies'
                    foreach ($category as $catIndex => $cat) {
                        // Renomear 'families' para 'family'
                        if (isset($cat->families)) {
                            $category[$catIndex]->family = $cat->families;  // Criar nova chave 'family'
                            unset($category[$catIndex]->families);  // Remover a chave antiga 'families'

                            // Iterar pelas famílias dentro de cada categoria
                            foreach ($category[$catIndex]->family as $famIndex => $family) {
                                // Renomear 'subamilies' para 'subfamily'
                                if (isset($family->subamilies)) {
                                    $category[$catIndex]->family[$famIndex]->subfamily = $family->subamilies;  // Criar nova chave 'subfamily'
                                    unset($category[$catIndex]->family[$famIndex]->subamilies);  // Remover a chave antiga 'subamilies'
                                }
                            }
                        }
                    }

                    // Exibir os dados após as modificações (para depuração)
                    
                    
                    $response = [
                        "success" => $sessao->success,
                        "message" => $sessao->message,
                        "total_pages" => $sessao->total_pages,
                        "page" => $sessao->page,
                        "records" => count($sessao->categories),
                        "total_records" => count($sessao->categories),
                        "category" => $category
                    ];
                    // Atribuindo o resultado à propriedade
                    // $category = (object) $category;
    
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
                
                session(['searchNameCategory' => "Pesquisa"]);
    
                session(['searchNameFamily' => "$this->searchProduct"]);
    
                session(['searchNameSubFamily' => ""]);

                // Converter o array de produtos para uma lista de objetos
                $productsListObjects = array_map(function($product) {
                    return (object) $product;
                }, $productsList);
                
                // Estrutura final da resposta
                $response = [
                    "success" => $sessao->success,
                    "message" => $sessao->message,
                    "total_pages" => $sessao->total_pages,
                    "page" => $sessao->page,
                    "records" => count($productsListObjects),
                    "total_records" => count($productsListObjects),
                    "product" => $productsListObjects
                ];
                
                // Atribuindo o resultado à propriedade
                $this->searchSubFamily = (object) $response;
                
                // Armazenando na sessão (se necessário)
                session(['searchSubFamily' => $this->searchSubFamily]);
                
                // Exibindo o resultado para depuração
                // dd($response);
            }
            
            

            // dd($sessao );
            // foreach ($sessao->categories as $prod) {
            //     $this->actualCategory = $prod->id;
            //     $this->actualFamily = $prod->families;
            //     $this->actualSubFamily = $prod->subfamily_number;

            //     break;
            // }

            // $this->searchSubFamily = $this->encomendasRepository->getSubFamily($this->actualCategory, $this->actualFamily, $this->actualSubFamily);
        
        } else {
            // $this->getCategories = $this->encomendasRepository->getCategorias();

            $firstCategories = $this->getCategories->category[0];
            session(['searchNameCategory' => $firstCategories->name]);

            $firstFamily = $firstCategories->family[0];
            session(['searchNameFamily' => $firstFamily->name]);

            $firstSubFamily = $firstFamily->subfamily[0];
            session(['searchNameSubFamily' => $firstSubFamily->name]);

            $this->searchSubFamily = $this->encomendasRepository->getSubFamily($firstCategories->id, $firstFamily->id, $firstSubFamily->id);
          
            session(['searchSubFamily' => $this->searchSubFamily]);
        }

        $this->searchSubFamily = session('searchSubFamily');
        $productsArray = $this->searchSubFamily->product;
        $productsCollection = new Collection($productsArray);

        $perPage = 12;
        $currentPage = $this->page; // Use $this->page, que o WithPagination provê
        // Paginando os produtos
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

                    if ($this->searchProduct != "") {
                        $this->searchSubFamily = $this->encomendasRepository->getSubFamilySearch($this->searchProduct);
                    }
                }

        $this->carrinhoCompras = Carrinho::where('id_cliente', $this->detailsClientes->customers[0]->no)
            ->where('id_user', Auth::user()->id)
            ->where('id_encomenda', $this->codEncomenda)
            ->orderBy('inkit', 'desc')
            ->get();

        $arrayCart = [];
        $onkit = 0;
        $allkit = 0;
        $this->quantidadeLines = 0;

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

                    if (
                        $item->referencia == $cart->referencia &&
                        $item->designacao == $cart->designacao &&
                        $item->price == $cart->price &&
                        $item->model == $cart->model
                    ) {
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

        $this->lojas = $this->encomendasRepository->getLojas();
        $campanhas = Campanhas::where('ativa', 1)
        ->where('destaque', 1)
        ->where('dh_fim', '>', now())
        ->get();
        // dd($products);
        return view('livewire.encomendas.detalhe-encomenda', [
            "products" => $products,
            "onkit" => $onkit,
            "allkit" => $allkit,
            "detalhesCliente" => $this->detailsClientes,
            "getCategories" => $this->getCategories,
            "getCategoriesAll" => $this->getCategoriesAll,
            "searchSubFamily" => $this->searchSubFamily,
            "arrayCart" => $arrayCart,
            "codEncomenda" => $this->codEncomenda,
            "campanhas" => $campanhas
        ]);
    }
}
