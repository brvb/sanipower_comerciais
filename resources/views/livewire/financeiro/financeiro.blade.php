<div>
    <div id="loader" style="display: none;">
        <div class="loader" role="status">

        </div>
    </div>

   <!-- <div class="row">
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
                                    <input type="text" class="form-control" placeholder="Nome do Clientes" wire:model.lazy="nomeCliente">
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
                                <label class="mt-2">Status</label>
                                <div class="input-group">
                                    <select name="perPage" class="form-control" wire:model.lazy="statusOcorrencia">
                                        <option value="0" selected>Todas</option>
                                        <option value="1">Em aberto</option>
                                        <option value="2">Em análise</option>
                                        <option value="3">Não autorizado</option>
                                        <option value="4">Não autorizado e fechado</option>
                                        <option value="5">Concluído</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row ml-0 mr-0 mt-4 d-block">

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

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
                                    <th>Cliente</th>
                                    <th>Cliente Nº</th>
                                    <th>Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($financeiro != null)
                                @foreach ($financeiro as $doc )
                                    <tr>
                                        <td>{{ date('Y-m-d', strtotime($doc->date)) }}</td>
                                        <td>{{$doc->document_number}}</td>   
                                        <td>{{$doc->document}}</td>
                                        <td>{{$doc->customer_name}}</td>
                                        <td>{{$doc->customer_number}}</td>
                                        <td>{{$doc->total}}€</td>
                                        <td>
                                            <a wire:click="checkOrder({{json_encode($doc->id)}}, {{json_encode($doc)}})" style="color:white!important;" class="btn btn-sm btn-primary">
                                                <i class="ti-eye"></i> Ver detalhes
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    {{ $financeiro->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="caption uppercase">
                                <i class="ti-user"></i> Financeiro
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
                                    <th>Cliente</th>
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
                            @if(isset($financeiroPendente['object']))
                                @if($financeiroPendente['object'] != null)
                                @foreach ($financeiroPendente['object'] as $doc )
                                    <tr>
                                        {{-- @dd($financeiroPendente); --}}
                                        <td>{{$doc->document ?? null}}</td>
                                        <td>{{$doc->document_number ?? null}}</td>
                                        <td>{{$doc->customer_name ?? null}}</td>
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
    
    <script>
        const tableRows = document.querySelectorAll('tr[data-href]');

        tableRows.forEach(function(row) {
            row.addEventListener('click', function() {

                const href = row.dataset.href;

                window.location.href = href;
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.sent', () => {
                document.getElementById('loader').style.display = 'block';
            });

            Livewire.hook('message.processed', () => {
                document.getElementById('loader').style.display = 'none';
            });
        });
        

        window.addEventListener('DOMContentLoaded', (event) => {
            if ("{{ session('success') }}") {
                toastr.success("{{ session('success') }}");
            }
            if("{{ session('warning') }}"){
                toastr.warning("{{ session('warning') }}");
            }
        });
    </script>
</div>
