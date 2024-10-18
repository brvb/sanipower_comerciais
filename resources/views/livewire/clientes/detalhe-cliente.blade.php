<div>
      <!--  LOADING -->

      <div id="loader" style="display: none;">
        <div class="loader" role="status">

        </div>
    </div>

    <!-- FIM LOADING -->

    <!-- TABS  -->

    <div class="row group-buttons group-buttons d-flex justify-content-end mr-0 mb-2">
        <div class="tools">
            <a href="{{ route('visitas.detail', $detalhesCliente->customers[0]->id ) }}" class="btn btn-sm btn-primary"><i class="ti-pin"></i> Criar Visita</a>
            
            <a href="{{ route('encomendas.detail', $detalhesCliente->customers[0]->id ) }}" class="btn btn-sm btn-success"><i class="ti-package"></i> Encomenda</a>
            <a href="{{ route('propostas.detail', $detalhesCliente->customers[0]->id ) }}" class="btn btn-sm btn-danger"><i class="ti-file"></i> Proposta</a>

            <a href="javascript:void(0);" class="btn btn-sm btn-warning"><i class="ti-eye"></i> Ocorrência</a>
            <a href="javascript:void(0);" wire:click="voltarAtras" class="btn btn-sm btn-secondary" > Voltar atrás</a>

        </div>
    </div>

    <div class="card card-tabs-pills mb-3">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a href="#tab4" data-toggle="tab" class="nav-link {{$tabDetail}}">Detalhes</a>
                </li>
                <li class="nav-item">
                    <a href="#tab5" data-toggle="tab" class="nav-link {{$tabAnalysis}}">Análises Gerais</a>
                </li>
                <li class="nav-item">
                    <a href="#tab6" data-toggle="tab" class="nav-link {{$tabEncomendas}}">Encomendas</a>
                </li>
                <li class="nav-item">
                    <a href="#tab7" data-toggle="tab" class="nav-link {{$tabPropostas}}">Propostas</a>
                </li>
                <li class="nav-item">
                    <a href="#tab8" data-toggle="tab" class="nav-link {{$tabFinanceiro}}">Financeiro</a>
                </li>
                <li class="nav-item">
                    <a href="#tab9" data-toggle="tab" class="nav-link {{$tabOcorrencias}}">Ocorrências</a>
                </li>
                <li class="nav-item">
                    <a href="#tab10" data-toggle="tab" class="nav-link {{$tabVisitas}}">Visitas</a>
                </li>
                <li class="nav-item">
                    <a href="#tab11" data-toggle="tab" class="nav-link {{$tabAssistencias}}">Assistências</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="#tab12" data-toggle="tab" class="nav-link {{$tabCampanhas}}">Campanhas</a>
                </li> --}}
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade {{$tabDetail}}" id="tab4">
                    <h4 class="card-title">{{$detalhesCliente->customers[0]->name}}</h4>
                    <p class="card-text">

                        <!--  INICIO DOS DETALHES   -->

                        <div class="row form-group">
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Nome do Cliente</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-user text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->name}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Nº do Cliente</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-info-alt text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->no}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Nº de Contribuinte</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-marker text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->nif}}" readonly>
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
                                            <span class="input-group-text bg-carolina"><i class="ti-location-arrow text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->address}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Localidade</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-location-arrow text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->city}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Código Postal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-location-arrow text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->zipcode}}" readonly>
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
                                            <span class="input-group-text bg-carolina"><i class="ti-pin text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->zone}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Contactos</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-email text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->phone}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Nº Propostas em aberto</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-comment text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->open_proposals}}" readonly>
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
                                            <span class="input-group-text bg-carolina"><i class="ti-light-bulb text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->open_occurrences}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Saldo em Aberto</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-money text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->current_account}}€" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Cheques em carteira</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-bag text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->balance_checks}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Pontos</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-stats-up text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->balance_points}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Condições de pagamento</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-credit-card text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->customers[0]->payment_conditions}}" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!--  FIM DETALHES   -->
                    </p>
                </div>
                <div class="tab-pane fade {{$tabAnalysis}}" id="tab5">

                    <p class="card-text">

                        <!-- INICIO TABELA  -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-3">
                                    <div class="card-header d-block">
                                        <div class="row">
                                            <div class="col-xl-8 col-xs-12">
                                                <div class="caption uppercase">
                                                    <i class="ti-stats-up"></i> Análises
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="card-body">

                                        <div id="dataTables_wrapper" class="dataTables_wrapper container" style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                                            <div class="left">
                                                <label>Mostrar
                                                    <select name="perPage" wire:model="perPage">
                                                        <option value="10"
                                                            @if ($perPage == 10) selected @endif>10</option>
                                                        <option value="25"
                                                            @if ($perPage == 25) selected @endif>25</option>
                                                        <option value="50"
                                                            @if ($perPage == 50) selected @endif>50</option>
                                                        <option value="100"
                                                            @if ($perPage == 100) selected @endif>100</option>
                                                    </select>
                                                    registos</label>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover" id="tabela-cliente2">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Documento</th>
                                                        <th>Total liquido</th>
                                                        <th>Total IVA</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($analisesCliente as $clt )
                                                        <tr>
                                                            <td>{{date('Y-m-d',strtotime($clt->date))}}</td>
                                                            <td>{{$clt->document}}</td>
                                                            <td>{{$clt->net_total}}€</td>
                                                            <td>{{$clt->total_tax}}€</td>
                                                            <td>{{$clt->total}}€</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- {{ $analisesCliente->links() }} --}}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- FIM TABELA  -->

                    </p>
                </div>


                <div class="tab-pane fade {{$tabEncomendas}}" id="tab6">

                    <p class="card-text">

                        @livewire('clientes.encomendas',["cliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>

                
                <div class="tab-pane fade {{$tabPropostas}}" id="tab7">

                    <p class="card-text">

                        @livewire('clientes.propostas',["cliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>

                
                <div class="tab-pane fade {{$tabFinanceiro}}" id="tab8">

                    <p class="card-text">

                        @livewire('clientes.financeiro',["idCliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>

                
                <div class="tab-pane fade {{$tabVisitas}}" id="tab10">

                    <p class="card-text">

                        @livewire('visitas.cliente-visitas',["idCliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>

                <div class="tab-pane fade {{$tabOcorrencias}}" id="tab9">

                    <p class="card-text">

                        @livewire('clientes.ocorrencias',["cliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>
                 <div class="tab-pane fade {{$tabAssistencias}}" id="tab11">

                    <p class="card-text">

                        @livewire('visitas.assistencias',["idCliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>
                <div class="tab-pane fade {{$tabCampanhas}}" id="tab12">

                    <p class="card-text">


                    <div class="row form-group">
                        <div class="col-xl-4 col-xs-12">

                            <div class="form-group">
                                <label>Referência</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-light-bulb text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-4 col-xs-12">

                            <div class="form-group">
                                <label>Entrega</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-bag text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-xs-12">

                            <div class="form-group">
                                <label>Condições de Pagamento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-carolina"><i
                                                class="ti-money text-light"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="card-header d-block">
                                    <div class="row">
                                        <div class="col-xl-8 col-xs-12">
                                            <div class="caption uppercase">
                                                <i class="ti-user"></i> Clientes
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-xs-12 text-right">

                                        </div>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" style="overflow-x:inherit!important;">
                                        <table class="table table-bordered table-hover init-datatable"
                                            id="tabela-cliente">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Título</th>
                                                    <th>Número</th>
                                                    <th>Preço</th>
                                                    <th>Quantidade</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Abraçadeira</td>
                                                    <td>513130</td>
                                                    <td>€70</td>
                                                    <td>10</td>
                                                    <td>
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="ti-plus"></i> Nova Ação
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Abraçadeira</td>
                                                    <td>2186325</td>
                                                    <td>€22</td>
                                                    <td>33</td>
                                                    <td>
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="ti-plus"></i> Nova Ação
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Abraçadeira</td>
                                                    <td>215216</td>
                                                    <td>€10</td>
                                                    <td>20</td>
                                                    <td>
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="ti-plus"></i> Nova Ação
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- FIM TABS  -->
<script>
    document.addEventListener('livewire:load', function() {
            Livewire.hook('message.sent', () => {
                document.getElementById('loader').style.display = 'block';
            });

            // Oculta o loader quando o Livewire terminar de carregar
            Livewire.hook('message.processed', () => {
                document.getElementById('loader').style.display = 'none';
            });
        });


    
       

</script>
</div>
