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

use App\Models\GrupoEmail;
use App\Mail\SendEncomenda;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;



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
    public $isMobile = false;

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
    public $entrega_obra = false;
    public $viaturaSanipower = false;
    public $encomendaProgramada = false;
    public $levantamentoLoja = false;
    public $observacaoFinalizar;
    public $observacaoFinalizarPDF;
    public $referenciaFinalizar;

    public $lojaFinalizar = "";

    public $moradaFinalizar = "";
    public $dateFinalizar = "";
    public $codpostalFinalizar = "";
    public $locFinalizar = "";

    public $moradaFinalizarCli = "";
    public $codpostalFinalizarCli = "";
    public $locFinalizarCli = "";
    
    public $condicoesFinalizar = false;
    public $chequeFinalizar = false;
    public $pagamentoFinalizar = false;
    public $transferenciaFinalizar = false;
    public $PaymentConditions = "";
    

    public ?array $lojas = NULL;

    /******** */


    /** PARTE DA COMPRA */
    public $produtosRapida = [];
    public $produtosComment = [];

    /***** */
    public $emailArray;
    public $emailSend;
    public $visitaCheck;
    public $prodtQTD = [];

    public ?object $encomenda = NULL;

    public int $perPage = 10;

    protected $listeners = ['toggleNavbarState' => 'toggleNavbarState',"callInputGroup","rechargeFamily" => "rechargeFamily", "cleanModal" => "cleanModal" ,'campoAlterado' =>'campoAlterado', 'addProductCommentEncomenda'=>'addProductCommentEncomenda','setIsMobile', 'updateEntregaObra' => 'updateEntregaObra'];

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

        // $this->specificProduct = 0;
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
    public function setIsMobile($isMobile)
    {
        $this->isMobile = $isMobile;
    }
    public function rechargeFamily($id)
    {
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);

        dd($arrayCliente);
        $this->detailsClientes = $arrayCliente["object"];
        // $this->getCategories = $this->encomendasRepository->getCategorias();
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();

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
        // dd('aqui');
        $this->specificProduct = 0;
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

    public function addProdCamp($referense)
    {
        // $this->quickBuyProducts = $this->encomendasRepository->getProdutos($categoryNumber, $familyNumber, $subFamilyNumber, $productNumber, $customerNumber);

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesEncomendas = "";
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
        // $this->getCategories = $this->encomendasRepository->getCategorias();
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
            return redirect()->route('encomendas');
        }
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

        $this->getCategoriesAll = $this->encomendasRepository->getCategoriasSearched($this->getCategoriesAll->category[$idCategory - 1]->id, $idFamily);
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        $this->tabDetail = "";
        $this->tabProdutos = "show active";
        $this->tabDetalhesEncomendas = "";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";

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

    public function searchSubFamily($idCategory, $idFamily, $idSubFamily)
    {
        // dd($idCategory, $idFamily, $idSubFamily);
        session(['Camp' => 1]);
        session(['Camp1' => 1]);
        session(['CampProds' => null]);
        $this->searchProduct = "";
        session(['Category' => null]);
        session(['Family' => null]);
        session(['searchProduct' => $this->searchProduct]);


        // $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        // $this->detailsClientes = $arrayCliente["object"];
        // $this->getCategories = $this->encomendasRepository->getCategorias();
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();
        $this->searchSubFamily = $this->encomendasRepository->getSubFamily($idCategory, $idFamily, $idSubFamily);

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
        session(['specificProduct' => $this->specificProduct]);

        $this->iteration++;
        return redirect()->route('encomendas.detail', ['id' => $this->idCliente]);
        // $this->dispatchBrowserEvent('refreshPage');
        // $this->dispatchBrowserEvent('refreshAllComponent');

    }

    public function GetprodCamp($bostamp)
    {
        // dd($bostamp);
        session(['Camp' => 1]);
        session(['Camp1' => 1]);
        session(['CampProds' => $bostamp]);
        return redirect()->route('encomendas.detail', ['id' => $this->idCliente]);
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
        // session(['searchProduct' => null]);

        // $sessions = session()->all();
        // $this->dispatchBrowserEvent('refreshAllComponent');
        // Exibe todas as sessões
        // dd($sessions); // Isso irá parar a execução e mostrar as sessões
    }

    public function ShowFamily($id)
    {
        // dd($id);
         session(['Category' => $id]);
         $this->getCategoriesAll = $this->encomendasRepository->getCategorias();
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
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();
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
    public function updatedSearchProduct()
    {

        // $this->getCategories = $this->encomendasRepository->getCategorias();
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);
        $this->detailsClientes = $arrayCliente["object"];

        if ($this->searchProduct != "") {
            $this->searchSubFamily = $this->encomendasRepository->getSubFamilySearch($this->searchProduct);
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
            $this->searchSubFamily = $this->encomendasRepository->getSubFamily($this->actualCategory, $this->actualFamily, $this->actualSubFamily);
            session(['searchSubFamily' => $this->searchSubFamily]);

            //unset($_SESSION['searchProduct']);
            session()->forget('searchProduct');
        }

        $this->showLoaderPrincipal = false;

        $this->specificProduct = 0;
        $this->iteration++;

        // $this->dispatchBrowserEvent('refreshAllComponent');
        return redirect()->route('encomendas.detail', ['id' => $this->idCliente]);

    }

    public function resetFilterEncomenda($idCategory)
    {
        // $this->getCategories = $this->encomendasRepository->getCategorias();
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
    public function editProductQuickBuyEncomenda($prodID, $referense, $nameProduct, $no, $ref, $codEncomenda, $price)
    {
        $quickBuyProducts = session('quickBuyProducts');
        // dd($prodID, $nameProduct, $no, $ref, $codEncomenda, $this->produtosRapida, $this->prodtQTD, $this->codvisita, $this->idCliente);
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
        
        // $productChosen = [];
        // $productChosenComment = [];
        // dd($prodID, $nameProduct, $no, $ref, $codEncomenda, $this->produtosRapida, $this->prodtQTD, $this->codvisita, $this->idCliente);

        // dd($quickBuyProducts);
        // foreach ($quickBuyProducts->product as $i => $prod) {
        //     if ($i == $prodID) {
        //         foreach ($this->produtosRapida as $j => $prodRap) {

        //             if ($i == $j) {

        //                 if ($prodRap == "0" || $prodRap == "") {
        //                     $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
        //                     $flag = 1;
        //                     break;
        //                 } else {
        //                     $productChosen = ["product" => $prod, "quantidade" => $prodRap];
        //                 }
        //             }
        //         }
        //         if($this->produtosComment){
        //             foreach ($this->produtosComment as $j => $prodComm) {
        //                 if ($i == $j) {
        //                     $productChosenComment = ["comentario" => $prodComm];
        //                 }
        //             }
        //         }
        //     }

        //     if ($flag == 1) {
        //         break;
        //     }

        // }
        // if ($flag == 1) {
        //     return false;
        // }

        if( $this->prodtQTD != null )
        {
            // $price = $productChosen['product']->price;
            // $nameProduct = str_replace(' ', '', $nameProduct);
            $itensSemProposta = Carrinho::where('id_encomenda', $codEncomenda)
                ->where('referencia', $referense)
                ->where('price', $price)
                ->where('designacao', $nameProduct)
                ->get();
            if ($itensSemProposta->count() > 1) {
                $quantidadeTotal = 0;
                $primeiroItem = null;
            
                foreach ($itensSemProposta as $index => $item) {
                    if ($index === 0) {
                        $primeiroItem = $item;
                    } else {
                        $quantidadeTotal += $item->qtd;
            
                        $item->delete();
                    }
                }
            
                if ($primeiroItem) {
                    $primeiroItem->qtd += $quantidadeTotal;
                    $primeiroItem->save();
                }
            }
            $itemAtualizado = Carrinho::updateOrCreate(
            [
                'id_encomenda' => $codEncomenda,
                'referencia' => $referense,
                'designacao' => $nameProduct,
                'price' => $price,
            ],
            [
                'qtd' => $this->produtosRapida[$prodID],
            ]
            );
            // Carrinho::where('id_encomenda', $codEncomenda)
            //     ->where('referencia', $productChosen['product']->referense)
            //     ->where('model', $productChosen['product']->model)
            //     ->where('price', $price)
            //     ->where('id', '!=', $itemAtualizado->id)
            //     ->where('id_proposta', '')
            //     ->delete();

            // Resetar a quantidade local (se necessário)
            $this->prodtQTD = null;
        }

        $this->tabDetail = "";
        $this->tabProdutos = "";
        $this->tabDetalhesEncomendas = "show active";
        $this->tabDetalhesCampanhas = "";
        $this->tabFinalizar = "";
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
        // dd($productChosen);
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
                        // if ($prod->in_stock == true) {
                            $productChosen[$count] = [
                                "product" => $prod,
                                "quantidade" => $prodRap,
                            ];
                            $count++;
                        }
                    // }
                }else if ($prodRap == "0") {
                    $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar uma quantidade", "status" => "error"]);
                    return false;
                }
            }
            foreach ($this->produtosComment as $j => $prodComm) {
                if ($i == $j) {
                    if ($prodComm != "0" && $prodComm != "") {
                        // if ($prod->in_stock == true) {
                            $productChosenComment[$count] = [
                                "product" => $prod,
                                "comentario" => $prodComm,
                            ];
                            $count++;
                        // }
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

    public function updateEntregaObra($value)
    {
        // dd('AQUI');
        $this->entrega_obra = $value;
        $this->tabFinalizar = 'show active';
        $this->tabProdutos = '';
    }


    public function finalizarencomenda()
    {
         if($this->entrega_obra == "levantamento_loja_selecionado")
         {
            $this->levantamentoLoja = true;
            $this->viaturaSanipower = false;
            $this->transportadora = false;
            $this->entrega_obra = false;
         }
         if($this->entrega_obra == "viatura_sanipower_selecionado")
         {
            $this->levantamentoLoja = false;
            $this->viaturaSanipower = true;
            $this->transportadora = false;
            $this->entrega_obra = false;
         }
         if($this->entrega_obra == "transportadora_selecionado")
         {
            $this->levantamentoLoja = false;
            $this->viaturaSanipower = false;
            $this->transportadora = true;
            $this->entrega_obra = false;

            $this->moradaFinalizar = $this->moradaFinalizarCli;
            $this->codpostalFinalizar = $this->codpostalFinalizarCli;
            $this->locFinalizar = $this->locFinalizarCli;
         }
         if($this->entrega_obra == "entrega_obra_selecionado")
         {
            $this->levantamentoLoja = false;
            $this->viaturaSanipower = false;
            $this->transportadora = false;
            $this->entrega_obra = true;
         }
        //  dd($this->levantamentoLoja,
        //     $this->viaturaSanipower,
        //     $this->transportadora,
        //     $this->entrega_obra,
        //     $this->encomendaProgramada);

        // dd($this->moradaFinalizar, $this->codpostalFinalizar, $this->locFinalizar);

        $propertiesLoja = [
            'levantamentoLoja' => $this->levantamentoLoja,
            'Entrega por viatura Sanipower' => $this->viaturaSanipower,
            'Entrega por transportadora' => $this->transportadora,
            'Entrega em obra' => $this->entrega_obra,
            'Encomenda Programda' => $this->encomendaProgramada,
            
        ];
        
        $propertiesPagamentos = [
           'condicoesFinalizar' => $this->condicoesFinalizar,
            'chequeFinalizar' => $this->chequeFinalizar,
            'pagamentoFinalizar' => $this->pagamentoFinalizar,
            'transferenciaFinalizar' => $this->transferenciaFinalizar,
            // 'PaymentConditions' => $this->PaymentConditions,
            
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
        // dd($resultLoja[0],);
        // dd($this->dateFinalizar);
        if ($this->transportadora == true || $this->entrega_obra == true){
            if($this->moradaFinalizar == '' || $this->codpostalFinalizar == '' || $this->locFinalizar == '')
            {
                $this->dispatchBrowserEvent('checkToaster', ["message" => "Os dados de morada não foram preenchidos!", "status" => "error"]);
                return false;
            }
        }

        if($this->transportadora == false && $this->entrega_obra == false)
        {
            $this->moradaFinalizar = ''; 
            $this->codpostalFinalizar = ''; 
            $this->locFinalizar = '';
        }

        if ($this->encomendaProgramada == true && $this->dateFinalizar == ''){
            if($this->dateFinalizar == now()->format('Y-m-d'))
            {
                $this->dispatchBrowserEvent('checkToaster', ["message" => "A data não foi preenchida!", "status" => "error"]);
                return false;
            }
            $this->dispatchBrowserEvent('checkToaster', ["message" => "A data não foi preenchida!", "status" => "error"]);
            return false;
        }

        if ($this->encomendaProgramada == false){
            $this->dateFinalizar = now()->format('Y-m-d');
        }

        // dd($this->moradaFinalizar, $this->codpostalFinalizar, $this->locFinalizar);
        // if($resultPagamento[0] == "" || $resultLoja[0] == "")
        // {
        //     $this->dispatchBrowserEvent('checkToaster', ["message" => "Tem de selecionar um dado logistico e um tipo de pagamento", "status" => "error"]);
        //     return false;
        // }
            

        $count = 0;
        $valorTotal = 0;
        $valorTotalComIva = 0;
       

        $idCliente = "";
        foreach($this->carrinhoCompras as $prod)
        {
            $idCliente = $prod->id_cliente;

            $key = implode('|', [
                $prod->referencia,
                $prod->price,
                $prod->pvp,
                $prod->discount,
                $prod->discount2
            ]);

            $totalItem = $prod->price * $prod->qtd;
            $totalItemComIva = $totalItem + ($totalItem * ($prod->iva / 100));
            $valorTotal += $totalItem;
            $valorTotalComIva += $totalItemComIva;

            $comentarioCheck = ComentariosProdutos::where('id_encomenda', $this->codEncomenda)
                ->where('tipo','encomenda')
                ->where('id_carrinho_compras', $prod->id)
                ->first();

            $comentario = $comentarioCheck ? $comentarioCheck->comentario : "";

            $visitaCheck = $prod->id_visita ?? 0;
            $this->visitaCheck = $visitaCheck;

            $id_proposta = $prod->id_proposta ?? "";

            if (!isset($agrupados[$key])) {
                $count++;
                $agrupados[$key] = [
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
                    "budgets_id" => $id_proposta,
                    "origin_id" => $prod->origin_id,
                    "awarded" => $prod->awarded
                ];
            } else {
                $agrupados[$key]["quantity"] += $prod->qtd;
                $agrupados[$key]["total"] += $totalItem;
            }
        }

        $arrayProdutos = array_values($agrupados);
        // dd($arrayProdutos);
        if ($count <= 0){
            $this->dispatchBrowserEvent('checkToaster', ["message" => "Não foi selecionado artigos!", "status" => "error"]);
            return false;
        }

        $randomNumber = '';
        for ($i = 0; $i < 8; $i++) {
            $randomNumber .= rand(0, 9);
        }

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

        $condicaoPagamento = $this->PaymentConditions;
        // dd($condicaoPagamento);
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
            "obs" => $this->observacaoFinalizarPDF,
            "delivery" => $resultLoja[0],
            "store" => $loja,
            "payment_conditions" => $condicaoPagamento,
            "salesman_number" => Auth::user()->id_phc,
            "type" => "order",
            "visit_id" => $this->visitaCheck,
            "address" => $this->moradaFinalizar,
            "city" => $this->locFinalizar,
            "zipcode" => $this->codpostalFinalizar,
            "scheduled_order" => $this->encomendaProgramada,
            "scheduled_date" => $this->dateFinalizar,
            "lines" => array_values($arrayProdutos)
        ];

        $curl = curl_init();
        // dd($array);
        // dd(json_encode($array), $array);
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
        // dd($array);
        // dd($response);

        curl_close($curl);

        $response_decoded = json_decode($response);
        // dd($response_decoded, env('SANIPOWER_URL_DIGITAL').'/api/documents/orders', json_encode($array), $array);
        if ($response_decoded->success == true) {
            $getEncomenda = Carrinho::where('id_encomenda','!=', "")->where('id_cliente',$idCliente)->first();

           
            ComentariosProdutos::where('id_encomenda', $getEncomenda->id_encomenda)->delete();
            Carrinho::where('id_encomenda', $getEncomenda->id_encomenda)->delete();   
            
            $encomendasArray = $this->clientesRepository->getEncomendasClienteFiltro(10,1,$this->idCliente,$this->nomeCliente,$idCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente,"0","0",$this->startDate,$this->endDate,$this->statusEncomenda);
            $encomenda = $this->clientesRepository->getEncomendaID($response_decoded->id_document);

            $encomenda = json_encode($encomenda->orders[0]);


            $pdf = new Dompdf();
            $pdf = PDF::loadView('pdf.pdfTabelaEncomenda', ["encomenda" => $encomenda]);
        
            $pdf->render();
        
            $pdfContent = $pdf->output();
        
            // $grupos = GrupoEmail::where('local_funcionamento', 'nova_encomenda')->get();
            //         if(isset($grupos)){
            //             $this->emailArray = [];

            //             foreach ($grupos as $grupo) {
            //                 $emails = array_map('trim', explode(',', $grupo->emails));
                    
            //                 $this->emailArray = array_merge($this->emailArray, $emails);
            //             }
                        
            //             $this->emailArray[] = Auth::user()->email;

            //             // array_push($this->emailArray,Auth::user()->email); Esse é o email do utilizador atual
            //             $this->emailArray = array_unique($this->emailArray);
                        
            //             foreach($this->emailArray as $i => $email)
            //             {
            //                 Mail::to($email)->send(new SendEncomenda($pdfContent, json_decode($encomenda, true)));
            //             }

            //         }

            $grupos = GrupoEmail::where('local_funcionamento', 'nova_encomenda')->get();

            if (isset($grupos)) {
                $this->emailArray = [];

                foreach ($grupos as $grupo) {
                    $emails = array_map('trim', explode(',', $grupo->emails));
                    $this->emailArray = array_merge($this->emailArray, $emails);
                }

                // $this->emailArray[] = Auth::user()->email;

                $this->emailArray = array_unique($this->emailArray);

                if (!empty($this->emailArray)) {
                    Mail::to(Auth::user()->email)
                        ->bcc($this->emailArray)
                        ->send(new SendEncomenda($pdfContent, json_decode($encomenda, true)));
                }
            }


            session(['parametroStatusAdjudicar' => null]);

            foreach($encomendasArray["paginator"] as $encomenda){
                $resultadoBudget = str_replace(' Nº', '', $encomenda->order);
                // dd($proposta->budget, $resultadoBudget, $response_decoded->document);
                if($resultadoBudget == $response_decoded->document){

                    $json = json_encode($encomenda);
                    $object = json_decode($json, false);
                    // Session::put('rota','encomendas');
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
    
    public function levantamentoLojaChange()
    {
        $this->levantamentoLoja = true;
        $this->viaturaSanipower = false;
        $this->transportadora = false;
        $this->entrega_obra = false;
        $this->encomendaProgramada = false;
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
        
        $arrayCliente = $this->clientesRepository->getDetalhesCliente($this->idCliente);

        $this->detailsClientes = $arrayCliente["object"];
        
        $this->getCategoriesAll = $this->encomendasRepository->getCategorias();

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

            $this->searchSubFamily = $this->encomendasRepository->getSubFamily($firstCategories->id, $firstFamily->id, $firstSubFamily->id);
          
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
                //     $this->searchSubFamily = $this->encomendasRepository->getSubFamilySearch($this->searchProduct);
                //     session(['Camp' => 1]);
                //     session(['Category' => null]);
                //     session(['Family' => null]);
                // }
            }

                if ($this->searchProduct != "") {

                    $this->searchSubFamily = $this->encomendasRepository->getSubFamilySearch($this->searchProduct);

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
            ->where('id_encomenda', $this->codEncomenda)
            ->orderBy('id', 'desc')
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
      
        if($this->lojas[0] == null){
            // return redirect()->route('encomendas.detail', ['id' => $this->idCliente]);
        }
        $campanhas = Campanhas::where('ativa', 1)
        // ->where('destaque', 1)
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

        // $this->transportadora = false;
        // $this->entrega_obra = false;
        // $this->viaturaSanipower = false;
        // $this->encomendaProgramada = false;
        // $this->levantamentoLoja = false;

        $this->dateFinalizar = now()->addDays(30)->format('Y-m-d');

        $this->moradaFinalizarCli = $this->detailsClientes->customers[0]->address;
        $this->codpostalFinalizarCli = $this->detailsClientes->customers[0]->zipcode;
        $this->locFinalizarCli = $this->detailsClientes->customers[0]->city;

        // $this->getCategoriesAll = $this->encomendasRepository->getCategorias();
        $this->PaymentConditions = $this->detailsClientes->customers[0]->payment_conditions;
        return view('livewire.encomendas.detalhe-encomenda', [
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
