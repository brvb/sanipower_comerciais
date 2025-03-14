<div>
<style>
    @media (max-width: 540px) {
        .container-buttons{
            padding-left: 0.9rem;
            padding-right: 0.9rem;
        }
        .container-buttons .btn-primary{
            font-size: 0.75125rem;
        }
        .title-description{
            font-size: 10px;
        }
    }
    .table-bordered td {
        font-size: 12px;
        padding: 9px 0px;
        text-align: center;
    }
    .table-bordered th {
        font-size: 12px;
        text-align: center;
        padding: 9px 0px;
    }
    #scroll-col-9::-webkit-scrollbar{
        height: 0.6rem;
    }
    #scroll-col-9::-webkit-scrollbar-thumb{
        background-color: rgb(121, 121, 121);
        border-radius: 0.1rem;
    }
    #scroll-col-9::-webkit-scrollbar{
        width: 0.6rem;
    }

    #scroll-col-9::-webkit-scrollbar{
        height: 0.6rem;
    }
    #scroll-col-9::-webkit-scrollbar-thumb{
        background-color: rgb(121, 121, 121);
        border-radius: 0.1rem;
    }
    #scroll-col-9::-webkit-scrollbar{
        width: 0.6rem;
    }

    .navbar2 {
            height: auto;
    }
    #navbar2 {
        height: auto;
        max-height: none; /* Evita restrições de altura */
    }
      #navbar2::-webkit-scrollbar{
        height: 0.6rem;
    }
    #navbar2::-webkit-scrollbar-thumb{
        background-color: rgb(121, 121, 121);
        border-radius: 0.1rem;
    }
    #navbar2::-webkit-scrollbar{
        width: 0.6rem;
    }

    #navbar2::-webkit-scrollbar{
        height: 0.6rem;
    }
    #navbar2::-webkit-scrollbar-thumb{
        background-color: rgb(121, 121, 121);
        border-radius: 0.1rem;
    }
    #navbar2::-webkit-scrollbar{
        width: 0.6rem;
    }
    .navbar-hidden{
        display: none !important;
    }

    .navbar-hidden #scroll-col-9 {
        width: 100%;
    }

</style>
    <!--  LOADING -->
    @if ($showLoaderPrincipal == true)
        <div id="loader" style="display: none;">
            <div class="loader" role="status">
            </div>
        </div>
    @endif

    <!-- FIM LOADING -->

    <!-- TABS  -->

    {{-- <div class="row group-buttons group-buttons d-flex justify-content-end mr-0 mb-2">
        <div class="tools">
            <a href="javascript:void(0);" wire:click="verEncomenda" class="btn btn-sm btn-success"><i class="ti-eye"></i>
                Ver Encomenda</a>
            <a href="javascript:void(0);" class="btn btn-sm btn-primary"><i class="ti-save"></i> Guardar</a>
            <a href="javascript:void(0);" class="btn btn-sm btn-secondary"> Cancelar</a>
        </div>
    </div> --}}

    <div class="card card-tabs-pills mb-3">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a href="#tab4" data-toggle="tab" class="nav-link {{ $tabDetail }}">Detalhes Cliente</a>
                </li>
                <li class="nav-item">
                    <a href="#tab5" data-toggle="tab" class="nav-link {{ $tabProdutos }}">Produtos</a>
                </li>
                <li class="nav-item">
                    <a href="#tab6" data-toggle="tab" class="nav-link {{ $tabDetalhesEncomendas }}">
                        @if($quantidadeLines > 0)
                            <span>({{$quantidadeLines}}) </span>
                        @endif
                        Artigos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#tab7" data-toggle="tab" class="nav-link {{ $tabFinalizar }}">Finalizar</a>
                </li>
            </ul>

            <div class="teste" style="padding-right:35px;">
                <div class="row group-buttons group-buttons d-flex justify-content-end mr-0 mb-2">
                    <div class="tools">
                        {{-- <a href="javascript:void(0);" wire:click="verEncomenda" class="btn btn-sm btn-success"><i
                                class="ti-eye"></i>
                            Ver Encomenda</a> --}}
                        {{-- <a href="javascript:void(0);"  wire:click="finalizarencomenda" class="btn btn-sm btn-primary"><i class="ti-save"></i> Guardar Encomenda</a> --}}
                        <a href="javascript:void(0);" wire:click="Limpar" class="btn btn-sm btn-secondary"> Limpar carrinho</a>
                        
                        <a href="javascript:void(0);" wire:click="voltarAtras" class="btn btn-sm btn-secondary" > Voltar atrás</a>
                        <a href="javascript:void(0);" wire:click="cancelarEncomenda" class="btn btn-sm btn-secondary" > Cancelar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" id="scrollModalBody" style="padding-right: 0;">
            <div class="tab-content">

                <div class="tab-pane fade {{ $tabDetail }}" id="tab4">
                    <h4 class="card-title">{{ $detalhesCliente->customers[0]->name }}</h4>
                    <p class="card-text">

                        <!--  INICIO DOS DETALHES   -->

                    <div class="row form-group">
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Nome do Cliente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-user text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->name }}" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Nº do Cliente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-info-alt text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->no }}" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Nº de Contribuinte</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-marker text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->nif }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Morada</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                              class="ti-location-arrow text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->address }}" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Localidade</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                              class="ti-location-arrow text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                           value="{{ $detalhesCliente->customers[0]->city }}" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Código Postal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-location-arrow text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->zipcode }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Zona do Cliente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-pin text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->zone }}" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Contactos</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-email text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->phone }}" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Nº Propostas em aberto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-comment text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->open_proposals }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Email do Cliente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-light-bulb text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->email }}" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Saldo em Aberto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-money text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ number_format($detalhesCliente->customers[0]->current_account,3) }}€" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Cheques em carteira</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-bag text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->balance_checks }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label>Nº Ocorrências em aberto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-light-bulb text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->open_occurrences }}" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Pontos</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-stats-up text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->balance_points }}" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">

                            <div class="form-group">
                                <label>Condições de pagamento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-credit-card text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ $detalhesCliente->customers[0]->payment_conditions }}" readonly>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!--  FIM DETALHES   -->
                    </p>
                </div>
                <div class="tab-pane fade {{ $tabProdutos }}" id="tab5">

                        <div class="row tab-encomenda-produto">

                            <div class="col" wire:key="select-field-model-version-{{ $iteration }}">

                                <div>
                                    {{-- @dd($getCategories); --}}
                                    @if($isMobile)
                                    @php
                                        $contaCat = 0;
                                    @endphp
                                    @foreach ($getCategoriesAll->category as $i => $cat)
                                        @php
                                            $contaCat++;
                                        @endphp
                                        <div class="subsidebarProd overflow-y-auto" id="subItemInput{{ $contaCat }}">

                                            <div wire:loading wire:target="searchCategory">
                                                <div id="filtroLoader" style="display: block;">
                                                    <div class="filtroLoader" role="status">
                                                    </div>
                                                </div>
                                            </div>

                                            <div wire:loading wire:target="resetFilterEncomenda">
                                                <div id="filtroLoader" style="display: block;">
                                                    <div class="filtroLoader" role="status">
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="javascript:void(0)" class="buttonGoback"><i
                                                    class="ti ti-arrow-left IconGoback"></i>Produtos</a>
                                              
                                            <h2>{{ $cat->name }}</h2>
                                            
                                            <div class="row">
                                            @foreach ($cat->family as $family)
                                            @if ($familyInfo == true)
                                                @if ($idFamilyInfo == $family->id)
                                                {{-- {{dd($familyInfo)}} --}}
                                                    <div class="col-12">
                                                        <div class="row mb-2">
                                                            <a wire:click="resetFilterEncomenda({{ $contaCat }})" class="mb-3 ml-4">
                                                                <i class="ti-angle-left"></i> Atrás
                                                            </a>
                                                        </div>
                                                        <div class="row">
                                                            @foreach ($family->subfamily as $subfamily)
                                                                <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                                                                    <div class="card card-decoration card-outline-primary border border-2">
                                                                        <a href="javascript:void(0);" class="title-description-family" data-id={{$contaCat}} wire:click="searchSubFamily({{ $contaCat }}, {{ json_encode($family->id) }}, {{ json_encode($subfamily->id) }})"
                                                                            style="pointer-events: auto">
                                                                            <div class="mb-1">
                                                                                <img src="https://storage.sanipower.pt/storage/subfamilias/{{ $family->id }}/{{ $subfamily->id }}.jpg"
                                                                                    class="card-img-top" alt="...">

                                                                                <div class="body-decoration">
                                                                                    <h5 class="title-description">{{ $subfamily->name }}</h5>
                                                                                </div>

                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="col-4">
                                                                    <h5 class="title-description-family"
                                                                        wire:click="searchSubFamily({{ $contaCat }}, {{ json_encode($family->id) }}, {{ json_encode($subfamily->id) }})">
                                                                        {{ $subfamily->name }}aqui
                                                                    </h5>
                                                                </div> --}}
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @else
                                                    @if ($idCategoryInfo != $cat->id)
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                                                            <div class="card card-decoration card-outline-primary border border-2">
                                                                <a href="javascript:void(0);" wire:click="searchCategory({{ $contaCat }}, {{ json_encode($family->id) }})"
                                                                    style="pointer-events: auto">
                                                                    <div class="mb-1">
                                                                        @php
                                                                        
                                                                            $familyId = $family->id;
                                                                            $familyIdSemHifen = str_replace('-', '', $familyId);
                                                                            $editado = str_pad($familyIdSemHifen, 4, '0', STR_PAD_LEFT);
                                                                        @endphp
                                                                        <img src="https://storage.sanipower.pt/storage/subfamilias/{{ $editado }}.jpg"
                                                                            class="card-img-top" alt="...">

                                                                        <div class="body-decoration">
                                                                            <h5 class="title-description">{{ $family->name }}</h5>
                                                                        </div>

                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                                                        <div class="card card-decoration card-outline-primary border border-2">
                                                            <a href="javascript:void(0);" wire:click="searchCategory({{ $contaCat }}, {{ json_encode($family->id) }})"
                                                            style="pointer-events: auto">
                                                                <div class="mb-1">
                                                                    @php
                                                                        $familyId = $family->id;
                                                                        $familyIdSemHifen = str_replace('-', '', $familyId);
                                                                        $editado = str_pad($familyIdSemHifen, 4, '0', STR_PAD_LEFT);
                                                                    @endphp
                                                                    <img src="https://storage.sanipower.pt/storage/subfamilias/{{ $editado }}.jpg"
                                                                        class="card-img-top" alt="...">

                                                                    <div class="body-decoration">
                                                                        <h5 class="title-description">{{ $family->name }}</h5>
                                                                    </div>

                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div> --}}

                                                    {{-- <div class="col-4">
                                                        <a href="javascript:void(0);" class="familyHREF{{ $contaCat }}" data-id={{$contaCat}} wire:click="searchCategory({{ $contaCat }}, {{ json_encode($family->id) }})">
                                                            <h5 class="family_title">{{ $family->name }}ss</h5>
                                                        </a>
                                                    </div> --}}
                                                @endif
                                            @else

                                                <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                                                    <div class="card card-decoration card-outline-primary border border-2">
                                                        <a href="javascript:void(0);" wire:click="searchCategory({{ $contaCat }}, {{ json_encode($family->id) }})"
                                                        style="pointer-events: auto">
                                                            <div class="mb-1">
                                                                @php
                                                                    $familyId = $family->id;
                                                                    $familyIdSemHifen = str_replace('-', '', $familyId);
                                                                    $editado = str_pad($familyIdSemHifen, 4, '0', STR_PAD_LEFT);
                                                                @endphp
                                                                <img src="https://storage.sanipower.pt/storage/subfamilias/{{ $editado }}.jpg"
                                                                    class="card-img-top" alt="...">
                                                                {{-- <img src="https://storage.sanipower.pt/storage/subfamilias/0001.jpg" --}}

                                                                <div class="body-decoration">
                                                                    <h5 class="title-description">{{ $family->name }}</h5>
                                                                </div>

                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>

                                                {{-- <div class="col-4">
                                                    <a href="javascript:void(0);" wire:click="searchCategory({{ $contaCat }}, {{ json_encode($family->id) }})">
                                                        <h5 class="family_title">{{ $family->name }}Hello</h5>
                                                    </a>
                                                </div>  --}}
                                            @endif
                                        @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif
                                    <div class="sidebarProd d-md-none d-block" id="sidebarProd" wire:ignore>
                                        <label for="checkbox" style="width: 100%;">
                                            <div class="input-group input-group-config-Goback input-config-produtos"
                                                id="checkboxSidbar" style="padding: 0;">
                                                <label><i class="ti-menu"></i>
                                                    <p>PRODUTOS</p>
                                                </label>
                                            </div>
                                        </label>
                                        @php
                                            $conta = 0;
                                        @endphp
                                        @foreach ($getCategoriesAll->category as $i => $category)
                                            @php
                                                $conta++;
                                            @endphp
                                            @if (!empty($category->family))
                                                
                                                <div class="input-group d-flex input-group-config justify-content-between"
                                                    id="input{{ $conta }}"
                                                    @if ($category->name == 'Sistemas') style="background-color: #42c69f;"
                                                        @elseif($category->name == 'Água') style="background-color: #0179b5;"
                                                        @elseif($category->name == 'Conforto') style="background-color: #cd3d3c;"
                                                        @elseif($category->name == 'Solar') style="background-color: #cc7d3b;"
                                                        @elseif($category->name == 'Ar Condicionado') style="background-color: #9fa2a2;"
                                                        @elseif($category->name == 'Ventilação') style="background-color: #141b62;"
                                                        @elseif($category->name == 'Marcas') style="background-color: #5c2a5d;"
                                                        @elseif($category->name == 'Piscinas') style="background-color: #01cbdf;"
                                                        @elseif($category->name == 'Marcas') style="background-color: #5c2a5d;" @endif>
                                                    <p>{{ $category->name }}</p>
                                                    <label></label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-md-3">
                                            <div class="d-md-none d-block">
                                                <div class="input-group" id="checkboxSidbar">
                                                    <input id="checkbox" type="checkbox">
                                                    <label class="toggle" for="checkbox">
                                                        <div id="bar1" class="bars"></div>
                                                        <div id="bar2" class="bars"></div>
                                                        <div id="bar3" class="bars"></div>
                                                    </label> &nbsp;<h4>Categorias</h4>
                                                </div>
                                            </div>
                                            <div class="d-none d-md-block">
                                                <div class="input-group">
                                                    <button id="toggleNavbar" class="btn btn-sm btn-primary mb-2 k">
                                                        <i id="toggleIcon" class="fa-solid"></i>
                                                    </button>
                                                    &nbsp;<h4 style="margin: 0px;">Categorias</h4>
                                                </div>
                                            </div>
                                            {{-- <div id="dataTables_wrapper" class="dataTables_wrapper container mt-2"
                                                style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                                                <div class="dataTables_length left" id="dataTables_length">
                                                    <label>Mostrar
                                                        <select name="perPage" wire:model="perPage">
                                                            <option value="10"
                                                                @if ($perPage == 10) selected @endif>10
                                                            </option>
                                                            <option value="25"
                                                                @if ($perPage == 25) selected @endif>25
                                                            </option>
                                                            <option value="50"
                                                                @if ($perPage == 50) selected @endif>50
                                                            </option>
                                                            <option value="100"
                                                                @if ($perPage == 100) selected @endif>100
                                                            </option>
                                                        </select>
                                                        registos</label>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="col-md col-12">
                                            @php
                                                $searchNameCategory = session('searchNameCategory');
                                                $searchNameFamily = session('searchNameFamily');
                                                $searchNameSubFamily = session('searchNameSubFamily');
                                                $searchProduct = session('searchProduct');
                                                $specificProductS = session('specificProduct');
                                            @endphp
                                            {{-- @dd($searchNameSubFamily); --}}
                                            <ol class="breadcrumb d-flex" style="border-bottom:none;">
                                                @if($searchProduct == "")  @if($searchNameCategory)<li class="breadcrumb-item"><a style="color:#1791ba;" wire:click = "ShowFamily({{ session('CatID') }})">{{$searchNameCategory}}</a></li>@endif
                                                @if($searchNameFamily)<li class="breadcrumb-item"> <a style="color:#1791ba;" wire:click = "ShowSubFamily('{{ session('FamilyID') }}', '{{ session('CatID') }}')">{{$searchNameFamily}}</a></li>@endif @else <li class="breadcrumb-item active"><a style="color:#1791ba;" wire:click = "recuarLista">{{$searchProduct}}</a></li> @endif
                                                {{-- @if($searchNameSubFamily) --}}
                                                    <li class="breadcrumb-item active">
                                                        @if($specificProductS == 1)
                                                        {{-- @dd('AQUI'); --}}
                                                            <a href="#"
                                                            id="recuar-lista-link"
                                                            onclick="
                                                                if (!this.getAttribute('data-clicked')) {
                                                                    this.setAttribute('data-clicked', 'true');
                                                                    this.style.pointerEvents = 'none'; 
                                                                    this.style.opacity = '0.5';
                                                                    @this.call('recuarLista');
                                                                }
                                                            ">
                                                                @if($searchProduct != "")  @else {{$searchNameSubFamily}} @endif
                                                            </a>
                                                        @else
                                                            <a href="#">{{$searchNameSubFamily}}</a>
                                                        @endif
                                                    </li>
                                                {{-- @endif --}}
                                            </ol>
                                        </div>
                                        <div class="col-6 col-md">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text search"><i
                                                            class="ti-search text-light"></i></span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    placeholder="Pesquise Produto" wire:model.lazy="searchProduct"
                                                    @if (session('searchProduct') !== null) value="{{ session('searchProduct') }}" @endif>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="row" style="justify-content: flex-end;">
                                            <div id="navbar2" class="navbar2 col-3 d-none d-md-block" style="overflow-y:auto;max-height: 67vh">                                            {{-- <span id="navbar2"> --}}
                                                @php
                                                    $contaCat = 0;
                                                @endphp
                                                @foreach ($getCategoriesAll->category as $i => $category)
                                                    @php
                                                        $contaCat++;
                                                    @endphp
                                                    @if (!empty($category->family))
                                                        <button class="accordion2" style="background: #5f77921c;"><a style = "color:black; text-decoration: underline;" wire:click = "ShowFamily({{ $category->id }})">{{ $category->id }} -
                                                            {{ $category->name }}</a><span class="arrow"><i class="fa-regular fa-square-caret-down"></i></span></button>
                                                        <div class="panel2">
                                                            @foreach ($category->family as $family)
                                                                <button class="accordion2" style="background-color: #1791ba26;"><a style = "color:black; text-decoration: underline;" wire:click = "ShowSubFamily('{{ $family->id }}', '{{ $category->id }}')">{{ $family->id }} -
                                                                    {{ $family->name }}</a><span class="arrow"><i class="fa-regular fa-square-caret-down"></i></span></button>
                                                                <div class="panel2">
                                                                    @foreach ($family->subfamily as $subfamily)
                                                                        <a wire:click="searchSubFamily({{ $category->id }},{{ json_encode($family->id) }},{{ json_encode($subfamily->id) }})"
                                                                            href="#">{{ $subfamily->id }} -
                                                                            {{ $subfamily->name }}</a>
                                                                    @endforeach
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            
                                                <!-- Aqui você pode adicionar um item manual para campanhas -->
                                                {{-- <button class="accordion2" style="background-color: #ffcc00;" wire:click="ShowCampanhas">Campanhas<span class="arrow"><i class="fa-regular fa-square-caret-down"></i></span></button> --}}
                                                <button class="accordion2" style="background-color: #ffcc00;" wire:click="ShowCampanhas">Campanhas</button>
                                                {{-- <div class="panel2">
                                                    <!-- Aqui você pode adicionar o conteúdo de campanhas -->
                                                    @foreach ($campanhas as $campanha)
                                                        <a wire:click="searchCampanha({{ $campanha->bostamp }})" href="#"> {{ $campanha->titulo }}</a>
                                                    @endforeach
                                                </div> --}}
                                            {{-- <span> --}}

                                        </div>
                                 
                                    <div id="scroll-col-9" class="col-md-9" style="overflow-y:auto;padding-right: 0;padding-left: 0;max-height: 67vh">

                                        @if ($specificProduct == 0)
                                            <div class="row">
                                                {{-- <div wire:loading wire:target="searchProduct">
                                                    <div id="filtroLoader" style="display: block;">
                                                        <div class="filtroLoader" role="status">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div wire:loading wire:target="adicionarProduto">
                                                    <div id="filtroLoader" style="display: block;">
                                                        <div class="filtroLoader" role="status">
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div wire:loading wire:target="openDetailProduto">
                                                    <div id="filtroLoader" style="display: block;">
                                                        <div class="filtroLoader" role="status">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- @dd(session('Category')) --}}
                                                @if (session('Category') != null)
                                                    @php
                                                        $valueCat = session('Category') - 1;
                                                    @endphp
                                                    {{-- @dd($getCategories->category[$valueCat]); --}}
                                                        @foreach ($getCategoriesAll->category[$valueCat]->family as $family)
                                                            @php
                                                                $familyId = $family->id;
                                                                $familyIdSemHifen = str_replace('-', '', $familyId);
                                                                $editado = str_pad($familyIdSemHifen, 4, '0', STR_PAD_LEFT);
                                                                $valueCatEnv = $valueCat + 1;
                                                            @endphp
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                                                            <div class="card card-decoration card-outline-primary border border-2" style="cursor:pointer;" wire:click="ShowSubFamily('{{ $family->id }}', '{{ $valueCatEnv }}')">
                                                                    {{-- <a href="javascript:void(0)"
                                                                    wire:click="openDetailProduto({{ json_encode($cam->category_number) }},{{ json_encode($prodt->family_number) }},{{ json_encode($prodt->subfamily_number) }},{{ json_encode($prodt->product_number) }},{{ json_encode($detalhesCliente->customers[0]->no) }},{{ json_encode($prodt->product_name) }})"
                                                                    style="pointer-events: auto"> --}}
                                                                        <div class="mb-1">
                                                                            <img src="https://storage.sanipower.pt/storage/subfamilias/{{ $editado }}.jpg"
                                                                                class="card-img-top" alt="...">
                                                                            <div class="body-decoration">
                                                                                <h5 class="title-description">{{ $family->name }}</h5>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <div class="card-body container-buttons" style="z-index:10;">
                                                                        <button class="btn btn-sm btn-primary" wire:click="ShowSubFamily('{{ $family->id }}', '{{ $valueCatEnv }}')">
                                                                            <i class="ti-shopping-cart"></i><span> Ver SubFamilias </span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                     <!-- Links de paginação -->
                                                     {{-- <div class="d-flex justify-content-center">
                                                         {{ $products->links('vendor.pagination.livewire-bootstrap') }}
                                                     </div> --}}
                                                @else
                                                @if (session('Family') != null && session('CatID') != null)
                                                    @php
                                                        $valueCat = session('CatID') - 1;
                                                        $valueFam = session('Family');
                                                        $valueCatEnv = session('CatID');
                                                        // dd($valueCat, $valueFam);
                                                    @endphp
                                                    {{-- @dd($getCategories->category[$valueCat]); --}}
                                                        @foreach ($getCategoriesAll->category[$valueCat]->family as $family)
                                                        @if ($family->id == $valueFam)
                                                        {{-- @dd($family); --}}
                                                        @foreach ($family->subfamily as $subfamily)
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                                                            <div class="card card-decoration card-outline-primary border border-2" style="cursor:pointer;" wire:click="searchSubFamily({{ $valueCatEnv }},{{ json_encode($valueFam) }},{{ json_encode($subfamily->id) }})">
                                                                    {{-- <a href="javascript:void(0)"
                                                                    wire:click="openDetailProduto({{ json_encode($cam->category_number) }},{{ json_encode($prodt->family_number) }},{{ json_encode($prodt->subfamily_number) }},{{ json_encode($prodt->product_number) }},{{ json_encode($detalhesCliente->customers[0]->no) }},{{ json_encode($prodt->product_name) }})"
                                                                    style="pointer-events: auto"> --}}
                                                                        <div class="mb-1">
                                                                            <img src="https://storage.sanipower.pt/storage/subfamilias/{{ $family->id }}/{{ $subfamily->id }}.jpg"
                                                                                class="card-img-top" alt="...">
                                                                            <div class="body-decoration">
                                                                                <h5 class="title-description">{{ $subfamily->name }}</h5>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <div class="card-body container-buttons" style="z-index:10;">
                                                                        <button class="btn btn-sm btn-primary" wire:click="searchSubFamily({{ $valueCatEnv }},{{ json_encode($valueFam) }},{{ json_encode($subfamily->id) }})">
                                                                            <i class="ti-shopping-cart"></i><span> Ver Produtos </span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @endif
                                                        @endforeach
                                                     <!-- Links de paginação -->
                                                     {{-- <div class="d-flex justify-content-center">
                                                         {{ $products->links('vendor.pagination.livewire-bootstrap') }}
                                                     </div> --}}
                                                @else
                                                @if (session('Camp') == 0)
                                                    @if($campanhas->count())
                                                        @foreach ($campanhas as $cam)
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                                                            <div class="card card-decoration card-outline-primary border border-2">
                                                                    {{-- <a href="javascript:void(0)"
                                                                    wire:click="openDetailProduto({{ json_encode($cam->category_number) }},{{ json_encode($prodt->family_number) }},{{ json_encode($prodt->subfamily_number) }},{{ json_encode($prodt->product_number) }},{{ json_encode($detalhesCliente->customers[0]->no) }},{{ json_encode($prodt->product_name) }})"
                                                                    style="pointer-events: auto"> --}}
                                                                        <div class="mb-1">
                                                                            <img src="https://storage.sanipower.pt/storage/{{ $cam->capa }}"
                                                                                class="card-img-top" alt="...">
                                                                            <div class="body-decoration">
                                                                                <h5 class="title-description">{{ $cam->titulo }}</h5>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <div class="card-body container-buttons" style="z-index:10;">
                                                                        <button class="btn btn-sm btn-primary" wire:click="GetprodCamp('{{ $cam->bostamp }}')">
                                                                            <i class="ti-shopping-cart"></i><span> Ver Produtos </span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                     <!-- Links de paginação -->
                                                     {{-- <div class="d-flex justify-content-center">
                                                         {{ $products->links('vendor.pagination.livewire-bootstrap') }}
                                                     </div> --}}
                                                    @else
                                                        <p>Sem Campanhas para exibir.</p>
                                                    @endif 
                                                @else
                                                    @if(session('CampProds') !== null)
                                                        @if($products->count())
                                                            @foreach ($products as $prodt)
                                                                <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                                                                    <div class="card card-decoration card-outline-primary border border-2">
                                                                        <a href="javascript:void(0)"
                                                                            wire:click="openDetailProduto({{ json_encode($prodt->category_number) }},{{ json_encode($prodt->family_number) }},{{ json_encode($prodt->subFamily_number) }},{{ json_encode($prodt->product_number) }},{{ json_encode($detalhesCliente->customers[0]->no) }},{{ json_encode($prodt->product_name) }})"
                                                                            style="pointer-events: auto">
                                                                            <div class="mb-1">
                                                                                <img src="https://storage.sanipower.pt/storage/produtos/{{ $prodt->family_number }}/{{ $prodt->family_number }}-{{ $prodt->subFamily_number }}-{{ $prodt->product_number }}.jpg"
                                                                                    class="card-img-top" alt="...">
                                                                                <div class="body-decoration">
                                                                                    <h5 class="title-description">{{ $prodt->product_name }}</h5>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                        <div class="card-body container-buttons" style="z-index:10;">
                                                                            <button class="btn btn-sm btn-primary"
                                                                                    wire:click="adicionarProduto({{ json_encode($prodt->category_number) }},{{ json_encode($prodt->family_number) }},{{ json_encode($prodt->subFamily_number) }},{{ json_encode($prodt->product_number) }},{{ json_encode($detalhesCliente->customers[0]->no) }},{{ json_encode($prodt->product_name) }})"> 
                                                                                <i class="ti-shopping-cart"></i><span> Compra rápida</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <!-- Links de paginação -->
                                                            {{-- <div class="d-flex justify-content-center">
                                                                {{ $products->links('vendor.pagination.livewire-bootstrap') }}
                                                            </div> --}}
                                                        @else
                                                            <p>Sem produtos para exibir.</p>
                                                        @endif
                                                    @else
                                                        @php
                                                            $searchSubFamily = session('searchSubFamily');
                                                        @endphp
                                                        @if($products->count())
                                                            @foreach ($products as $prodt)
                                                                <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                                                                    <div class="card card-decoration card-outline-primary border border-2">
                                                                        <a href="javascript:void(0)"
                                                                            wire:click="openDetailProduto({{ json_encode($prodt->category_number) }},{{ json_encode($prodt->family_number) }},{{ json_encode($prodt->subfamily_number) }},{{ json_encode($prodt->product_number) }},{{ json_encode($detalhesCliente->customers[0]->no) }},{{ json_encode($prodt->product_name) }})"
                                                                            style="pointer-events: auto">
                                                                        
                                                                            <div class="mb-1">
                                                                                <img src="https://storage.sanipower.pt/storage/produtos/{{ $prodt->family_number }}/{{ $prodt->family_number }}-{{ $prodt->subfamily_number }}-{{ $prodt->product_number }}.jpg"
                                                                                    class="card-img-top" alt="...">
                                                                                <div class="body-decoration">
                                                                                    <h5 class="title-description">{{ $prodt->product_name }}</h5>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                        <div class="card-body container-buttons" style="z-index:10;">
                                                                            <button class="btn btn-sm btn-primary"
                                                                                    wire:click="adicionarProduto({{ json_encode($prodt->category_number) }},{{ json_encode($prodt->family_number) }},{{ json_encode($prodt->subfamily_number) }},{{ json_encode($prodt->product_number) }},{{ json_encode($detalhesCliente->customers[0]->no) }},{{ json_encode($prodt->product_name) }})"> 
                                                                                <i class="ti-shopping-cart"></i><span> Compra rápida</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <!-- Links de paginação -->
                                                            <div class="d-flex justify-content-center" style="margin-left: 15px;">
                                                                {{ $products->links('vendor.pagination.livewire-bootstrap') }}
                                                            </div>
                                                        @else
                                                            <p>Sem produtos para exibir.</p>
                                                        @endif
                                                    @endif 
                                                @endif
                                            @endif
                                            @endif
                                                </div>
                                            @else
                                                <div class="tab-encomenda-produto">
                                                    {{-- <div class="row mb-2 border-bottom">
                                                        <a href="javascript:void(0)" wire:click="recuarLista" class="mb-3 ml-4"><i
                                                            class="ti-angle-left"></i> Atrás</a>
                                                    </div> --}}
                                                    @php

                                                        $detailProduto = session('detailProduto');
                                                        $produtoNameDetail = session('productNameDetail');
                                                        $family = session('family');
                                                        $subFamily = session('subFamily');
                                                        $productNumber = session('productNumber');
                                                        
                                                    @endphp
                                                    <div class="container-fluid container-detalhes-produto" style="padding-right: 0;">
                                                        <div class="row">
                                                            <div class="col-12 d-flex flex-wrap row" style="padding-right: 0 !important;">
                                                                <div class="d-none d-xxl-block col-xxl-2">
                                                                    <img src="https://storage.sanipower.pt/storage/produtos/{{ $family }}/{{ $family }}-{{ $subFamily }}-{{ $productNumber }}.jpg" width="100%">
                                                                </div>
                                                                @php
                                                                    $ref = "https://storage.sanipower.pt/storage/produtos/$family/$family-$subFamily-$productNumber.jpg";
                                                                @endphp
                                                                <div class="col-12 col-xxl-10"  style="padding-right: 0 !important;">
                                                                    <div class="row">
                                                                        <div class="col-12 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-12 d-flex align-items-center pl-2 row">
                                                                                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 d-xxl-none">
                                                                                        <img src="https://storage.sanipower.pt/storage/produtos/{{ $family }}/{{ $family }}-{{ $subFamily }}-{{ $productNumber }}.jpg" width="100%">
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <h3 id="detailNameProduct">{{ $produtoNameDetail }}</h3>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="table-responsive" style="overflow-x:auto;">
                                                                            <table class="table table-bordered table-hover" style="min-width: 580px; min-height: 270px;">
                                                                                <thead class="thead-light">
                                                                                    <tr>
                                                                                        <th style="width: 15%;">Referência</th>
                                                                                        <th style="width: 10%;">Modelo</th>
                                                                                        <th style="width: 10%;">PVP</th>
                                                                                        <th style="width: 10%;">Desconto</th>
                                                                                        {{-- <th>Desconto 2</th> --}}
                                                                                        <th style="width: 10%;">Preço</th>
                                                                                        <th style="width: 10%;">Mín.</th>
                                                                                        <th style="width: 10%;">Stock</th>
                                                                                        <th style="width: 80px;">Qtd.</th>
                                                                                        <th class="width: 13%;">Ações</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                
                                                                                    @if (!empty($detailProduto) || isset($detailProduto->product))
                                                                                        @foreach ($detailProduto->product as $i => $prod)
                                                                                            <tr style="background-color:{{ $prod->color }}">
                                                                                                <td>{{ $prod->referense }}</td>
                                                                                                <td>{{ $prod->model }}</td>
                                                                                                <td>{{ number_format($prod->pvp, 3) }}€</td>
                                                                                                <td>{{ $prod->discount }}</td>
                                                                                                <td>{{ number_format($prod->price, 3) }}€</td>
                                                                                                <td>{{ $prod->quantity }}</td>
                                                                                                <td style="text-align:center;font-size:large;position:relative;">
                                                                                                    @if ($prod->in_stock == true)
                                                                                                        <a class="popover-test" data-toggle="tooltip" data-placement="top" title="Clique para ver os valores">
                                                                                                            <div class="dropdownIcon">
                                                                                                                <i class="ti-check text-lg text-forest dropdownIcon-toggle"></i>
                                                                                                                <ul class="dropdownIcon-menu" style="position:absolute; z-index:999999;">
                                                                                                                    <li><i class="fa fa-play icon-play"></i></li>
                                                                                                                    <li style="border-bottom: 1px solid;">
                                                                                                                        <h5 style = "text-align: left; margin:2px; font-weight: 600;">Stocks em loja</h5>
                                                                                                                    </li>
                                                                                                                    @foreach ($prod->stocks as $stock)
                                                                                                                        <li style = "padding:5px; display: flex; justify-content: space-between; border-bottom: 1px solid #000;">
                                                                                                                        <span>{{ $stock->warehouse_description }}</span>
                                                                                                                            <span>{{ $stock->qtt }}</span>
                                                                                                                        </li>
                                                                                                                    @endforeach
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        </a>
                                                                                                    @else
                                                                                                        <a href="javascript:;" role="button" class="popover-test" data-toggle="popover" aria-describedby="popover817393">
                                                                                                            <i class="ti-close text-lg text-chili"></i>
                                                                                                        </a>
                                                                                                    @endif
                                                                                                </td>
                                                                                                <td><input type="number" style="width: 60px;" class="form-control produto-quantidade" id="{{$i}}" data-qtd="{{ $prod->quantity }}" data-i="{{$i}}" wire:model.defer="produtosRapida.{{$i}}"></td>
                                                                                                <td class="text-center">
                                                                                                    <div class="d-flex justify-content-around">
                                                                                                    
                                                                                                        <button class="btn btn-sm btn-outline-secondary">
                                                                                                            
                                                                                                            <a class="popover-test" data-toggle="tooltip" data-placement="top" title="Clique para ver os valores">
                                                                                                                <div class="dropdownIcon">
                                                                                                                    <i class="ti-package text-light dropdownIcon-toggle" style="margin:0;padding:0;"></i>
                                                                                    
                                                                                                                
                                                                                                                    <ul class="dropdownIcon-menu" style="color:black;left:-350px!important;">
                                                                                                                        <li><i class="fa fa-play icon-play"></i></li>
                                                                                                                        <li style="border-bottom: 1px solid;">
                                                                                                                            <h6>Quantidade p/Caixa</h6>
                                                                                                                        </li>
                                                                                                                    
                                                                                                                        <li>
                                                                                                                            <div class="row">
                                                                                                                            
                                                                                                                                <div class="col-4">
                                                                                                                                    <img src="https://www.sanipower.pt/img/cx-pequena.svg" alt="Caixa Pequena">
                                                                                                                                    {{$prod->quantity_box->small}}
                                                                                                                                </div>
                                                                                                                                <div class="col-4">
                                                                                                                                    <img src="https://www.sanipower.pt/img/cx-grande.svg" alt="Caixa Grande">
                                                                                                                                    {{$prod->quantity_box->big}}
                                                                                                                                </div>
                                                                                                                                <div class="col-4">
                                                                                                                                    <img src="https://www.sanipower.pt/img/palete.svg" alt="Palete">
                                                                                                                                    {{$prod->quantity_box->pallet}}
                                                                                                                                </div>
                                                                                                                            
                                                                                                                            </div>
                                                                                                                        </li>  
                                                                                                                    
                                                                                                                    </ul>
                                                                                                                </div>
                                                                                                            </a>
                                                                                                        </button>
                                                                                                        <div class="dropdown">
                                                                                                            @if ($prod->color == '#41c6a0')
                                                                                                            <button class="btn btn-sm btn-outline-secondary" id="commentProductEncomenda{{$i}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style = "Display: none;">
                                                                                                                <i class="ti-comment"></i>
                                                                                                            </button>
                                                                                                            <div style ="padding-right:20px; padding-left:20px;"></div>
                                                                                                            @else
                                                                                                            <button class="btn btn-sm btn-outline-secondary" id="commentProductEncomenda{{$i}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                                <i class="ti-comment"></i>
                                                                                                            </button>
                                                                                                            @endif
                                                                                                            <div class="dropdown-menu" aria-labelledby="commentProductEncomenda{{$i}}" style="min-width: 200px; left: -235px; top: -13px;">
                                                                                                                <li>
                                                                                                                    <h6 class="modal-title" style="color:#212529; display: flex; justify-content: space-around; margin: 5px 0;">
                                                                                                                        <span>Comentário</span>
                                                                                                                        <button class="btn btn-sm btn-success" id="addCommentEncomenda{{$i}}" disabled>
                                                                                                                            <i class="ti-check"></i>
                                                                                                                        </button>
                                                                                                                    </h6>
                                                                                                                    <textarea type="text" class="form-control {{ $prod->color }}" id="addTextosEncomenda{{$i}}" cols="7" rows="4" style="resize: none;" wire:model.defer="produtosComment.{{$i}}"></textarea>
                                                                                                                </li>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        {{-- <button wire:click="addProductQuickBuyProposta({{$i}},'{{ $produtoNameDetail }}',{{$detalhesCliente->customers[0]->no}},'{{$ref}}','{{$codEncomenda}}')" class="btn btn-sm btn-outline-secondary" id="addProductProposta{{$i}}" disabled>
                                                                                                            <i class="ti-notepad text-light"></i>
                                                                                                        </button> --}}
                                                                                                        <button wire:click="addProductQuickBuyEncomenda({{$i}},'{{ $produtoNameDetail }}',{{$detalhesCliente->customers[0]->no}},'{{$ref}}','{{$codEncomenda}}')" class="btn btn-sm btn-outline-secondary" id="addProductEncomenda{{$i}}" disabled>
                                                                                                            <i class="ti-shopping-cart text-light"></i>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div style="display: flex;justify-content: space-between;width: 100%;">
                                                                            <div class="container-buttons-produtos">
                                                                                <div>
                                                                                    <button class="btn btn-md btn-primary"><i class="ti-file"></i> Ficha do Produto</button>
                                                                                </div>
                                                                                <div>
                                                                                    <button class="btn btn-md btn-primary"><i class="ti-info"></i> Descrição Produto</button>
                                                                                </div>
                                                                                <div>
                                                                                    <button class="btn btn-md btn-primary"><i class="ti-file"></i> Manuais Certificados</button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="container-buttons-produtos">
                                                                                <div>
                                                                                    <button class="btn btn-md btn-primary" wire:click="CleanAll"><i class="ti-close"></i> Limpar Seleção</button>
                                                                                </div>
                                                                                <div>
                                                                                    <button class="btn btn-md btn-success" id="addAllButton" wire:click="addAll('{{$produtoNameDetail}}',{{$detalhesCliente->customers[0]->no}}, '{{ $ref }}','{{$codEncomenda}}')"><i class="ti-shopping-cart" disabled></i> Adicionar Todos </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                            {{-- aqui --}}
                                      
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
   
            <div class="tab-pane fade {{ $tabDetalhesEncomendas }} m-3" id="tab6" style="border: none;">
             @php
                $ValorTotal = 0;
                $ValorTotalComIva = 0;
            @endphp
                <div class="row" style="align-items: center;">
                    @if($allkit)
                    <div class="col-md-12 p-0">
                    
                        <table class="table init-datatable">
                            <thead class="thead-light">
                                <tr style="background:#d6d8db78;">
                                    {{-- <th style="width: 0;"></th> --}}
                                    <th style="width: 11%;">Referência</th>
                                    <th>Produto</th>
                                    <th style=" text-align: right;width: 0%;">PVP</th>
                                    <th style=" text-align: right;width: 0%;" class="d-none d-md-table-cell">Desc</th>
                                    <th style=" text-align: right;width: 0%;">P(c/desc.)</th>
                                    <th style=" text-align: right;width: 0%;">Qtd</th>
                                    <th style=" text-align: right;width: 0%;">Iva</th>
                                    <th></th>
                                    <th style=" text-align: right; " >Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php 
                                $cont = 1;
                            @endphp
                            @forelse ($arrayCart as $img => $prod)
                                @php 
                                    $cont++;
                                @endphp
                                @if($prod->inkit == 1)

                                        @php
                                            $totalItem = $prod->price * $prod->qtd;
                                            $totalItemComIva = $totalItem + ($totalItem * ($prod->iva / 100));
                                            $ValorTotal += $totalItem;
                                            $ValorTotalComIva += $totalItemComIva;
                                        @endphp
                                        <tr data-href="#"  style="border-top:1px solid #9696969c!important; border-bottom:1px solid #9696969c!important;">
                                            {{-- <td>
                                                <div class="form-checkbox">
                                                    <label>
                                                        @php
                                                            $referencia = $prod->referencia;
                                                            $referenciaCorrigida = str_replace('.', '£', $referencia);

                                                            
                                                            $designacao = $prod->designacao;
                                                            $designacaoCorrigida = str_replace('.', '£', $designacao);
                                                        @endphp
                                                        <input type="checkbox" class="checkboxAddKit" data-id="{{ $prod->id }}" 
                                                            wire:model.defer="selectedItemsRemoveKit.[{{ json_encode($prod->id) }},{{ json_encode($referenciaCorrigida) }},{{ json_encode($designacaoCorrigida) }}]">
                                                        <span class="checkmark" style="font-size: 12px;"><i class="fa fa-check pick"></i></span>
                                                    </label>
                                                </div>
                                            </td> --}}
                                          
                                            <td>{{ $prod->referencia }}</td>
                                            <td>
                                                @if (strpos($prod->designacao, $prod->model) === false)
                                                    {{ $prod->model }}
                                                @endif

                                            <br><small style="color:#1791ba">{{ $prod->proposta_info }}</small>&nbsp;<small style="color:#1791ba">Visita nº {{ $prod->id_visita }}</small></td>
                                            <td>
                                                @php
                                                    $comentarios = \App\Models\ComentariosProdutos::where('tipo','encomenda')->where('id_encomenda',$codEncomenda)->where('id_carrinho_compras',$prod->id)->first();
                                                @endphp
                                                 @if(isset($comentarios))
                                                 @if($comentarios != null)
                                                     {{$comentarios->comentario}}
                                                 @endif
                                                 @endif
                                            </td>
                                            <td style="text-align: right; white-space: nowrap;"></td>
                                            <td class="d-none d-md-table-cell"  style="text-align: right; white-space: nowrap;"></td>
                                            <td style=" text-align: right; white-space: nowrap;"></td>
                                            <td style=" text-align: right; white-space: nowrap;">{{ $prod->qtd }}</td>
                                            <td style=" text-align: right; white-space: nowrap;">
                                                <select class="form-control" name="ivaInKit"wire:change='ivaInKit' wire:model.lazy="valueIvaInKit" style="position: relative;width: 61px;left: 12px;">
                                                    <option value="22">22</option>
                                                    <option value="12">12</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </td>
                                            <td style=" text-align: right; width:5%"> <i class="fas fa-trash-alt text-primary" wire:click="deletar(`{{ $prod->referencia }}`,`{{ $prod->designacao }}`,`{{ $prod->model }}`,`{{ $prod->price }}`)"></i> </td>
                                            <td style=" width: 10%; text-align: right; white-space: nowrap;"></td>
                                        </tr>
                                    @endif
                                    @if($prod->inkit == 0)
                                        @php
                                            $totalItem = $prod->price * $prod->qtd;
                                            $totalItemComIva = $totalItem + ($totalItem * ($prod->iva / 100));
                                            $ValorTotal += $totalItem;
                                            $ValorTotalComIva += $totalItemComIva;
                                        @endphp
                                        <tr data-href="#" style="border-top:1px solid #9696969c!important; border-bottom:1px solid #9696969c!important;">
                                            {{-- <td>
                                                <div class="form-checkbox">
                                                    <label>
                                                        @php
                                                            $referencia = $prod->referencia;
                                                            $referenciaCorrigida = str_replace('.', '£', $referencia);

                                                            
                                                            $designacao = $prod->designacao;
                                                            $designacaoCorrigida = str_replace('.', '£', $designacao);
                                                        @endphp
                                                        <input type="checkbox" class="checkboxAddKit" data-id="{{ $prod->id }}" 
                                                            wire:model.defer="selectedItemsAddKit.[{{ json_encode($prod->id) }},{{ json_encode($referenciaCorrigida) }},{{ json_encode($designacaoCorrigida) }}]">
                                                        <span class="checkmark" style="font-size: 12px;"><i class="fa fa-check pick"></i></span>
                                                    </label>
                                                </div>
                                            </td> --}}
                                            <td>{{ $prod->referencia }}</td>
                                            <td>{{ $prod->designacao }}  {{$prod->model}}
                                            @php
                                                    $comentarios = \App\Models\ComentariosProdutos::where('tipo','encomenda')->where('id_encomenda',$codEncomenda)->where('id_carrinho_compras',$prod->id)->first();
                                                @endphp
                                                  @if(isset($comentarios))
                                                  @if($comentarios != null)
                                                    <br>
                                                    <small style="color:#afba17;">
                                                        {{$comentarios->comentario}}
                                                    </small>
                                                  @endif
                                                @endif
                                            
                                            <br><small style="color:#1791ba">{{ $prod->proposta_info }}</small>@if($prod->id_visita != null) &nbsp;<small style="color:#1791ba">Visita nº {{ $prod->id_visita }}</small> @endif</td>
                                            {{-- <td>
                                                @php
                                                    $comentarios = \App\Models\ComentariosProdutos::where('tipo','encomenda')->where('id_encomenda',$codEncomenda)->where('id_carrinho_compras',$prod->id)->first();
                                                @endphp
                                                  @if(isset($comentarios))
                                                  @if($comentarios != null)
                                                      {{$comentarios->comentario}}
                                                  @endif
                                                @endif
                                            </td> --}}
                                            <td style="text-align: right; white-space: nowrap;">{{ number_format($prod->pvp, 3, ',', '.') }} €</td>
                                            <td class="d-none d-md-table-cell"  style="text-align: right; white-space: nowrap;">{{ $prod->discount }}%@if ($prod->discount2 != "0" && $prod->discount2 != null)+{{ $prod->discount2 }}%@endif</td>
                                            <td style=" text-align: right; white-space: nowrap;">{{ number_format($prod->price, 3, ',', '.') }} €</td>
                                             @if($prod->in_campanhas == 1)
                                                <td style="text-align: right; white-space: nowrap;">
                                                    {{ $prod->qtd }}
                                                </td>
                                            @else
                                                @if($prod->id_proposta != "")
                                                    <td style="text-align: right; white-space: nowrap;">
                                                        {{ $prod->qtd }}
                                                    </td>
                                                @else
                                                    <td style="text-align: right; white-space: nowrap;">
                                                        <input type="text" 
                                                            style="width: 100%; text-align: right;"
                                                            wire:model.defer="prodtQTD.{{ $cont }}"
                                                            value="{{ $prod->qtd }}"
                                                            placeholder="{{ $prod->qtd }}"
                                                            wire:change="editProductQuickBuyEncomenda({{ $cont }},{{ $prod->referencia }}, '{{ $prod->designacao }}', {{ $detalhesCliente->customers[0]->no }}, '{{ $prod->image_ref }}', '{{ $codEncomenda }}','{{ $prod->price }}')" />
                                                    </td>
                                                @endif
                                            @endif

                                            <td style=" text-align: right; white-space: nowrap;">{{ $prod->iva }} %</td>
                                            <td style=" text-align: right; width:5%"> <i class="fas fa-trash-alt text-primary" wire:click="deletar(`{{ $prod->referencia }}`,`{{ $prod->designacao }}`,`{{ $prod->model }}`,`{{ $prod->price }}`)"></i> </td>
                                            <td style=" width: 10%; text-align: right; white-space: nowrap;">{{ number_format($totalItem, 3, ',', '.') }} €</td>
                                        </tr>
                                    @endif
                               
                            @empty
                                <tr>
                                    <td colspan="8" style="border-top:1px solid #232b58!important; border-bottom:1px solid #232b58!important; text-align:center;">Nenhum produto no carrinho</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{-- <div class="form-checkbox">
                            <label>
                                <input type="checkbox" id="kitCheck" class="kitCheck" wire:model="kitCheck">
                                <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                Adicionar ao Kit
                            </label>
                        </div> --}}
                    </div>
                    {{-- <div class="col-md-12 p-0 d-flex" style="text-align:right;margin-bottom: 15px;justify-content: flex-end;">
                        <div class="btn-Add-itens-kit">
                            <button class="btn btn-md btn-primary" wire:click="AdicionarItemKit"><i class="ti-shopping-cart"></i> Adicionar ao Kit </button>
                        </div>
                        <div class="btn-remove-itens-kit"  style="margin-left: 10px;">
                            <button class="btn btn-md btn-primary" wire:click="RemoverItemKit"><i class="ti-shopping-cart"></i> Remover do Kit </button>
                        </div>
                    </div> --}}
             
                    @endif
      
                </div>
            <div class="row">
                <div class="col-md-12 p-0 text-right" style="border-bottom: none;padding: 0;">
                 
               
                    <br/>
                    <table class="float-right table init-datatable">
                        <tbody>
                            <tr style="background:#d6d8db78;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td >Total s/IVA</td>
                                <td style="width: 10%;white-space: nowrap;" class="bold">{{ number_format($ValorTotal, 3, ',', '.') }} €</td>
                            </tr>
                            <tr style="background:#d6d8db78;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td >Total c/IVA</td>
                                <td style="width: 10%;white-space: nowrap;" class="bold">{{ number_format($ValorTotalComIva, 3, ',', '.') }} €</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="row p-4">
                <div class="col-12 p-0 d-none d-md-table-cell text-right mt-3">
                <a href="#tab7" data-toggle="tab" class="btn btn-primary fundo_azul {{ $tabFinalizar }}" style="color:white;"><i class="las la-angle-right"></i>Finalizar Encomenda</a>
                </div>
                <div class="col-12 pb-3 p-0 d-md-none text-center">
                    <a href="#tab7" data-toggle="tab" class="btn btn-primary fundo_azul" style="color:white;"><i class="las la-angle-right"></i> Finalizar Encomenda</a>
                </div>
            </div> --}}
        </div>

        <div class="tab-pane fade {{ $tabFinalizar }}" id="tab7">

            <p class="card-text">

                
            <div class="row form-group">

                <div class="col-xl-12 col-xs-12">
                     <h5 style="border-bottom:1px solid;padding-bottom:10px;">Os seus dados</h5>
                </div>
                    
                 <div class="col-xl-12 col-xs-12">

                     <div class="form-group">
                         <label>Vossa referência</label>
                         <div class="input-group">
                        
                             <input type="text" class="form-control" wire:model.defer="referenciaFinalizar" maxlength="40">
                         </div>
                     </div>
                 </div>
                 <div class="col-xl-12 col-xs-12">
                     <div class="form-group">
                         <div class="form-group">
                             <label>Observação Interna</label>
                             <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.defer="observacaoFinalizar"></textarea>
                         </div>
                     </div>
                 </div>
                 <div class="col-xl-12 col-xs-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Observação para PDF</label>
                            <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.defer="observacaoFinalizarPDF"></textarea>
                        </div>
                    </div>
                </div>

              
             </div>

             <div class="row form-group">
                 <div class="col-xl-12 col-xs-12">
                     <h5 style="border-bottom:1px solid;padding-bottom:10px;">Dados logísticos</h5>
                 </div>

                 <div class="col-xl-6 col-xs-6 mt-2">

                     <div class="col-xl-12 col-xs-12">
                         <div class="form-checkbox">
                             <label>
                                 <input type="checkbox" id="levantamento_loja" class="checkFinalizar" wire:model.defer="levantamentoLoja" @if($levantamentoLoja == true) checked @endif>
                                 <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                 Levantamento em loja
                             </label>
                         </div>
                         
                     </div>
     
                     <div class="col-xl-12 col-xs-12">
                         <div class="form-checkbox">
                             <label>
                                 <input type="checkbox" id="viatura_sanipower" class="checkFinalizar" wire:model.defer="viaturaSanipower">
                                 <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                 Entrega por viatura SANIPOWER
                             </label>
                         </div>
                     </div>

                     <div class="col-xl-12 col-xs-12">
                         <div class="form-checkbox">
                             <label>
                                 <input type="checkbox" id="transportadora" class="checkFinalizar" wire:model.defer="transportadora">
                                 <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                 Entrega por transportadora
                             </label>
                         </div>
                     </div>

                     <div class="col-xl-12 col-xs-12">
                        <div class="form-checkbox">
                            <label>
                                <input type="checkbox" id="entrega_obra" class="checkFinalizar" wire:model.defer="entrega_obra">
                                <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                Entrega em Obra
                            </label>
                        </div>
                    </div>

                 </div>

                 <div class="col-xl-6 col-xs-6 mt-2">

                     <div class="col-xl-12 col-xs-12">
                        <label id="selectLabel" style="display:none;">Selecione loja</label>
  
                        <select class="form-control" id="selectBox" wire:model.defer="lojaFinalizar" style="display:none;">
                            <option selected> Selecione a Loja</option>
                        @foreach ($lojas as $loja)
                            @if (!is_null($loja) && property_exists($loja, 'stores') && $loja->stores)
                                @foreach ($loja->stores as $store)
                                    @if (!is_null($store) && property_exists($store, 'name') && $store->name)
                                        <option value="{{ json_encode($store->name) }}">{{ $store->name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        </select>
                     </div>

                    
                <div class="col-xl-12 col-xs-12">
                    <div class="container mt-4">
                        <div class="row mb-2">
                            <div class="col-12">
                                <label id="SelectMorada" style="display:none;">Morada</label>
                                <input type="text" class="form-control" id="selectBoxMorada" wire:model.defer="moradaFinalizar" style="display:none;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <label id="SelectCodpostal" style="display:none;">Cod. Postal</label>
                                <input type="text" class="form-control" id="selectBoxCodpostal" wire:model.defer="codpostalFinalizar" style="display:none;">
                            </div>
                            <div class="col-3">
                                <label id="SelectLoc" style="display:none;">Localidade</label>
                                <input type="text" class="form-control" id="selectBoxLoc" wire:model.defer="locFinalizar" style="display:none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-xs-12">
                <div class="row form-group mt-4">
                    <div class="col-xl-12 col-xs-12">
                        <h5 style="border-bottom:1px solid;padding-bottom:10px;">Tipo de pagamento</h5>
                    </div>

                    <div class="col-xl-12 col-xs-12 mt-2">
                        <div class="col-xl-12 col-xs-12">
                            <div class="form-checkbox">
                                <label>
                                    <input 
                                        type="checkbox" 
                                        id="PaymentConditions" 
                                        class="PaymentConditions" 
                                        wire:model.defer="PaymentConditions" 
                                        value="{{ $detalhesCliente->customers[0]->payment_conditions }}" disabled>
                                        <span class="checkmark">
                                            <i class="fa fa-check pick"></i>
                                        </span>
                                        
                                    {{ $detalhesCliente->customers[0]->payment_conditions }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-xs-12">
                        <div class="row form-group mt-4">
                            <div class="col-xl-12 col-xs-12">
                                <h5 style="border-bottom:1px solid;padding-bottom:10px;">Encomenda Programada?</h5>
                            </div>
                    
                            <!-- Agrupando Checkbox e Select na mesma linha -->
                            <div class="col-xl-12 col-xs-12 mt-2">
                                <div class="col-xl-12 col-xs-12">
                                    <!-- Checkbox -->
                                    <div class="me-3">
                                        <div class="form-checkbox">
                                            <label>
                                                <input type="checkbox" id="encomendaProgramada" class="checkDate" wire:model.defer="encomendaProgramada">
                                                <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                                Encomenda Programada
                                            </label>
                                        </div>
                                    </div>
                    
                                    <!-- Select (Input de Data) -->
                                    <div class="col-xl-6 col-xs-6">
                                        <label id="selectDate" style="display:none;">Data Programada</label>
                                        <input type="date" class="form-control" id="selectBoxDate" wire:model.defer="dateFinalizar" style="display:none;">                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            let dateInput = document.getElementById("selectBoxDate");
                            let today = new Date();
                            today.setDate(today.getDate() + 30);
                            
                            let minDate = today.toISOString().split("T")[0];
                            dateInput.min = minDate;
                        });
                    </script>
                    
                     {{-- <div class="col-xl-12 col-xs-12">
                         <div class="form-checkbox">
                             <label>
                                 <input type="checkbox" id="pronto_pagamento" class="checkPagamento" wire:model.defer="pagamentoFinalizar">
                                 <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                 Pronto Pagamento
                             </label>
                         </div>
                     </div> --}}
 
                     {{-- <div class="col-xl-12 col-xs-12">
                         <div class="form-checkbox">
                             <label>
                                 <input type="checkbox" id="cheque_entrega" class="checkPagamento" wire:model.defer="chequeFinalizar">
                                 <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                 Cheque a 30 dias contra entrega
                             </label>
                         </div>
                     </div> --}}

                     {{-- <div class="col-xl-12 col-xs-12">
                         <div class="form-checkbox">
                             <label>
                                 <input type="checkbox" id="condicoes_pagamento" class="checkPagamento" wire:model.defer="condicoesFinalizar">
                                 <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                 Condições de pagamento acordadas
                             </label>
                         </div>
                     </div> --}}
                 </div>
                    <div class="row p-4">
                        <div class="col-12 p-0 d-none d-md-table-cell text-right mt-3">
                            <a class="btn btn-primary fundo_azul" style="color:white;" wire:click="finalizarencomenda"><i class="las la-angle-right"></i>Encomendar</a>
                        </div>
                        <div class="col-12 pb-3 p-0 d-md-none text-center">
                            <a class="btn btn-primary fundo_azul w-100" style="color:white;" wire:click="finalizarencomenda"><i class="las la-angle-right"></i> Finalizar Encomenda</a>
                        </div>
                    </div>             
             </div>                
            </div>

            </p>

        </div>


<!-- Modal adicionar compra rapida -->
<div class="modal fade" id="modalProdutos" tabindex="-1" role="dialog" aria-labelledby="modalProdutos"
    aria-hidden="true">
    <div class="modal-dialog modal-xxl modal-dialog-centered" role="document">
        <div class="modal-content">
            @php
                $quickBuyProducts = session('quickBuyProducts');
                $nameProduct = session('productName');
            @endphp
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="modalProdutos">{{ $nameProduct }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $detailProduto = session('detailProduto');
                $produtoNameDetail = session('productNameDetail');
                $family = session('family');
                $subFamily = session('subFamily');
                $productNumber = session('productNumber');
            @endphp
            <div class="col-4 col-md-3" style="padding-left: 0;padding-bottom: 20px; display:none;">
                <img src="https://storage.sanipower.pt/storage/produtos/{{ $family }}/{{ $family }}-{{ $subFamily }}-{{ $productNumber }}.jpg"
                    width=100%>
            </div>
            @php
                $ref = "https://storage.sanipower.pt/storage/produtos/$family/$family-$subFamily-$productNumber.jpg";
            @endphp
            <div class="modal-body" id="scrollModal" style="overflow-y: auto;max-height:500px;">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x:none!important; min-height: 250px;">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Referência</th>
                                        <th>Modelo</th>
                                        <th>PVP (UNI)</th>
                                        <th>Desconto</th>
                                        {{-- <th>Desconto 2</th> --}}
                                        <th>Preço (UNI)</th>
                                        <th>Qtd mínima</th>
                                        <th>Stock</th>
                                        <th>Quantidade</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- adicionar o codigo abaixo quando conseguir repetir o erro --}}
                                    @if (!empty($quickBuyProducts) || isset($quickBuyProducts->product))

                                    {{-- @if (!empty($quickBuyProducts)) --}}
                                        {{-- {{dd($quickBuyProducts)}} --}}
                                        @foreach ($quickBuyProducts->product as $i => $prod)
                                            <tr wire:key="product-{{ $i }}" style="background-color:{{ $prod->color }}" >
                                                <td style = 'width: 18%;'>{{ $prod->referense }}</td>
                                                <td>{{ $prod->model }}</td>
                                                <td>{{ number_format($prod->pvp, 3) }}€</td>
                                                <td>{{ $prod->discount }}</td>
                                                {{-- <td>{{ $prod->discount2 }}</td> --}}
                                                <td>{{ number_format($prod->price, 3) }}€</td>
                                                <td>{{ $prod->quantity }}</td>
                                                <td style="text-align:center;font-size:large;">
                                                    @if ($prod->in_stock == true)
                                                        <a class="popover-test" data-toggle="tooltip" data-placement="top" title="Clique para ver os valores">
                                                            <div class="dropdownIcon">
                                                                <i class="ti-check text-lg text-forest dropdownIcon-toggle"></i>
                                                                <ul class="dropdownIcon-menu">
                                                                    <li><i class="fa fa-play icon-play"></i></li>
                                                                    <li style="border-bottom: 1px solid;">
                                                                         <h5 style = "text-align: left; margin:2px; font-weight: 600;">Stocks em loja</h5>
                                                                    </li>
                                                                    @foreach ($prod->stocks as $stock)
                                                                        <li style = "padding:5px; display: flex; justify-content: space-between; border-bottom: 1px solid #000;">
                                                                            <span>{{ $stock->warehouse_description }}</span>
                                                                            <span>{{ $stock->qtt }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </a>
                                                    @else
                                                        <a href="javascript:;" role="button" class="popover-test" data-toggle="popover" aria-describedby="popover817393">
                                                            <i class="ti-close text-lg text-chili"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control produto-quantidade" data-i="{{$i}}" data-qtd="{{ $prod->quantity }}" id="{{$i}}" wire:model.defer="produtosRapida.{{$i}}">
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-success" id="addProductEncomenda{{$i}}" wire:click="addProductQuickBuyEncomenda({{$i}}, '{{ $nameProduct }}', {{$detalhesCliente->customers[0]->no}}, '{{ $ref }}', '{{ $codEncomenda }}')" disabled>
                                                        <i class="ti-shopping-cart"></i>
                                                    </button>
                                                    <div class="dropdown">
                                                        @if ($prod->color != '#41c6a0')
                                                        <button class="btn btn-sm btn-warning" id="commentProductEncomenda{{$i}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti-comment"></i>
                                                        </button>
                                                    @else
                                                    <button class="btn btn-sm btn-warning" id="commentProductEncomenda{{$i}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style = "Display:none;">
                                                        <i class="ti-comment"></i>
                                                    </button>
                                                    @endif
                                                        <div class="dropdown-menu" aria-labelledby="commentProductEncomenda{{$i}}" style="min-width: 200px; left: -235px; top: -13px;">
                                                            
                                                            <li>
                                                                <h6 class="modal-title" style="color:#212529; display: flex; justify-content: space-around; margin: 5px 0;">
                                                                    <span>Comentário</span>
                                                                    <button class="btn btn-sm btn-success" id="addCommentEncomenda{{$i}}" disabled>
                                                                        <i class="ti-check"></i>
                                                                    </button>
                                                                </h6>
                                                                <textarea type="text" class="form-control {{ $prod->color }}" id="addTextosEncomenda{{$i}}" cols="7" rows="4" style="resize: none;"
                                                                    wire:model.defer="produtosComment.{{$i}}">
                                                                </textarea>
                                                            </li>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cleanSelectionQuick" class="btn btn-outline-dark" data-dismiss="modal">Limpar seleção</button>
                <button type="button" id="addAllButton" class="btn btn-outline-primary" wire:click="addAll('{{$nameProduct}}',{{$detalhesCliente->customers[0]->no}}, '{{ $ref }}','{{$codEncomenda}}')" disabled>Adicionar todos</button>
            </div>
        </div>
    </div>
</div>

{{-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Seleciona todos os inputs de quantidade e áreas de comentário
    const quantidadeInputs = document.querySelectorAll('.produto-quantidade');
    const comentarioAreas = document.querySelectorAll('textarea[id^="addTextosEncomenda"]');
    
    // Seleciona o botão "Adicionar Todos"
    const addAllButton = document.getElementById('addAllButton');

    // Função para verificar as quantidades e comentários
    function checkQuantitiesAndComments() {
        let allValid = true; // Assume que todos os inputs com dados são válidos inicialmente
        let allCommentsProvided = true; // Assume que todos os comentários são fornecidos inicialmente

        // Itera sobre cada input de quantidade
        quantidadeInputs.forEach(input => {
            const quantidadeInserida = parseInt(input.value);
            const quantidadeMinima = parseInt(input.getAttribute('data-qtd'));

            // Verifica se o input tem valor e se a quantidade inserida atende à quantidade mínima
            if (!isNaN(quantidadeInserida) && quantidadeInserida < quantidadeMinima) {
                // Verifica se o comentário correspondente está preenchido
                const comentarioArea = document.querySelector(`textarea[id="addTextosEncomenda${input.getAttribute('id')}"]`);
                if (!comentarioArea || comentarioArea.value.trim() === '') {
                    allCommentsProvided = false; // Se algum comentário necessário não estiver preenchido, define allCommentsProvided como falso
                }
            }
        });

        // Verifica se todos os inputs com dados são válidos
        quantidadeInputs.forEach(input => {
            const quantidadeInserida = parseInt(input.value);
            const quantidadeMinima = parseInt(input.getAttribute('data-qtd'));

            if (!isNaN(quantidadeInserida) && quantidadeInserida < quantidadeMinima) {
                if (!allCommentsProvided) {
                    allValid = false; // Se algum input com dados não for válido, define allValid como falso
                }
            }
        });

        // Habilita ou desabilita o botão "Adicionar Todos" com base na verificação
        addAllButton.disabled = !(allValid && allCommentsProvided);
    }

    // Adiciona o event listener a cada input de quantidade e área de comentário
    quantidadeInputs.forEach(input => {
        input.addEventListener('input', checkQuantitiesAndComments);
    });

    comentarioAreas.forEach(area => {
        area.addEventListener('input', checkQuantitiesAndComments);
    });

    // Chama a função para a verificação inicial
    checkQuantitiesAndComments();
});
</script> --}}
<!----->

<!-- Modal ver encomenda -->
<div  wire:ignore.self class="modal fade" id="modalEncomenda" tabindex="-1" role="dialog" aria-labelledby="modalEncomenda" aria-hidden="true" >
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="ti-archive"></i> Carrinho</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x:none!important;">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Ref.</th>
                                        <th>Descrição</th>
                                        <th>Qtd.</th>
                                        <th>Preço</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($carrinhoCompras as $item)
                                        <tr>
                                            <td style="border-bottom:1px solid #232b58!important; width:10%">{{ $item->referencia }}</td>
                                            <td style="border-bottom:1px solid #232b58!important; width:20%">{{ $item->designacao }}<br><small style="color:#1791ba;">{{$item->proposta_info}}</small></td>
                                            <td style="border-bottom:1px solid #232b58!important; width:10%">{{ $item->qtd }}</td>
                                            <td style="border-bottom:1px solid #232b58!important; width:10%">{{ number_format($item->price, 3, ',', '.') }} €</td>
                                            <td style="border-bottom:1px solid #232b58!important; width:5%">
                                                <strong>
                                                    <a href="javascript:void(0);" class="remover_produto btn btn-sm btn-primary" wire:click="delete({{ $item->id }})">X</a>
                                                </strong>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Nenhum produto no carrinho</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#tab6" id="finalizarEncomenda" data-toggle="tab"  wire:click="finalizarencomenda" class="nav-link btn btn-outline-primary">Guardar Encomenda</a>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- FIM TABS  -->
<style>
    .hidden-navbar {
        display: none !important;
    }
</style>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="crossorigin="anonymous"></script>
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
<script>
    document.addEventListener('livewire:load', function () {
        const screenWidth = window.innerWidth;
        const isMobile = screenWidth <= 720;

        Livewire.emit('setIsMobile', isMobile);
    });


    document.addEventListener('DOMContentLoaded', function () {
        const scrollCol = document.getElementById('scroll-col-9');
        const navbar = document.getElementById('navbar2');
        const toggleButton = document.getElementById('toggleNavbar');
        const toggleIcon = document.getElementById('toggleIcon');

        function getCookie(name) {
            const cookies = document.cookie.split('; ');
            const cookie = cookies.find(row => row.startsWith(name + '='));
            return cookie ? cookie.split('=')[1] : null;
        }

        function updateNavbarState() {
            const navbarHidden = getCookie('navbar_hidden') === 'true';

            if (navbarHidden) {
                scrollCol.classList.remove('col-md-9');
                scrollCol.classList.add('col-12');
                navbar.classList.add('navbar-hidden');
                toggleIcon.classList.remove('fa-arrow-left');
                toggleIcon.classList.add('fa-arrow-right');
            } else {
                navbar.classList.remove('navbar-hidden');
                scrollCol.classList.remove('col-12');
                scrollCol.classList.add('col-md-9');
                toggleIcon.classList.remove('fa-arrow-right');
                toggleIcon.classList.add('fa-arrow-left');
            }
        }

        updateNavbarState();

        toggleButton.addEventListener('click', function () {
            const isHidden = scrollCol.classList.toggle('col-12');
            scrollCol.classList.toggle('col-md-9', !isHidden);
            navbar.classList.toggle('navbar-hidden', isHidden);
            toggleIcon.classList.toggle('fa-arrow-right', isHidden);
            toggleIcon.classList.toggle('fa-arrow-left', !isHidden);

            document.cookie = `navbar_hidden=${isHidden}; path=/; max-age=86400;`;
            
        });

        window.updateNavbarState = updateNavbarState;
    });
    document.addEventListener('livewire:load', function () {
        updateNavbarState();
    });

    document.addEventListener('livewire:update', function () {
        updateNavbarState();
    });
    {{-- function adjustScrollHeight() {
        const navbar = document.getElementById('navbar2');
        const scrollCol = document.getElementById('scroll-col-9');

        navbar.offsetHeight;

        const navbarHeight = navbar.offsetHeight;

        const maxViewportHeight = window.innerHeight * 0.63;

        console.log("Altura da Navbar:", navbarHeight);
        console.log("Limite Máximo (63vh):", maxViewportHeight);

        if (navbarHeight > maxViewportHeight) {

            scrollCol.style.removeProperty('max-height');
            scrollCol.style.removeProperty('height');

            scrollCol.style.setProperty('max-height', `${navbarHeight}px`, 'important');
            scrollCol.style.setProperty('height', 'auto');
        } else {
            scrollCol.style.removeProperty('max-height');
            scrollCol.style.removeProperty('height');

            scrollCol.style.setProperty('max-height', '63vh', 'important');
        }
    }

    function adjustScrollHeightWithDelay(delay = 0200) {
        setTimeout(() => {
            requestAnimationFrame(() => adjustScrollHeight());
        }, delay);
    }

    window.addEventListener('resize', () => adjustScrollHeightWithDelay(2000));
    window.addEventListener('load', () => adjustScrollHeightWithDelay(2000));

    const navbar = document.getElementById('navbar2');
    const observer = new MutationObserver(() => {
        adjustScrollHeightWithDelay(0500); 
    });

    observer.observe(navbar, { attributes: true, childList: true, subtree: true });

    adjustScrollHeightWithDelay(1500); --}}

   
        // jQuery(document).on("click",".toggle",function() {
        
        //         jQuery(".card-header").css("display","none");
        //         // jQuery(".tab-content").css("z-index","-20");
        //         jQuery(".sidebarProd").css("z-index","+100");
        
        // });
    document.addEventListener("DOMContentLoaded", function() {

        
        
        function closeAllDropdowns() {
            var dropdownMenus = document.querySelectorAll('.dropdownIcon-menu');
            dropdownMenus.forEach(function(dropdownMenu) {
                dropdownMenu.style.display = "none";
            });
        }

        function toggleDropdown(dropdownBtn) {
            var dropdownMenu = dropdownBtn.nextElementSibling;
            if (dropdownMenu.style.display === "block") {
                dropdownMenu.style.display = "none";
            } else {
                closeAllDropdowns();
                dropdownMenu.style.display = "block";
            }
        }

       
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains('dropdownIcon-toggle')) {
                var dropdownBtn = event.target;
                toggleDropdown(dropdownBtn);
            }
        });


    });
    function attachLoader() {
       
        const quantidadeInputs = document.querySelectorAll('.produto-quantidade');
        const comentarioAreas = document.querySelectorAll('textarea[id^="addTextosEncomenda"]');
        
        
        const addAllButton = document.getElementById('addAllButton');

    
        function checkQuantitiesAndComments() {
            let allValid = true;
            let allCommentsProvided = true;

            quantidadeInputs.forEach(input => {
                const trElement = input.closest('tr');
                const backgroundColor = trElement.style.backgroundColor;

                const quantidadeInserida = parseInt(input.value);
                const quantidadeMinima = parseInt(input.getAttribute('data-qtd'));

                if (!isNaN(quantidadeInserida) && quantidadeInserida < quantidadeMinima) {
                    const comentarioArea = document.querySelector(`textarea[id="addTextosEncomenda${input.getAttribute('id')}"]`);
                    if (!comentarioArea || comentarioArea.value.trim() === '') {
                        allCommentsProvided = false; 
                    } else{allCommentsProvided = true;  }
                    if (backgroundColor === 'rgb(65, 198, 160)') {
                        allCommentsProvided = false;
                    }
                }
            });

            quantidadeInputs.forEach(input => {
                const trElement = input.closest('tr');
                const backgroundColor = trElement.style.backgroundColor;

                const quantidadeInserida = parseInt(input.value);
                const quantidadeMinima = parseInt(input.getAttribute('data-qtd'));

                if (!isNaN(quantidadeInserida) && quantidadeInserida < quantidadeMinima) {
                    if (!allCommentsProvided) {
                        allValid = false;
                    }
                }
            });

            addAllButton.disabled = !(allValid && allCommentsProvided);
        }

        quantidadeInputs.forEach(input => {
            input.addEventListener('input', checkQuantitiesAndComments);
        });

        comentarioAreas.forEach(area => {
            area.addEventListener('input', checkQuantitiesAndComments);
        });

        checkQuantitiesAndComments();


        //sssss
        const textareas = document.querySelectorAll('[id^="addTextosEncomenda"]');
               textareas.forEach(textarea => {
            const classListArray = Array.from(textarea.classList);

            const hasColorClass = classListArray.some(className => className.includes('41c6a0'));
            const id = textarea.id.replace('addTextosEncomenda', '');

            if (!hasColorClass) { 
                const commentButton = document.getElementById('addCommentEncomenda' + id);

                if (commentButton) {
                    textarea.addEventListener('input', function() {
                        
                        if (textarea.value.trim() !== "") {
                            commentButton.removeAttribute('disabled');
                        } else {
                            commentButton.setAttribute('disabled', 'disabled');
                        }
                    });

                    commentButton.addEventListener('click', function() {
                        $('#addProductEncomenda'+id).removeAttr('disabled');
                        $('#addProductProposta'+id).removeAttr('disabled');
                    });
                }

            }else{
                const commentButton = document.getElementById('addCommentEncomenda' + id);
                
                if (commentButton) {
                    textarea.addEventListener('input', function() {

                        if (textarea.value.trim() !== "") {
                            commentButton.removeAttribute('disabled');
                        } else {
                            commentButton.setAttribute('disabled', 'disabled');
                        }
                    });
                   
                }
            }
        });
    }

    const checkbox = document.getElementById('checkbox');
    const sidebar = document.getElementById('sidebarProd');

    checkbox.addEventListener('change', function() {
        const sidebarHasOpenClass = sidebar.classList.contains('open');

        if (this.checked && !sidebarHasOpenClass) {
            sidebar.classList.add('open');
            checkbox.checked = true;
        } else if (!this.checked && sidebarHasOpenClass) {
            sidebar.classList.remove('open');

        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        var accordions2 = document.getElementsByClassName("accordion2");

        for (var i = 0; i < accordions2.length; i++) {
            accordions2[i].addEventListener("click", function() {
                // Toggle active class to button
                this.classList.toggle("active");

                // Toggle the panel visibility
                var panel2 = this.nextElementSibling;
                if (panel2.style.maxHeight) {
                    panel2.style.maxHeight = null;
                    this.querySelector('.arrow').innerHTML = '<i class="fa-regular fa-square-caret-down"></i>'; // Change arrow down
                } else {
                    panel2.style.maxHeight = panel2.scrollHeight + "%";
                    this.querySelector('.arrow').innerHTML = '<i class="fa-regular fa-square-caret-up"></i>'; // Change arrow up
                }
            });
        }
       
       function attachHandlers() {

        $('.kitCheck').off('change').on('change', function() {
            $('.kitCheck').not(this).prop('checked', false);
        });

        $('.produto-quantidade').off('input').on('input', function() {
            var id = $(this).attr('id');
            var valor = $(this).val();
            var qtdMin = $(this).attr('data-qtd');
            var trElement = $(this).closest('tr');
            var backgroundColor = trElement.css('background-color');

            // Verifica se há comentário na mesma linha
            var hasComment = trElement.find('#commentProductEncomenda' + id).val().trim() !== '';

            // Condição para ativar o botão
            if(backgroundColor === 'rgb(65, 198, 160)'){
                if(parseInt(valor) >= parseInt(qtdMin)){
                    $('#addProductEncomenda'+id).removeAttr('disabled');
                    $('#addProductProposta'+id).removeAttr('disabled');
                } else {
                    addAllButton.disabled = !(allValid && allCommentsProvided);

                    $('#addProductEncomenda'+id).attr('disabled', 'disabled');
                    $('#addProductProposta'+id).attr('disabled', 'disabled');
                }
            }else{
                if(parseInt(valor) >= parseInt(qtdMin) || hasComment){
                    $('#addProductEncomenda'+id).removeAttr('disabled');
                    $('#addProductProposta'+id).removeAttr('disabled');
                } else {
                    $('#addProductEncomenda'+id).attr('disabled', 'disabled');
                    $('#addProductProposta'+id).attr('disabled', 'disabled');
                }
            }

            // Se a quantidade for menor ou igual a 0, sempre desabilitar
            if(valor === '' || parseInt(valor) <= 0){
                $('#addProductEncomenda'+id).attr('disabled', 'disabled');
                $('#addProductProposta'+id).attr('disabled', 'disabled');
            }
        });
            
            $('#selectBox').hide();
            $('#selectLabel').css("display","none");

            $('.checkFinalizar').off('change').on('change', function() {
                // $('.checkFinalizar').not(this).prop('checked', false);

                if($('#levantamento_loja').is(':checked')) {
                    @this.set('transportadora', false); 
                    @this.set('entrega_obra', false); 
                    @this.set('viaturaSanipower', false); 
                    @this.set('tabFinalizar', 'show active');
                    @this.set('tabProdutos', ''); 

                }

                if($('#viatura_sanipower').is(':checked')) {
                    @this.set('transportadora', false); 
                    @this.set('entrega_obra', false); 
                    @this.set('levantamentoLoja', false); 
                    @this.set('tabFinalizar', 'show active');
                    @this.set('tabProdutos', ''); 
                }

                if($('#entrega_obra').is(':checked')) {
                    @this.set('transportadora', false); 
                    @this.set('viaturaSanipower', false); 
                    @this.set('levantamentoLoja', false);
                    @this.set('tabFinalizar', 'show active');
                    @this.set('tabProdutos', '');  

                }

                if($('#transportadora').is(':checked')) {
                    @this.set('entrega_obra', false); 
                    @this.set('viaturaSanipower', false); 
                    @this.set('levantamentoLoja', false);
                    @this.set('tabFinalizar', 'show active');  
                    @this.set('tabProdutos', ''); 

                }

                if($('#levantamento_loja').is(':checked')) {
                    $('#selectBox').show();
                    $('#selectLabel').css("display","block");
                } else {
                    $('#selectBox').hide();
                    $('#selectLabel').css("display","none");
                }

                if($('#entrega_obra').is(':checked') || $('#transportadora').is(':checked')) {
                    $('#selectBoxMorada').show();
                    $('#SelectMorada').css("display","block");
                    $('#selectBoxCodpostal').show();
                    $('#SelectCodpostal').css("display","block");
                    $('#selectBoxLoc').show();
                    $('#SelectLoc').css("display","block");
                } else {
                    $('#selectBoxMorada').hide();
                    $('#SelectMorada').css("display","none");
                    $('#selectBoxCodpostal').hide();
                    $('#SelectCodpostal').css("display","none");
                    $('#selectBoxLoc').hide();
                    $('#SelectLoc').css("display","none");
                }

            });

            $('.checkPagamento').off('change').on('change', function() {
                $('.checkPagamento').not(this).prop('checked', false);
            });

            $('.checkDate').off('change').on('change', function() {
                if($('#encomendaProgramada').is(':checked')) {
                    $('#selectBoxDate').show();
                    $('#selectDate').css("display","block");
                } else {
                    $('#selectBoxDate').hide();
                    $('#selectDate').css("display","none");
                }
            });
        }
        attachHandlers();

        Livewire.hook('message.processed', (message, component) => {
            attachHandlers();
        });
    });

    window.addEventListener('refreshAllComponent', function() {
        const sidebar = document.getElementById('sidebarProd');
        const subbars = document.querySelectorAll('.subsidebarProd');
        const targetElement = event.target;

        document.querySelectorAll('.subsidebarProd').forEach(function(item) {
            item.style.display = 'none';
        });

        checkbox.checked = true;
        sidebar.classList.remove('open');

        var accordions2 = document.getElementsByClassName("accordion2");

        // Add click event listener to each accordion button
        for (var i = 0; i < accordions2.length; i++) {
            accordions2[i].addEventListener("click", function() {
               
                this.classList.toggle("active");

                // Toggle the panel visibility
                var panel2 = this.nextElementSibling;
                if (panel2.style.maxHeight) {
                    panel2.style.maxHeight = null;
                    this.querySelector('.arrow').innerHTML = '<i class="fa-regular fa-square-caret-down"></i>'; // Change arrow down
                } else {
                    panel2.style.maxHeight = panel2.scrollHeight + "%";
                    this.querySelector('.arrow').innerHTML = '<i class="fa-regular fa-square-caret-up"></i>'; // Change arrow up
                }
            });
        }
    });

    window.addEventListener('refreshPage', function(e) {
        window.location.reload();
    });

    window.addEventListener('refreshComponentEncomenda2', function(e) {
    
        var accordions2 = document.getElementsByClassName("accordion2");
    
        for (var i = 0; i < accordions2.length; i++) {
            accordions2[i].addEventListener("click", function() {
                this.classList.toggle("active");
    
                var panel2 = this.nextElementSibling;
                if (panel2.style.maxHeight) {
                    panel2.style.maxHeight = null;
                    this.querySelector('.arrow').innerHTML = '<i class="fa-regular fa-square-caret-down"></i>';
                } else {
                    panel2.style.maxHeight = panel2.scrollHeight + "%";
                    this.querySelector('.arrow').innerHTML = '<i class="fa-regular fa-square-caret-up"></i>';
                }
            });
        }
    
        document.querySelectorAll('.subsidebarProd').forEach(function(item) {
            item.style.display = 'none';
        });
    
        const subItem = document.querySelector("#subItemInput" + e.detail.id);
        if (subItem) {
            subItem.style.display = 'block';
        }
    });

    window.addEventListener('refreshComponent', function(e) {
        //window.location.reload();
        var check = jQuery("[data-id='"+e.detail.id+"']").attr("data-id");
    
        document.querySelectorAll('.familyHREF'+check).forEach(function(item) {
            item.style.display = 'none';
        });
        
        document.querySelectorAll('.subsidebarProd').forEach(function(item) {
            item.style.display = 'none';
        });
    
        jQuery("#subItemInput" + e.detail.id).css("display", "block");
    
    });

    const inputProdutos = document.querySelectorAll('.input-config-produtos');
    inputProdutos.forEach(function(inputProduto) {
        inputProduto.addEventListener('click', function() {
            if (inputProduto.classList.contains('open')) {} else {
                sidebar.classList.remove('open');
                // console.log("1");
                // jQuery(".card-header").css("display","block");

                document.querySelectorAll('.subsidebarProd').forEach(function(item) {
                    item.style.display = 'none';
                });
            }

        });
    });

    const inputGroups = document.querySelectorAll('.input-group-config');
    let currentSubItem = null;

    inputGroups.forEach(function(inputGroup) {
        inputGroup.addEventListener('click', function() {
            
            const id = this.id;
            const subItemId = 'subItemInput' + id.slice(-1);
            const InputId = 'input' + id.slice(-1);


            const subItem = document.getElementById(subItemId);
            const Input = document.getElementById(InputId);
            //jQuery("#subItemInput" + InputId).css("display", "none");
        
            const subbars = document.querySelectorAll('.subsidebarProd');

            if (subItem) {
                const currentDisplayStyle = window.getComputedStyle(subItem).display;

                if (currentDisplayStyle === 'block') {
                    subItem.style.display = 'none';
                } else {
                    document.querySelectorAll('.subsidebarProd').forEach(function(item) {
                        item.style.display = 'none';
                    });

                    // var familyInfo = @this.get('familyInfo');

                    // if (familyInfo) {
                    //     Livewire.emit("rechargeFamilys", id);
                    //     setTimeout(function() {
                    //         subItem.style.display = 'block';
                    //     }, 1500);
                    // } else {
                    subItem.style.display = 'block';
                    // }

                }
                currentSubItem = subItem;
            }
        });
    });

    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebarProd');
        const subbars = document.querySelectorAll('.subsidebarProd');
        const targetElement = event.target;
        if (sidebar) {
            if (!sidebar.contains(targetElement)) {
                
                let clickedOutsideSubbars = true;
                subbars.forEach(function(subbar) {
                    if (subbar.contains(targetElement)) {
                      
                        clickedOutsideSubbars = false;
                    }
                });

                if (clickedOutsideSubbars) {
                    document.querySelectorAll('.subsidebarProd').forEach(function(item) {
                        item.style.display = 'none';
                    });

                    checkbox.checked = true;
                    sidebar.classList.remove('open');
                   

                } else {
                    checkbox.checked = false;
                }
              

            }
        } else {}
        attachLoader()
        function attachHandlers() {

        $('.kitCheck').off('change').on('change', function() {
            $('.kitCheck').not(this).prop('checked', false);
        });

        $('.produto-quantidade').off('input').on('input', function() {
            var id = $(this).attr('id');
            var valor = $(this).val();
            var qtdMin = $(this).attr('data-qtd');
            var trElement = $(this).closest('tr');
            var backgroundColor = trElement.css('background-color');

            // Verifica se há comentário na mesma linha
            var hasComment = trElement.find('#commentProductEncomenda' + id).val().trim() !== '';

            // Condição para ativar o botão
            if(backgroundColor === 'rgb(65, 198, 160)'){
                if(parseInt(valor) >= parseInt(qtdMin)){
                    $('#addProductEncomenda'+id).removeAttr('disabled');
                    $('#addProductProposta'+id).removeAttr('disabled');
                } else {
                    $('#addProductEncomenda'+id).attr('disabled', 'disabled');
                    $('#addProductProposta'+id).attr('disabled', 'disabled');
                }
            }else{
                if(parseInt(valor) >= parseInt(qtdMin) || hasComment){
                    $('#addProductEncomenda'+id).removeAttr('disabled');
                    $('#addProductProposta'+id).removeAttr('disabled');
                } else {
                    $('#addProductEncomenda'+id).attr('disabled', 'disabled');
                    $('#addProductProposta'+id).attr('disabled', 'disabled');
                }
            }

            // Se a quantidade for menor ou igual a 0, sempre desabilitar
            if(valor === '' || parseInt(valor) <= 0){
                $('#addProductEncomenda'+id).attr('disabled', 'disabled');
                $('#addProductProposta'+id).attr('disabled', 'disabled');
            }
        });
            
        }
        attachHandlers()
    });

    jQuery('body').on('click', '.checkboxSidbar', function() {
        
        const inputProdutos = document.querySelectorAll('.input-config-produtos');
        inputProdutos.forEach(function(inputinputProduto) {});

        document.querySelectorAll('.subsidebarProd').forEach(function(item) {
            item.style.display = 'none';
        });
    });


    jQuery('body').on('click', '.buttonGoback', function() {
        document.querySelectorAll('.subsidebarProd').forEach(function(item) {
            item.style.display = 'none';
        });
    });

    class ScrollableDiv {
        constructor(element) {
            this.element = element;
            this.isScrolling = false;
            this.startX = null;
            this.startScrollLeft = null;

            this.element.addEventListener('mousedown', this.handleMouseDown.bind(this));
            document.addEventListener('mouseup', this.handleMouseUp.bind(this));
            document.addEventListener('mousemove', this.handleMouseMove.bind(this));
        }

        handleMouseDown(event) {
            this.isScrolling = true;
            this.startX = event.clientX;
            this.startScrollLeft = this.element.scrollLeft;
            event.preventDefault();
        }

        handleMouseUp() {
            this.isScrolling = false;
        }

        handleMouseMove(event) {
            if (this.isScrolling) {
                const deltaX = event.clientX - this.startX;
                this.element.scrollLeft = this.startScrollLeft - deltaX;
            }
        }
    }

    const scrollableDivs = document.querySelectorAll('.scrollableDiv');
    scrollableDivs.forEach(function(div) {
        new ScrollableDiv(div);
    });







    document.addEventListener('livewire:load', function() {
        Livewire.hook('message.sent', () => {
            if(document.getElementById('loader') != null){
                document.getElementById('loader').style.display = 'block';
                
            }
        });

        Livewire.hook('message.processed', () => {
            if(document.getElementById('loader') != null){
                document.getElementById('loader').style.display = 'none';
            }
        });

    });


    document.getElementById('finalizarEncomenda').addEventListener('click', function() {
        // Fecha o modal
        $('.modal').modal('hide');

        // Adiciona as classes 'show active' à aba especificada
        document.querySelector('#tab6').classList.add('show', 'active');

        // Remove as classes 'show active' das outras abas, se necessário
        var otherTabs = document.querySelectorAll('.tab-pane');
        otherTabs.forEach(function(tab) {
            if (tab.id !== 'tab6') {
                tab.classList.remove('show', 'active');
            }
        });
        // Atualiza o link da navegação para refletir a aba ativa
        var navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(function(link) {
            link.classList.remove('active');
        });
        document.querySelector('a[href="#tab6"]').classList.add('active');
    });


    jQuery('#cleanSelectionQuick').on('click', function(event) {
        event.stopPropagation();
        event.preventDefault();

        //fazer aqui para limpar as linhas todas
        jQuery('td #valueEncomendar').each(function(){
            jQuery(this).val("");

        })

        jQuery('#modalProdutos').modal('hide');

        Livewire.emit("cleanModal");

    });

    document.addEventListener('deleteModal', function(event) {
    jQuery('#modalEncomenda').modal();

        jQuery('#modalEncomenda').modal('show');
    });

    document.addEventListener('compraRapida', function() {
        jQuery('#modalProdutos').modal();
    });

    document.addEventListener('changeRoute', function(e) {
        window.location.href = document.referrer;
    });
    
     window.addEventListener('checkToaster', function(e) {
        const checkboxes = document.querySelectorAll('.checkboxAddKit');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    });

    {{-- document.addEventListener('livewire:load', function() {

        function checkCheckboxes() {
        const checkboxes = document.querySelectorAll('.checkboxAddKit');
        const buttonContainer = document.querySelector('.btn-Add-itens-kit');
        
        const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        if (anyChecked) {
            buttonContainer.style.display = 'block';
        } else {
            buttonContainer.style.display = 'none';
        }
        }

        document.querySelectorAll('.checkboxAddKit').forEach(checkbox => {
        checkbox.addEventListener('change', checkCheckboxes);
        });
        checkCheckboxes();


        function checkCheckboxesRemove() {
        const checkboxes = document.querySelectorAll('.checkboxRemoveKit');
        const buttonContainer = document.querySelector('.btn-remove-itens-kit');
        
        const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        // console.log(anyChecked);
        if (anyChecked) {
            buttonContainer.style.display = 'block';
        } else {
            buttonContainer.style.display = 'none';
        }
        }

        document.querySelectorAll('.checkboxRemoveKit').forEach(checkbox => {
        checkbox.addEventListener('change', checkCheckboxesRemove);
        });
        checkCheckboxesRemove();
    }); --}}
</script>
</div>
