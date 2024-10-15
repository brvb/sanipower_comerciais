<div>
    <style>
        @media (max-width: 625px) {
            .table td {
                padding: 0.5rem 0.3rem;
                font-size: 0.7rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .col-lg-12 {
                padding-right: 0;
                padding-left: 8px;
            }

            .table .thead-light th {
                color: #495057;
                font-size: 0.8rem;
                padding: 0.5rem;
            }
        }

        /*  DATEPICKER */

        .datepicker {
            z-index: 1051 !important; /* ou qualquer valor maior que o z-index do modal */
        }

        .datepicker .day, .datepicker .dow {
            padding: 5px 10px !important; /* Ajuste o padding conforme necessário */
        }
        .datepicker table tr td {
            width: 30px !important; /* Ajuste a largura das células conforme necessário */
        }

        .datepicker .prev, .datepicker .datepicker-switch, .datepicker .next {
            text-align: center !important;
        }

        .datepicker table tr td.day {
            cursor: pointer;
        }

        .datepicker table tr td.day:hover {
            background-color: #1791ba; /* Ajuste a cor de fundo conforme necessário */
        }


        .bootstrap-timepicker-widget {
            z-index: 9999 !important; /* ou um valor maior que o z-index do modal */
        }

        /** FIM DATEPICKER **/

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

                <div class="card-body">
                    <div class="form-group">

                        <div class="row">

                            <div class="col-lg-4">
                                <label class="mt-2">Nome do Cliente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Nome do Cliente"
                                        wire:model.lazy="nomeCliente">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="mt-2">Número do Cliente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-ticket"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Número do Cliente"
                                        wire:model.lazy="numeroCliente">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="mt-2">Zona</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-pin2"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Zona"
                                        wire:model.lazy="zonaCliente">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <label class="mt-2">Estado Visita</label>
                                    <div class="input-group">
                                        <select name="perPage" wire:model.lazy="estadoVisita" class="form-control">
                                            <option value="" selected>Todas</option>
                                            <option value="3">Agendadas</option>
                                            <option value="2">Iniciadas</option>
                                            <option value="1">Finalizadas</option>
                                        </select>
                                    </div>
                            </div>
                        </div>

                        <!-- PARTE DO ACCORDEON -->
                        <div class="row ml-0 mr-0 mt-4 d-block">

                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left pl-0 text-decoration-none"
                                                type="button" data-toggle="collapse" data-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">
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
                                                            <span class="input-group-text"><i
                                                                    class="ti-receipt"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="NIF"
                                                            wire:model.lazy="nifCliente">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label class="mt-2">Telemóvel</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ti-microphone-alt"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            placeholder="Telemóvel" wire:model.lazy="telemovelCliente">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label class="mt-2">Email</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ti-email"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Email"
                                                            wire:model.lazy="emailCliente">
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

    <!-- FIM FILTRO  -->

    <!-- TABELA  -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="caption uppercase">
                                <i class="ti-user"></i> Visitas
                            </div>
                        </div>
                        <div class="col-12 col-sm-8 text-right">
                            <div class="tools">
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary"
                                    wire:click="agendarVisita">
                                    <i class="ti-alarm-clock"></i> Agendar Visita
                                </a>
                                <a href="{{ route('visitas.clientes') }}" class="btn btn-sm btn-success">
                                    <i class="ti-agenda"></i> Adicionar Visita
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div id="dataTables_wrapper" class="dataTables_wrapper container"
                        style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                        <div class="left">
                            <label>Mostrar
                                <select name="perPage" wire:model="perPage">
                                    <option value="10" @if ($perPage == 10) selected @endif>10
                                    </option>
                                    <option value="25" @if ($perPage == 25) selected @endif>25
                                    </option>
                                    <option value="50" @if ($perPage == 50) selected @endif>50
                                    </option>
                                    <option value="100" @if ($perPage == 100) selected @endif>100
                                    </option>
                                </select>
                                registos</label>
                        </div>
                    </div>
                    <div class="table-responsive-lg">
                        <table class="table table-responsive-lg table-bordered table-hover init-datatable"
                            id="tabela-cliente">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome do Cliente</th>
                                    <th>Data Inicial</th>
                                    <th>Data Final</th>
                                    <th>Estado</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($visitas as $vst)
                                    <tr data-href="{{ route('visitas.info', $vst->id) }}">
                                        <td>{{ $vst->id }}</td>
                                        <td>{{ $vst->cliente }}</td>
                                        <td>{{ $vst->data_inicial }} / {{ $vst->hora_inicial}}</td>
                                        <td>{{ $vst->data_final }} / {{ $vst->hora_final}}</td>
                                        <td>
                                         
                                            @if($vst->finalizado == 0)
                                              <button class="btn btn-sm btn-chili btn-round" disabled>Agendada</button>
                                            @elseif($vst->finalizado == 2)
                                              <button class="btn btn-sm btn-warning btn-round" disabled>Iniciada</button>
                                            @else
                                              <button class="btn btn-sm btn-forest btn-round" disabled>Finalizada</button>
                                            @endif
                              
                                        </td>
                                        <td>
                                            <a href="{{ route('visitas.info', $vst->id) }}"
                                                class="btn btn-primary">
                                                <i class="ti-search"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $visitas->links() }}
                </div>
            </div>
        </div>

    </div>

    <!-- FIM TABELA  -->

    <!-- MODAL -->

    <div class="modal fade" id="agendarVisita" tabindex="-1" role="dialog" aria-labelledby="agendarVisita"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="modalComentario">Agendar Visita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="scrollModal" style="overflow-y: auto;max-height:500px;">
                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="form-group row ml-0">
                                <label>Cliente</label>
                                <div class="input-group">
            
                                    <select class="form-control" id="clienteVisitaID" wire:model.defer="clienteVisitaID">
                                        @isset($clientesListagem[0])
                                            @foreach ($clientesListagem[0] as $clt)
                                                <option  value="{{ json_encode($clt->id) }}">{{ $clt->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row ml-0">
                                <label>Data</label>
                                <div class="input-group date">
                                    <input type="text" id="dataInicial" class="form-control" wire:model.defer="dataInicial">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="ti-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ml-0">
                                <label>Hora Inícial</label>
                                <div class="input-group">
                                    <input type="text" class="form-control horainicial" id="horainicial" wire:model.defer="horaInicial">
                                    <div class="input-group-append timepicker-btn">
                                        <span class="input-group-text">
                                            <i class="ti-time"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ml-0">
                                <label>Hora Final</label>
                                <div class="input-group">
                                    <input type="text" class="form-control horafinal" id="horafinal" wire:model.defer="horaFinal">
                                    <div class="input-group-append timepicker-btn">
                                        <span class="input-group-text">
                                            <i class="ti-time"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ml-0">
                                <label>Tipo de Visita</label>
                                <div class="input-group">
                                    <select class="form-control" id="tipo_visita_select" wire:model.defer="tipoVisitaEscolhido">
                                        <option value="" selected>Selecione um tipo de visita</option>
                                        @isset($tipoVisita)
                                            @foreach ( $tipoVisita as $tipo)
                                                <option value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row ml-0">
                                <label>Assunto</label>
                                <div class="input-group">
                                    <textarea id="assunto_text" class="form-control" wire:model.defer="assuntoText" style="min-height: 80px; max-height: 200px;"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-primary"
                        wire:click="newVisita">Adicionar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- FIM MODAL -->

    <!-- MODAL -->


    <div class="modal fade" id="listagemVisitas" tabindex="-1" role="dialog" aria-labelledby="listagemVisitas" aria-hidden="true">
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
            
                            @livewire('visitas.listagem-visitas-agendadas',["clientID" => json_encode($clientID), 'activeFinalizado' => "2"], key(json_encode($clientID)))

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- FIM MODAL -->
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="crossorigin="anonymous"></script>

<script>

    $( document ).ready(function() {

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
      
        
        window.addEventListener('sendToTeams', function(e) {

            var state = encodeURIComponent(JSON.stringify({ 
                tenant:e.detail.tenant, 
                clientid: e.detail.clientId, 
                clientesecret: e.detail.clientSecret,
                redirect: e.detail.redirect,
                visitaid: e.detail.visitaID,
                visitaname: e.detail.visitaName,
                data: e.detail.data,
                horainicial: e.detail.horaInicial,
                horafinal: e.detail.horaFinal,
                tipovisita: e.detail.tipoVisita, 
                assunto: e.detail.assunto,
                email: e.detail.email,
                organizer: e.detail.organizer 
            }));

            var novaJanela =  window.open("https://login.microsoftonline.com/"+e.detail.tenant+"/oauth2/v2.0/authorize?client_id="+e.detail.clientId+"&response_type=code&redirect_uri="+e.detail.redirect+"&response_mode=query&scope=Calendars.ReadWrite&state="+state, "_blank");
            novaJanela.focus();

            setTimeout(function() {
                    window.location.reload();
            }, 2500);
        });


    });
       
   

    window.addEventListener('listagemVisitasModal', function() {
        
        jQuery("#listagemVisitas").modal();
    });

    window.addEventListener('modalAgendar', function() {

        jQuery("#agendarVisita").modal();

        
        $('#clienteVisitaID').select2();
        @this.set('clienteVisitaID', $('#clienteVisitaID option:first').val() ,true);

        $('#clienteVisitaID').select2().on('change', function(e) {
                @this.set('clienteVisitaID', e.target.value, true);
        });

        $('#agendarVisita').on('shown.bs.modal', function () {

            $.fn.datepicker.dates['pt-BR'] = {
            days: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
            daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sá"],
            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            today: "Hoje",
            clear: "Limpar",
            format: "dd/mm/yyyy",
            titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
            weekStart: 0
        };


        $('#dataInicial').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            autoclose: true
        }).on('changeDate', function (e) {

            var formattedDate = moment(e.date).format('YYYY-MM-DD');

            @this.set('dataInicial', formattedDate ,true);

        });

        @this.set('horaInicial', '09:00' ,true);
        $('.horainicial').timepicker({
            minuteStep: 5,
            showSeconds: false,
            showMeridian: false,
            defaultTime: '09:00',
            icons: {
                up: 'ti-angle-up',
                down: 'ti-angle-down'
            }
        }).on('changeDate', function (e) {

            var formattedDate = moment(e.date).format('HH:ii');

            @this.set('horaInicial', formattedDate ,true);

        });


        @this.set('horaFinal', '10:00' ,true);
        $('.horafinal').timepicker({
            minuteStep: 5,
            showSeconds: false,
            showMeridian: false,
            defaultTime: '10:00',
            icons: {
                up: 'ti-angle-up',
                down: 'ti-angle-down'
            }
        }).on('changeDate', function (e) {

            var formattedDate = moment(e.date).format('HH:ii');

            @this.set('horaFinal', formattedDate ,true);

        });


        // window.addEventListener('sendToTeams', function(e) {

        //     var state = encodeURIComponent(JSON.stringify({ 
        //         tenant:e.detail.tenant, 
        //         clientid: e.detail.clientId, 
        //         clientesecret: e.detail.clientSecret,
        //         redirect: e.detail.redirect,
        //         visitaid: e.detail.visitaID,
        //         visitaname: e.detail.visitaName,
        //         data: e.detail.data,
        //         horainicial: e.detail.horaInicial,
        //         horafinal: e.detail.horaFinal,
        //         tipovisita: e.detail.tipoVisita, 
        //         assunto: e.detail.assunto,
        //         email: e.detail.email,
        //         organizer: e.detail.organizer 
        //     }));

        //     var novaJanela =  window.open("https://login.microsoftonline.com/"+e.detail.tenant+"/oauth2/v2.0/authorize?client_id="+e.detail.clientId+"&response_type=code&redirect_uri="+e.detail.redirect+"&response_mode=query&scope=Calendars.ReadWrite&state="+state, "_blank");
        //     novaJanela.focus();

        //     setTimeout(function() {
        //             window.location.reload();
        //     }, 2500);
        // });


        });

    });

    $('#listagemVisitas').on('hidden.bs.modal', function () {
        @this.set('clientID', "");
    });

</script>
