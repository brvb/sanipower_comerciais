
<div>
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
                        <table class="table table-bordered table-hover init-datatable" id="tabela-cliente">
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
