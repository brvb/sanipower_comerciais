<div>
    <!--  LOADING -->

    <div id="loader" style="display: none;">
        <div class="loader" role="status">

        </div>
    </div>

    <!-- FIM LOADING -->

    <!-- TABS  -->
    
    <div class="row group-buttons group-buttons d-flex justify-content-end mr-0 mb-2">
        <div class="col-md-3 col-xs-12">
            <h4>Adicionar Visita</h4>
        </div>
        
        <div class="tools col-md-9 col-xs-12 text-right">
            @if(isset($checkStatus))
                @if($checkStatus != "1")
                    <a href="javascript:void(0);" wire:click="guardarVisita" class="btn btn-sm btn-primary"><i class="ti-save"></i> Gravar</a>

                    <a href="javascript:void(0);" wire:click="finalizarVisita" class="btn btn-sm btn-primary"><i class="ti-save"></i> Gravar e Finalizar</a>

                    <a href="javascript:void(0);" wire:click="openEncomenda({{ json_encode($detalhesCliente->customers[0]->id)}}, {{$idVisita}})" class="btn btn-sm btn-success"><i class="ti-package"></i> Encomenda</a>

                    <a href="javascript:void(0);" wire:click="openProposta({{  json_encode($detalhesCliente->customers[0]->id) }}, {{$idVisita}})" class="btn btn-sm btn-danger"><i class="ti-file"></i> Proposta</a>

                    <a href="javascript:void(0);" class="btn btn-sm btn-warning"><i class="ti-eye"></i> Ocorrência</a>
                @else
                <a href="javascript:void(0);"  wire:click="gerarPdfVisita({{ json_encode($getVisita)}})" class="btn btn-sm btn-secondary"><i class="ti-save"></i>Gerar PDF</a>
                @endif
            @endif
           
        
            {{-- <a href="{{ route('encomendas.detail.visitas', [$detalhesCliente->customers[0]->id, $idVisita]) }}" class="btn btn-sm btn-success"><i class="ti-package"></i> Encomenda</a>
            <a href="{{ route('propostas.detail', $detalhesCliente->customers[0]->id ) }}" class="btn btn-sm btn-danger"><i class="ti-file"></i> Proposta</a> --}}
           
            <a href="javascript:void(0);" wire:click="voltarAtras" class="btn btn-sm btn-secondary" > Voltar atrás</a>
        </div>
    </div>

    <div class="card card-tabs-pills mb-3">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a href="#tab4" data-toggle="tab" class="nav-link {{$tabDetail}}" wire:click="addSessionDetalhesRelatorio('tabDetail')">Detalhes</a>
                </li>
                <li class="nav-item">
                    <a href="#tab6" data-toggle="tab" class="nav-link {{$tabAnalysis}}" wire:click="addSessionDetalhesRelatorio('tabAnalysis')">Análises De Vendas</a>
                </li>
                <li class="nav-item">
                    <a href="#tab7" data-toggle="tab" class="nav-link {{$tabEncomendas}}" wire:click="addSessionDetalhesRelatorio('tabEncomendas')">Encomendas</a>
                </li>
                <li class="nav-item">
                    <a href="#tab8" data-toggle="tab" class="nav-link {{$tabPropostas}}" wire:click="addSessionDetalhesRelatorio('tabPropostas')">Propostas</a>
                </li>
                <li class="nav-item">
                    <a href="#tab9" data-toggle="tab" class="nav-link {{$tabFinanceiro}}" wire:click="addSessionDetalhesRelatorio('tabFinanceiro')">Financeiro</a>
                </li>
                <li class="nav-item">
                    <a href="#tab10" data-toggle="tab" class="nav-link {{$tabOcorrencia}}" wire:click="addSessionDetalhesRelatorio('tabOcorrencia')">Ocorrências</a>
                </li>
                <li class="nav-item">
                    <a href="#tab11" data-toggle="tab" class="nav-link {{$tabVisitas}}" wire:click="addSessionDetalhesRelatorio('tabVisitas')">Visitas</a>
                </li>
                <li class="nav-item">
                    <a href="#tab12" data-toggle="tab" class="nav-link {{$tabAssistencias}}" wire:click="addSessionDetalhesRelatorio('tabAssistencias')">Assistências</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade {{$tabDetail}}" id="tab4">
                    <div style="display:flex;align-items: center;">


                    <h4 class="card-title" style="margin-bottom: 0;">{{$detalhesCliente->customers[0]->name}}</h4>
                        <button class="btn btn-sm btn-primary text-left" style="margin-left: 10px;margin-right: 10px;" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-info"></i>
                        </button>
                         {{-- <button class="btn btn-sm btn-primary text-left" type="button">
                            <i class="fas fa-info"></i>
                        </button> --}}
                        @if ($getVisita)
                            @if($getVisita->finalizado == 0)
                                <h6 class="text-chili" style="margin-bottom: 0;font-weight: bold;">Agendada</h6>
                            @elseif($getVisita->finalizado == 2)
                                <h6 class="text-warning" style="margin-bottom: 0;font-weight: bold;">Iniciada</h6>
                            @else
                                <h6 class="text-forest" style="margin-bottom: 0;font-weight: bold;">Finalizada</h6>
                            @endif
                        @endif
                     
                    </div>
                     <div class="row ml-0 mr-0 mt-4 d-block">

                        <div class="accordion" id="accordionExample">
                            <div class="card" style="margin-left: 18px;margin-right: 34px;">
                           
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                                <div class="card-body">

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
                                        <input type="text" class="form-control" value="{{ number_format($detalhesCliente->customers[0]->current_account,3)}}" readonly>
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
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                
                

                    <p class="card-text">

                        <!-- INICIO RELATORIO  -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-3">
                                    <div class="card-header d-block">
                                        <div class="row">
                                            <div class="col-xl-8 col-xs-12">
                                                <div class="caption uppercase">
                                                    <i class="ti-files"></i> Relatório
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Assunto</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-carolina"><i class="ti-clip text-light"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="" wire:model.defer="assunto"  @if(isset($checkStatus)) @if($checkStatus == "1") readonly @endif @endif>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Relatório</label>
                                            <div class="input-group">
                                                <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.defer="relatorio" @if(isset($checkStatus)) @if($checkStatus == "1") readonly @endif @endif></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Tipo de Visita</label>
                                            <div class="input-group">
                                                <select class="form-control" id="tipoVisitaSelect" wire:model.defer="tipoVisitaSelect" @if(isset($checkStatus)) @if($checkStatus == "1") readonly disabled @endif @endif>
                                                    @isset($tiposVisitaCollection)
                                                        @foreach ($tiposVisitaCollection as $tipo)
                                                            <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Pendentes para a próxima visita</label>
                                            <div class="input-group">
                                                <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.defer="pendentes" @if(isset($checkStatus)) @if($checkStatus == "1") readonly @endif @endif></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">

                                            <div class="col-xs-12 col-xl-3">
                                                <label>Comentário sobre encomendas</label>
                                                <div class="input-group">
                                                    <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.lazy="comentario_encomendas" @if(isset($checkStatus)) @if($checkStatus == "1") readonly @endif @endif></textarea>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-xl-3">
                                                <label>Comentário sobre propostas</label>
                                                <div class="input-group">
                                                    <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.lazy="comentario_propostas" @if(isset($checkStatus)) @if($checkStatus == "1") readonly @endif @endif></textarea>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-xl-3">
                                                <label>Comentário sobre financeiro</label>
                                                <div class="input-group">
                                                    <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.lazy="comentario_financeiro" @if(isset($checkStatus)) @if($checkStatus == "1") readonly @endif @endif></textarea>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-xl-3">
                                                <label>Comentário sobre ocorrências</label>
                                                <div class="input-group">
                                                    <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.lazy="comentario_occorencias" @if(isset($checkStatus)) @if($checkStatus == "1") readonly @endif @endif></textarea>
                                                </div>
                                            </div>

                                        </div>



                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- FIM RELATORIO  -->

                    </p>
                </div>

                <div class="tab-pane fade {{$tabAnalysis}}" id="tab6">

                    <p class="card-text">

                        <!-- INICIO TABELA  -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-3">
                                    <div class="card-header d-block">
                                        <div class="row">
                                            <div class="col-xl-8 col-xs-12">
                                                <div class="caption uppercase">
                                                    <i class="ti-stats-up"></i> Análises De Vendas
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="card-body">

                                        <div id="dataTables_wrapper" class="dataTables_wrapper container" style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                                            <div class="left">
                                                <label>
                                                    Mostrar
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
                                                    registos
                                                </label>
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
                                                    {{-- @dd($analisesCliente->items()) --}}
                                                    @if ($analisesCliente && $analisesCliente->count())
                                                        @foreach ($analisesCliente->items() as $clt)
                                                            <tr>
                                                                <td>{{ date('Y-m-d', strtotime($clt->date)) }}</td>
                                                                <td>{{ $clt->document }}</td>
                                                                <td>{{ number_format($clt->net_total,3) }}€</td>
                                                                <td>{{ number_format($clt->total_tax,3) }}€</td>
                                                                <td>{{ number_format($clt->total,3) }}€</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            {{-- @dd($analisesCliente) --}}
                                                            <td colspan="5">Nenhuma análise disponível.</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- {{ $analisesCliente->links() }}              --}}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- FIM TABELA  -->

                    </p>
                </div>

                <div class="tab-pane fade {{$tabEncomendas}}" id="tab7">

                    <p class="card-text">

                        @livewire('visitas.encomendas',["cliente" => $detalhesCliente->customers[0]->id, "visita" => $idVisita])

                    </p>
                </div>

                <div class="tab-pane fade {{$tabPropostas}}" id="tab8">

                    <p class="card-text">
                    
                        @livewire('visitas.propostas',["cliente" => $detalhesCliente->customers[0]->id, "visita" => $idVisita])

                    </p>
                </div>

                <div class="tab-pane fade {{$tabFinanceiro}}" id="tab9">

                    <p class="card-text">

                        @livewire('visitas.financeiro',["idCliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>
                
                <div class="tab-pane fade {{$tabOcorrencia}}" id="tab10">

                    <p class="card-text">
                        @livewire('visitas.ocorrencias',["cliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>
                <div class="tab-pane fade {{$tabVisitas}}" id="tab11">
                    <p class="card-text">

                        @livewire('visitas.cliente-visitas',["idCliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>
                <div class="tab-pane fade {{$tabAssistencias}}" id="tab12">
                    <p class="card-text">

                        @livewire('visitas.assistencias',["idCliente" => $detalhesCliente->customers[0]->id])

                    </p>
                </div>

            </div>
        </div>
        <div class="modal fade" id="listagemDetalherVisitas" tabindex="-1" role="dialog" aria-labelledby="listagemDetalherVisitas" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="modalComentario">Finalizar Visita</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="scrollModal" style="overflow-y: auto;max-height:500px;" >
                        <div class="card mb-3">
                            <div class="card-body">
                                @livewire('visitas.listagem-visitas-agendadas',["clientID" => json_encode($detalhesCliente->customers[0]->name), 'activeFinalizado' => "1" ], key(json_encode($detalhesCliente->customers[0]->name)))
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                    </div>
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
        window.addEventListener('listagemDetalherVisitasModal', function() {
            jQuery("#listagemDetalherVisitas").modal();
        });
        document.addEventListener('changeRoute', function(e) {
            window.location.href = document.referrer;
        });
        $('#listagemDetalherVisitas').on('hidden.bs.modal', function () {
            @this.set('clientID', "");
        });

    </script>
</div>
