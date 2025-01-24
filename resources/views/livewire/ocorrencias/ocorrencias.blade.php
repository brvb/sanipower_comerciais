
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
                                <i class="ti-user"></i> Ocorrencias
                            </div>
                        </div>
                        {{-- <div class="col-12 col-sm-8 text-right">
                            <a wire:click="adicionarProposta" style="color:white!important;" class="btn btn-sm btn-success">
                                <i class="ti-book"></i> Adicionar Ocorrencias
                            </a>
                        </div> --}}
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
                                    <th>Doc. Nº</th>
                                    <th>Documento</th>
                                    <th>Cliente</th>
                                    <th>Cliente Nº</th>
                                    <th>Tipo</th>
                                    <th></th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ocorrencias as $doc )
                                    <tr>
                                        <td>{{ date('Y-m-d', strtotime($doc->date)) }}</td>
                                        <td>{{$doc->document_number}}</td>
                                        <td>{{$doc->document}}</td>
                                        <td>{{$doc->customer_name}}</td>
                                        <td>{{$doc->customer_number}}</td>
                                        <td>{{$doc->type_1}}</td>
                                        <td>{{$doc->type_2}}</td>
                                        <td>
                                            <a wire:click="checkOrder({{json_encode($doc->id)}}, {{json_encode($doc)}})" style="color:white!important;" class="btn btn-sm btn-primary">
                                                <i class="ti-eye"></i> Ver Ocorrencia
                                            </a>
                                             {{-- <a wire:click="redirectNewProposta({{json_encode($doc->customer_id)}})" style="color:white!important;" class="btn btn-sm btn-primary">
                                                <i class="ti-plus"></i> Nova Ocorrencia
                                            </a>  --}}
                                        </td>
                                    </tr>
                                @endforeach 

                            </tbody>
                        </table>
                    </div>
                    {{ $ocorrencias->links() }}
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
