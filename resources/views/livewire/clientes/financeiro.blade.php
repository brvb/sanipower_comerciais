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

    <!-- INICIO TABELA  -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="caption uppercase">
                                <i class="ti-stats-up"></i> Financeiro
                            </div>
                        </div>
                        <div class="col-12 col-sm-8 text-right">
                            <a href="javascript:void(0);" wire:click="GerarPdfFinanceiro()" class="btn btn-sm btn-secondary"> Gerar PDF</a>
                       </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="dataTables_wrapper" class="dataTables_wrapper container" style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
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
                        <table class="table table-bordered table-hover init-datatable" id="tabela-cliente">
                            <thead class="thead-light">
                                <tr>
                                    <th>Documento</th>
                                    <th>Doc. Nº</th>
                                    {{-- <th>Cliente</th> --}}
                                    <th>Observação</th>
                                    <th>Emissão</th>
                                    <th>Idade de Emissão</th>
                                    <th>Vencimento</th>
                                    <th>Idade de Vencimento</th>
                                    <th>Não regularizado</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (empty($financeiroPendente['object']))
                                @php
                                    $financeiroPendente['object'] = session('FinanceirosPendente', []);
                                @endphp
                            @endif
                            @if($financeiroPendente['object'] != null)
                                @foreach ($financeiroPendente['object'] as $doc )
                                    <tr>
                                        {{-- @dd($financeiroPendente); --}}
                                        <td>{{$doc->document ?? null}}</td>
                                        <td>{{$doc->document_number ?? null}}</td>
                                        {{-- <td>{{$doc->customer_name ?? null}}</td> --}}
                                        <td>{{$doc->obs ?? null}}</td>
                                        <td>{{ \Carbon\Carbon::parse($doc->date_issue ?? null)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($doc->date_issue ?? null)->diffInDays(now()) }} dias</td>
                                        <td>{{ \Carbon\Carbon::parse($doc->due_date ?? null)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($doc->due_date ?? null)->diffInDays(now()) }} dias</td>
                                        <td>{{$doc->not_regularized ?? null}}</td>
                                        <td>{{$doc->balance ?? null}}€</td>
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

                        <span>Página {{ $pageChosenPendente }} de {{ $financeiroPendente['nr_paginas'] }}</span>

                        <button wire:click="nextPagePendente" class="btn btn-primary" 
                            @if ($pageChosenPendente >= $financeiroPendente['nr_paginas']) disabled @endif>
                            Próxima
                        </button>
                    </div>

                    <!-- SELECIONAR PÁGINA -->
                    <div class="mt-2">
                        <label>Ir para a página:</label>
                        <select wire:model="pageChosenPendente" wire:change="goToPagePendente($event.target.value)" class="form-control w-auto d-inline">
                            @for ($i = 1; $i <= $financeiroPendente['nr_paginas']; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM TABELA  -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="caption uppercase">
                                <i class="ti-user"></i> Documentos de Faturação
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
                                registos
                            </label>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover init-datatable" id="tabela-cliente">
                            <thead class="thead-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Doc. Nº</th>
                                    <th>Documento</th>
                                    {{-- <th>Cliente</th> --}}
                                    <th>Total</th>
                                    <th></th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($detailsfinanceiro != null)
                                @foreach ($detailsfinanceiro as $doc )
                                    <tr>
                                        {{-- @dd($financeiro); --}}
                                        <td>{{ date('Y-m-d', strtotime($doc->date ?? null)) }}</td>
                                        <td>{{$doc->document_number ?? null}}</td>   
                                        <td>{{$doc->document ?? null}}</td>
                                        {{-- <td>{{$doc->customer_name}}</td> --}}
                                        <td>{{$doc->total ?? null}}€</td>
                                        <td></td>
                                        <td>
                                            <a wire:click="checkOrder({{json_encode($doc->id ?? null)}}, {{json_encode($doc ?? null)}})" style="color:white!important;" class="btn btn-sm btn-primary">
                                                <i class="ti-eye"></i> Ver detalhes
                                            </a>
                                             {{-- <a wire:click="redirectNewProposta({{json_encode($doc->customer_id)}})" style="color:white!important;" class="btn btn-sm btn-primary">
                                                <i class="ti-plus"></i> Nova Ocorrencia
                                            </a>  --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if($detailsfinanceiro != null)
                    {{ $detailsfinanceiro->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS -->
    <script>
        window.addEventListener('download-started', function() {
            setTimeout(function() {
                window.location.reload();
            }, 3000);
        });
    </script>

</div>