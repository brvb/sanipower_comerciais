
<div>
    <style>
        @media (max-width: 1100px) {
            .btn:not(:disabled):not(.disabled) {
                cursor: pointer;
                font-size: 0.9rem;
                height: auto;
                padding: 0.3rem 0.6rem;
                margin-top: 0.6rem;
            }
        }

        @media (max-width: 1200px) {
            .font-menor
            {
                font-size: 10pt;
            }
        }

        @media (max-width: 900px) {
            .font-menor
            {
                font-size: 8pt;
            }
        }
        
        @media (max-width: 680px) {
            .btn:not(:disabled):not(.disabled) {
                cursor: pointer;
                font-size: 0.8rem;
                height: auto;
                padding: 0.3rem 0.5rem;
                margin-top: 0.6rem;
            }

            .col-lg-12 {
                padding-right: 0;
                padding-left: 8px;
            }

            .card-body {

                padding: 0.35rem;
            }

            .main {
                padding-left: 0.3rem !important;
            }

            .font-menor
            {
                font-size: 10pt;
            }
            .table td {
                padding: 0.5rem;
                font-size: 0.8rem;
            }

            .table .thead-light th {
                font-size: 0.9rem;
                padding: 0.5rem;
            }

        }
    </style>
    <!--  LOADING -->

    <div id="loader" style="display: none;">
        <div class="loader" role="status">

        </div>
    </div>

    <!-- FIM LOADING -->

    <!--  INICIO FILTRO  -->

    <div class="row">
        <div class="col-12">
            <div class="card mb-3">

                <div class="card-header uppercase">
                    <div class="caption">
                        <i class="ti-filter"></i> Filtros
                    </div>
                </div>

                <div class="card-body" >
                    <div class="form-group">

                        <div class="row">

                            <div class="col-lg-4">
                                <label class="mt-2">Nome do Cliente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Nome do Cliente" wire:model.lazy="nomeCliente">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="mt-2">Número do Cliente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-ticket"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Número do Cliente" wire:model.lazy="numeroCliente">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="mt-2">Zona</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-pin2"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Zona" wire:model.lazy="zonaCliente">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            {{-- <div class="col-lg-4">
                                <label class="mt-2">Comentário</label>
                                <div class="input-group">
                                    <select name="perPage" wire:model.lazy="estadoEncomenda" class="form-control">
                                        <option value="0" selected>Todas</option>
                                        <option value="1">Com comentário</option>
                                        <option value="2">Sem comentário</option>
                                    </select>
                                </div>
                            </div> --}}
                            
                            <div class="col-lg-4">
                                <label class="mt-2">Data Inicial</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-calendar"></i></span>
                                    </div>
                                    <input type="date" class="form-control" placeholder="Data Inicial" wire:model.lazy="startDate">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="mt-2">Data Final</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-calendar"></i></span>
                                    </div>
                                    <input type="date" class="form-control" placeholder="Data Final" wire:model.lazy="endDate">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="mt-2">Estádo da Encomenda</label>
                                <div class="input-group">
                                    <select name="perPage" class="form-control" wire:model.lazy="statusEncomenda">
                                        <option value="0">Todas</option>
                                        <option value="1" selected>Abertas</option>
                                        <option value="2">Fechadas</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row ml-0 mr-0 mt-4 d-block">

                             <!-- PARTE DO ACCORDEON -->
                             <div class="row ml-0 mr-0 mt-4 d-block">

                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                      <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                          <button class="btn btn-link btn-block text-left pl-0 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="ti-plus"></i> MAIS FILTROS
                                          </button>
                                        </h2>
                                      </div>

                                      <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <label class="mt-2">NIF</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ti-receipt"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="NIF" wire:model.lazy="nifCliente">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label class="mt-2">Telemóvel</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ti-microphone-alt"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Telemóvel" wire:model.lazy="telemovelCliente">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label class="mt-2">Email</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ti-email"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Email" wire:model.lazy="emailCliente">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                      </div>
                                    </div>
                                  </div>

                            </div>

                        <!-- FIM DO ACCORDEON -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FIM FILTRO  -->

    <!-- TABELA  -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="caption uppercase">
                                <i class="ti-user"></i> Encomendas
                            </div>
                        </div>
                        <div class="col-12 col-sm-8 text-right">
                            <a wire:click="adicionarEncomenda" style="color:white!important;" class="btn btn-sm btn-success">
                                <i class="ti-book"></i> Adicionar Encomenda
                            </a>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div id="dataTables_wrapper" class="dataTables_wrapper w-100" style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                        <div class="left">
                            <label>Mostrar
                                <select name="perPage" wire:model="perPage">
                                    <option value="10"
                                        @if ($perPage == 10) selected @endif>10</option>
                                    <option value="25"
                                        @if ($perPage== 25) selected @endif>25</option>
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
                        <table class="table table-bordered table-hover table-nowrap" id="tabela-cliente">
                            <thead class="thead-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Encomenda</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Tipo de Encomenda</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{dd($encomendas )}} --}}
                                @foreach ($encomendas as $enc)

                                    <tr>
                                        <td>{{ date('Y-m-d', strtotime($enc->date)) }}</td>
                                        <td>{{$enc->order}}</td>
                                        <td>{{$enc->name}}</td>
                                        <td>{{ number_format($enc->total,3) }}€</td>
                                        <td>{{$enc->status}}</td>
                                        <td>
                                        {{-- {{dd($enc)}} --}}
                                            <a wire:click="checkOrder({{json_encode($enc->id)}}, {{json_encode($enc)}})" style="color:white!important;" class="btn btn-sm btn-primary">
                                                <i class="ti-eye"></i> Ver Encomenda
                                            </a>
                                            <a wire:click="redirectNewEncomenda({{json_encode($enc->customer_id)}})" style="color:white!important;" class="btn btn-sm btn-primary">
                                                <i class="ti-plus"></i> Nova Encomenda
                                            </a>
                                        </td>
                                    </tr>                              

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $encomendas->links() }}
                </div>
            </div>
        </div>
    </div>

        <!-- TABELA  -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header d-block">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="caption uppercase">
                                    <i class="ti-user"></i> Pendentes
                                </div>
                            </div>
                            <div class="col-12 col-sm-8 text-right">
                                {{-- <a href="javascript:void(0);" wire:click="GerarPdfFinanceiro()" class="btn btn-sm btn-secondary"> Gerar PDF</a> --}}
                           </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="dataTables_wrapper" class="dataTables_wrapper w-100" style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                            <div class="left">
                                <label>Mostrar
                                    <select name="perPage" wire:model="perPagePendente" wire:change="PerPagePendente($event.target.value)">
                                        <option value="10"
                                            @if ($perPagePendente == 10) selected @endif>10</option>
                                        <option value="25"
                                            @if ($perPagePendente == 25) selected @endif>25</option>
                                        <option value="50"
                                            @if ($perPagePendente == 50) selected @endif>50</option>
                                        <option value="100"
                                            @if ($perPagePendente == 100) selected @endif>100</option>
                                    </select>
                                    registos
                                </label>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-nowrap" id="tabela-cliente2">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Documento</th>
                                        <th>Doc. Nº</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>Referência</th>
                                        <th>Descrição</th>
                                        <th>Total</th>
                                        <th>Quant.</th>
                                        <th>Quant. pendente</th>
                                        <th>Stock suficiente</th>
                                        <th>Stock total</th>
                                        <th>Stock enc.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($analise['object'] != null)
                                    @foreach ($analise['object'] as $index => $item)
                                        @php
                                            if (is_array($item)) {
                                                $item = (object) $item;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $item->Document ?? null }}</td>
                                            <td>{{ $item->Document_number ?? null }}</td>
                                            <td>{{ $item->Date ?? null }}</td>
                                            <td>{{ $item->Customer ?? null }}</td>
                                            <td>{{ $item->Reference ?? null }}</td>
                                            <td>{{ $item->Description ?? null }}</td>
                                            <td>{{ number_format($item->Total, 3) ?? null }}€</td>
                                            <td>{{ $item->Quantity ?? null }}</td>
                                            <td>{{ $item->Quantity_pending ?? null }}</td>
                                            <td>{{ $item->Sufficient_stock ?? null }}</td>
                                            <td>{{ $item->Total_stock ?? null }}</td>
                                            <td>{{ $item->Stock_ordered ?? null }}</td>
                                        </tr>                              
    
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- PAGINAÇÃO -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button wire:click="previousPagePendente" class="btn btn-primary" 
                                @if ($pageChosenPendente <= 1) disabled @endif>
                                Anterior
                            </button>

                            <span>Página {{ $pageChosenPendente }} de {{ $analise['nr_paginas'] }}</span>

                            <button wire:click="nextPagePendente" class="btn btn-primary" 
                                @if ($pageChosenPendente >= $analise['nr_paginas']) disabled @endif>
                                Próxima
                            </button>
                        </div>

                        <!-- SELECIONAR PÁGINA -->
                        <div class="mt-2">
                            <label>Ir para a página:</label>
                            <select wire:model="pageChosenPendente" wire:change="goToPagePendente($event.target.value)" class="form-control w-auto d-inline">
                                @for ($i = 1; $i <= $analise['nr_paginas']; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM TABELA  -->
    <script>

        // Obtém todas as linhas da tabela
        const tableRows = document.querySelectorAll('tr[data-href]');

        // Adiciona um ouvinte de evento de clique a cada linha
        tableRows.forEach(function(row) {
            row.addEventListener('click', function() {
                // Obtém o URL de destino do atributo data-href
                const href = row.dataset.href;

                // Redireciona o usuário para o URL de destino
                window.location.href = href;
            });
        });

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
