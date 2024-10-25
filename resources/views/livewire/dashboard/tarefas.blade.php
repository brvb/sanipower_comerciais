<div>

    <style>
        /*  DATEPICKER */

        .datepicker {
            z-index: 1051 !important;
            /* ou qualquer valor maior que o z-index do modal */
        }

        .datepicker .day,
        .datepicker .dow {
            padding: 5px 10px !important;
            /* Ajuste o padding conforme necessário */
        }

        .datepicker table tr td {
            width: 30px !important;
            /* Ajuste a largura das células conforme necessário */
        }

        .datepicker .prev,
        .datepicker .datepicker-switch,
        .datepicker .next {
            text-align: center !important;
        }

        .datepicker table tr td.day {
            cursor: pointer;
        }

        .datepicker table tr td.day:hover {
            background-color: #1791ba;
            /* Ajuste a cor de fundo conforme necessário */
        }


        .bootstrap-timepicker-widget {
            z-index: 9999 !important;
            /* ou um valor maior que o z-index do modal */
        }

        .fc-list-sticky .fc-list-day>* {
            position: static !important;
        }

        .fc-list-sticky .fc-list-day>* {
            position: static !important;
        }

        @media only screen and (max-width: 665px) {
            .fc .fc-toolbar-title {
                font-size: 1.25rem;
            }

            .fc-direction-ltr .fc-button-group>.fc-button:not(:last-child) {
                font-size: 0.8rem;
            }

            .fc-direction-ltr .fc-button-group>.fc-button:not(:first-child) {
                font-size: 0.8rem;
            }

            .fc-direction-ltr .fc-toolbar>*> :not(:first-child) {
                font-size: 0.85rem;
            }


            .fc * {
                font-size: 0.65rem;
            }
        }

        @media only screen and (max-width: 520px) {
            .fc .fc-toolbar-title {
                font-size: 0.7rem;
            }

            .fc-direction-ltr .fc-button-group>.fc-button:not(:last-child) {
                font-size: 0.66rem;
            }

            .fc-direction-ltr .fc-button-group>.fc-button:not(:first-child) {
                font-size: 0.66rem;
            }

            .fc-direction-ltr .fc-toolbar>*> :not(:first-child) {
                font-size: 0.65rem;
            }

            .card .card-header .caption {
                font-size: 0.8rem;
            }

            #addTarefaBtn,
            #addVisitaBtn {
                font-size: 0.6rem;
            }

            .card-header {
                padding: 0.7rem;
            }

            .card-body {
                padding: 0.4rem 0.6rem;
            }

            .fc * {
                font-size: 0.6rem;
            }

            .fc .fc-list-table td {
                padding: 4px 10px;
            }

            .fc .fc-button .fc-icon {
                font-size: 0.88rem;
            }
        }


        /** FIM DATEPICKER **/
    </style>

    <div id="loader" style="display: none;">
        <div class="loader" role="status">
        </div>
    </div>

    <div class="card mb-3" style="min-height: 98%;">
        <div class="card-header">
            <div class="caption">
                <i class="ti-pencil-alt"></i> Listas Tarefas
            </div>
            <div class="tools">
                <a href="javascript:;" class="btn btn-sm btn-primary" id="addTarefaBtn" wire:click="addTarefaButton" data-toggle="tooltip" title="Adicionar tarefa">
                    <i class="ti-plus"></i> Adicionar Tarefa
                </a>
                <a href="javascript:;" class="btn btn-sm btn-success" id="addVisitaBtn" wire:click="addVisita" data-toggle="tooltip" title="Agendar visita">
                    <i class="ti-plus"></i> Agendar Visita
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row" style="display:contents;" wire:key="teste-{{$iteration}}">
                <div id="calendarTarefas" wire:ignore></div>
            </div>
        </div>
    </div>

    <span class="d-none" id="valuesTarefas">{{json_encode($listagemTarefas)}}</span>

    <input type="hidden" id="dayPicked" wire:model="dayPicked">
    <input type="hidden" id="flagReset" wire:model="flagReset">
    <input type="hidden" id="mesEscolhido" wire:model="mesEscolhido">

    <!--  MODAL EDITAR TAREFA  -->

    <div class="modal fade" id="modalTarefas" tabindex="-1" role="dialog" aria-labelledby="modalTarefas" aria-hidden="true">
        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="modalTarefas">Informação da tarefa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="scrollModal" style="overflow-y: auto;max-height:500px;">

                    <label class="mt-4">Nome do Cliente</label>
                    <div class="input-group">

                        <input type="text" class="form-control" placeholder="Nome do Cliente" id="clienteName" readonly wire:model.defer="clienteTemp">
                    </div>

                    <label class="mt-4">Assunto</label>
                    <div class="input-group">

                        <input type="text" class="form-control" placeholder="Hora Marcada" id="horaMarcada" wire:model.defer="assuntoTemp">
                    </div>

                    <label class="mt-4">Descrição</label>
                    <div class="input-group">
                        <textarea type="text" id="assuntoMarcado" class="form-control" cols="4" rows="6" wire:model.defer="descricaoTemp"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="cleanSelectionQuick" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-primary" wire:click="changeTarefa({{$idTarefaTemp}})">Alterar tarefa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FIM MODAL -->

    <!-- MODAL ADD TAREFA -->

    <div class="modal fade" id="modalAddTarefa" tabindex="-1" role="dialog" aria-labelledby="modalAddTarefa" aria-hidden="true">
    <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="modalAddTarefa">Adicionar tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="scrollModal" style="overflow-y: auto;max-height:500px;">
                <div class="form-group row ml-0">
                    <label>Nome do Cliente</label>
                    <div class="input-group">
                        <select class="form-control" id="clienteNameTarefa" wire:model.defer="clienteNameTarefa">
                            @isset($clientes)
                                <option value="">Sem Cliente</option>
                                @foreach ($clientes as $clt)
                                    @isset($clt->customers)
                                        @foreach($clt->customers as $cst)
                                            <option value="{{ json_encode($cst->name) }}">{{ $cst->name }}</option>
                                        @endforeach
                                    @endisset

                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>

                <div class="form-group row ml-0">
                    <label>Data</label>
                    <div class="input-group date">
                        <input type="text" id="dataInicialTarefa" class="form-control" wire:model.defer="dataInicialTarefa">
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
                        <input type="text" class="form-control horaInicialTarefa" id="horaInicialTarefa" wire:model.defer="horaInicialTarefa">
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
                        <input type="text" class="form-control horaFinalTarefa" id="horaFinalTarefa" wire:model.defer="horaFinalTarefa">
                        <div class="input-group-append timepicker-btn">
                            <span class="input-group-text">
                                <i class="ti-time"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row ml-0">
                    <label>Assunto</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Assunto" id="assuntoTarefa" wire:model.defer="assuntoTarefa">
                    </div>
                </div>

                <div class="form-group row ml-0">
                    <label>Descrição</label>
                    <div class="input-group">
                        <textarea type="text" id="descricaoTarefa" placeholder="Descrição" class="form-control" cols="4" rows="6" wire:model.defer="descricaoTarefa"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="cleanSelectionQuick" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-outline-primary" id="saveTarefaBtn" onclick="validateAndSaveTarefa()">Guardar tarefa</button>
            </div>
        </div>
    </div>
</div>

<script>
    function validateAndSaveTarefa() {
        // Get all the form fields
        const cliente = document.getElementById('clienteNameTarefa').value;
        const data = document.getElementById('dataInicialTarefa').value;
        const horaInicial = document.getElementById('horaInicialTarefa').value;
        const horaFinal = document.getElementById('horaFinalTarefa').value;
        const assunto = document.getElementById('assuntoTarefa').value;
        const descricao = document.getElementById('descricaoTarefa').value;

        // Check if any field is empty
        if (!data || !horaInicial || !horaFinal || !assunto || !descricao) {
            // Trigger a Livewire event to show a toaster message instead of using alert
            /*window.dispatchEvent(new CustomEvent('sendToaster', {
            detail: {
                message: 'Por favor, preencha todos os campos.',
                status: 'error'
            }
            }));*/

            $("#modalTarefas").modal('hide');
            $("#modalAddTarefa").modal('hide');
            $("#agendarVisita").modal('hide');
            $("#modalInformacaoTarefa").modal('hide');

            toastr.warning('Por favor, preencha todos os campos.');
            Livewire.emit('callAddTarefa');
            return;
        }
        @this.saveTarefa(); 
    }
    /*function HrSuperior() 
    {
        $("#modalTarefas").modal('hide');
        $("#modalAddTarefa").modal('hide');
        $("#agendarVisita").modal('hide');
        $("#modalInformacaoTarefa").modal('hide');
        toastr.warning('Por favor, preencha todos os campos.');
        Livewire.emit('callAddTarefa');
        return;
    }*/
</script>




    <!-- FIM DO ADD -->

    <!-- MODAL ADICIONAR VISITA -->

    <div class="modal fade" id="agendarVisita" tabindex="-1" role="dialog" aria-labelledby="agendarVisita" aria-hidden="true">
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
                                    <select class="form-control" id="clienteVisitaIDD" wire:model.defer="clienteVisitaID">
                                        @isset($clientes)
                                            @foreach ($clientes as $clt)
                                                @isset($clt->customers)
                                                    @foreach($clt->customers as $cst)
                                                        <option value="{{ json_encode($cst->id) }}">{{ $cst->name }}</option>
                                                    @endforeach
                                                @endisset

                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row ml-0">
                                <label>Data</label>
                                <div class="input-group date">
                                    <input type="text" id="dataInicialVisitar" class="form-control" wire:model.defer="dataInicialVisita">
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
                                <input type="text" class="form-control horaInicialVisita" id="horaInicialVisita" wire:model.defer="horaInicialVisita" value="09:00">
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
                                    <input type="text" class="form-control horaFinalVisita" id="horaFinalVisita" wire:model.defer="horaFinalVisita">
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
                                    <select class="form-control" id="tipo_visita_select" wire:model.defer="tipoVisitaEscolhidoVisita">
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
                                    <textarea id="assunto_text" class="form-control" wire:model.defer="assuntoTextVisita" style="min-height: 80px; max-height: 200px;"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-primary" id="addVisitaModalBtn" wire:click="agendaVisita">Agendar</button>
                    <button type="button" class="btn btn-outline-primary" id="addVisitaModalBtn" wire:click="agendaIniciarVisita">Agendar e Iniciar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInformacaoTarefa" tabindex="-1" role="dialog" aria-labelledby="modalInformacaoTarefa" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="modalComentario">Editar Visita</h5>
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
                           
                                    <select class="form-control" id="clienteVisitaIDDireito" wire:model.defer="clienteVisitaIDDireito" readonly disabled>
                                        @isset($clientes)
                                            
                                            @foreach ($clientes as $clt)
                                                 @isset($clt->customers)
                                                    @foreach($clt->customers as $cst)

                                                        <option value="{{ json_encode($cst->id) }}">{{ $cst->name }}</option>
            
                                                    @endforeach
                                                @endisset
    
                                            @endforeach
    
                                        @endisset
                                    </select>
                                </div>
                            </div>
    
                            <div class="form-group row ml-0">
                                <label>Data</label>
                                <div class="input-group date">
                                    <input type="text" id="dataInicialVisitaDireito" class="form-control" wire:model.defer="dataInicialVisitaDireito">
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
                                    <input type="text" class="form-control horaInicialVisitaDireito" id="horaInicialVisitaDireito" value="09:00" wire:model.defer="horaInicialVisitaDireito">
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
                                    <input type="text" class="form-control horaFinalVisitaDireito" id="horaFinalVisitaDireito" wire:model.defer="horaFinalVisitaDireito">
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
                                    <select class="form-control" id="tipovisitaselectDireito" wire:model.defer="tipoVisitaEscolhidoDireito">
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
                                    <textarea id="assunto_textDireito" class="form-control" wire:model.defer="assuntoTextVisitaDireito" style="min-height: 80px; max-height: 200px;"></textarea>
                                    <input type="hidden" id="visitaIDDireito" wire:model.defer="visitaIDDireito">
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal" wire:click="openVisita"><i class="ti-search"></i>Visualizar</button>
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-primary" id="addVisitaModalBtnEdita" wire:click="editarVisitaDireito">Gravar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- FIM MODAL -->





    <script>
        document.addEventListener('livewire:load', function() {
            const loader = document.getElementById('loader');

            document.getElementById('addVisitaBtn').addEventListener('click', function() {
                loader.style.display = 'block';
            });

            document.getElementById('addVisitaModalBtn').addEventListener('click', function() {
                loader.style.display = 'block';
            });

            document.getElementById('addTarefaBtn').addEventListener('click', function() {
                loader.style.display = 'block';
            });

            document.getElementById('saveTarefaBtn').addEventListener('click', function() {
                loader.style.display = 'block';
            });

            Livewire.hook('message.processed', (message, component) => {
                loader.style.display = 'none';
            });

           
        });

        function formatDate(dateString) {
                var date = new Date(dateString);
                return new Intl.DateTimeFormat('pt-BR', {
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric'
                }).format(date);
        }

        function startCalendar() {
            var calendarValuesTarefa = JSON.parse($('#valuesTarefas').text());

            var eventTarefa = [];

            $.each(calendarValuesTarefa, function(index, valores) {
                {
                    if (index == "visitas") {
                        $.each(valores, function(indexVisita, valoresVisita) {

                            if(valoresVisita.finalizado == 0){
                                colorState = "blue";
                                
                            } else if(valoresVisita.finalizado == 1) {
                                colorState = "green";
                            } else {
                                colorState = "#e6e600";
                            }

                            // Supondo que valores.data_inicial seja uma string de data no formato "yyyy-mm-dd"
                            let dataInicial = valoresVisita.data_inicial;
                            
                            // Verifica se a data está no formato dd-mm-yyyy ou yyyy-mm-dd
                            if (/^\d{2}-\d{2}-\d{4}$/.test(dataInicial)) {
                                // Caso seja dd-mm-yyyy, transforma para yyyy-mm-dd
                                let [dia, mes, ano] = dataInicial.split('-');
                                valoresVisita.data_inicial = `${ano}-${mes}-${dia}`;
                            } else if (/^\d{4}-\d{2}-\d{2}$/.test(dataInicial)) {
                                // Caso já esteja no formato yyyy-mm-dd, mantém o valor
                                valoresVisita.data_inicial = dataInicial;
                            } else {
                                console.error("Formato de data inválido");
                            }

                            let dataForm = new Date(valoresVisita.data_inicial);

                            let dia = String(dataForm.getDate()).padStart(2, '0');
                            let mes = String(dataForm.getMonth() + 1).padStart(2, '0'); // Os meses começam do 0 em JavaScript
                            let ano = dataForm.getFullYear();

                            let dataFormatada = `${dia}-${mes}-${ano}`;

                            eventTarefa.push({
                                title: valoresVisita.cliente,
                                start: valoresVisita.data_inicial + "T" + valoresVisita.hora_inicial,
                                end: valoresVisita.data_inicial + "T" + valoresVisita.hora_final,
                                backgroundColor: colorState,
                                assunto: valoresVisita.assunto_text,
                                dataInicial: dataFormatada,
                                horaInicial: valoresVisita.hora_inicial,
                                horaFinal: valoresVisita.hora_final,
                                corVisita: valoresVisita.tipovisita.cor,
                                nomeVisita: valoresVisita.tipovisita.tipo,
                                idAgendada: valoresVisita.id,
                                idTipoVisita : valoresVisita.id_tipo_visita,
                                clientId: valoresVisita.client_id,
                                visitaID: valoresVisita.id,
                                finalizado: valoresVisita.finalizado,
                                tarefa: "no"
                            });

                        });
                    } else {
                        $.each(valores, function(indexTarefa, valoresTarefa) {

                            // Supondo que valores.data_inicial seja uma string de data no formato "yyyy-mm-dd"
                            let dataInicial = valoresTarefa.data_inicial;

                            // Verifica se a data está no formato dd-mm-yyyy ou yyyy-mm-dd
                            if (/^\d{2}-\d{2}-\d{4}$/.test(dataInicial)) {
                                // Caso seja dd-mm-yyyy, transforma para yyyy-mm-dd
                                let [dia, mes, ano] = dataInicial.split('-');
                                valoresTarefa.data_inicial = `${ano}-${mes}-${dia}`;
                            } else if (/^\d{4}-\d{2}-\d{2}$/.test(dataInicial)) {
                                // Caso já esteja no formato yyyy-mm-dd, mantém o valor
                                valoresTarefa.data_inicial = dataInicial;
                            } else {
                                console.error("Formato de data inválido");
                            }

                            let dataForm = new Date(valoresTarefa.data_inicial);

                            let dia = String(dataForm.getDate()).padStart(2, '0');
                            let mes = String(dataForm.getMonth() + 1).padStart(2, '0'); // Os meses começam do 0 em JavaScript
                            let ano = dataForm.getFullYear();

                            let dataFormatada = `${dia}-${mes}-${ano}`;

                            eventTarefa.push({
                                title: valoresTarefa.cliente,
                                start: valoresTarefa.data_inicial + "T" + valoresTarefa.hora_inicial,
                                end: valoresTarefa.data_inicial + "T" + valoresTarefa.hora_final,
                                backgroundColor: "#FFFFFF00",
                                assunto: valoresTarefa.assunto_text,
                                descricao: valoresTarefa.descricao,
                                dataInicial: dataFormatada,
                                horaInicial: valoresTarefa.hora_inicial,
                                horaFinal: valoresTarefa.hora_final,
                                idTarefa: valoresTarefa.id,
                                finalizado: valoresTarefa.finalizado,
                                tarefa: "yes"
                            });
                            
                        });
                    }

                }
            });

            var calendarEl = document.getElementById('calendarTarefas');

          
            var checkFlagReset = jQuery("#flagReset").val();
    
            var specificDate = jQuery("#dayPicked").val();

            if(specificDate != "") {
                var formattedDate = formatDate(specificDate);
            }

            
            
            if (checkFlagReset == "") {
               
                headerToolbar = {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'listMonth,listWeek,listDay'
                };
            } 
            else {
               
                if (checkFlagReset == "false") {
   
                    headerToolbar = {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'listMonth,listWeek,listDay'
                    };
                } else {
                   
                    headerToolbar = {
                        left: 'resetButton',
                        center: 'title',
                    };
                }
            }
           
            

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'listMonth',
                events: eventTarefa,
                locale: 'pt-br',
                customButtons: {
                    resetButton: {
                        text: 'Hoje',
                        click: function() {
            
                            Livewire.emit('originalData')
                        }
                    }
                   
                },
                headerToolbar: headerToolbar,
                buttonText: {
                    today: 'Hoje',
                    day: 'Dia',
                    week: 'Semana',
                    month: 'Mês',
                    listDay: 'Dia',
                    listWeek: 'Semana',
                    listMonth: 'Mês'
                },
                views: {
                    timeGridWeek: {
                        allDayText: 'Dia'
                    },
                    timeGridDay: {
                        allDayText: 'Dia'
                    }
                },
                initialDate: checkFlagReset === "true" ? specificDate : null,

                datesSet: function() {

                    if(checkFlagReset == "true")
                    {
                       
                        jQuery('#calendarTarefas .fc-toolbar .fc-toolbar-chunk .fc-today-button').css("display","none");
                        jQuery('.fc-listMonth-button').css("display","none");
                        jQuery('.fc-listWeek-button').css("display","none");
                        jQuery('.fc-listDay-button').css("display","none");
                        jQuery('#calendarTarefas .fc-toolbar .fc-toolbar-chunk .fc-button-group .fc-prev-button').css("display","none");
                        jQuery('#calendarTarefas .fc-toolbar .fc-toolbar-chunk .fc-button-group .fc-next-button').css("display","none");
                      
                        var label = '<div class="fc-date-label">' + formattedDate + '</div>';
                        jQuery('#calendarTarefas .fc-toolbar .fc-toolbar-chunk .fc-toolbar-title').html(label);
                       
                    } else {
                     
                        jQuery('#calendarTarefas .fc-toolbar .fc-toolbar-chunk .fc-today-button').css("display","gg");
                        jQuery('.fc-listMonth-button').css("display","block");
                        jQuery('.fc-listWeek-button').css("display","block");
                        jQuery('.fc-listDay-button').css("display","block");

                  
                         jQuery('#calendarTarefas .fc-toolbar .fc-toolbar-chunk .fc-toolbar-title .fc-date-label').remove();
                    }
                    
                },
                //FAZER O ABRIR POP PARA VER A INFORMAÇÃO
                eventDidMount: function(info, element) {
                    var scroller = info.el.closest(".fc-scroller");

                    if (scroller) {
                        scroller.id = "scrollModal";
                    }


                    var eventElement = info.el.closest('.fc-daygrid-event-harness');

                    if (eventElement) {
                        eventElement.style.backgroundColor = info.backgroundColor; // Defina a cor desejada aqui
                        eventElement.style.color = "white";
                        eventElement.style.marginBottom = "5px";

                    }

                    if (info.event.end - info.event.start <= 3600000) { // Se a duração for menor ou igual a 1 hora
                        info.el.classList.add('fc-short-event'); // Adiciona a classe para eventos curtos
                    }


                },
                eventContent: function(arg) {
                    let customDiv = document.createElement('div');
                    customDiv.className = 'custom-event-content';


                    var custom = customDiv.closest('.custom-event-content');

                    if (custom) {
                        custom.style.whiteSpace = 'normal'; // Defina a cor desejada aqui
                    }

                    if (arg.event.extendedProps.tarefa == "no") {

                        let timeString = new Date(arg.event.start).toLocaleTimeString('pt-BR', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }) + ' - ' + new Date(arg.event.end).toLocaleTimeString('pt-BR', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        var estado = "";
                        var cor = "";

                        if (arg.event.extendedProps.finalizado == 1) {
                            estado = "finalizada";
                            cor = "green";
                        } else if(arg.event.extendedProps.finalizado == 2) {
                            estado = "iniciada";
                            cor = "#e6e600";
                        }
                        else {
                            estado = "agendada";
                            cor = "blue";
                        }
                        customDiv.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>` + arg.event.title + `<br><small style="color:` + cor + `; font-weight:bolder;">` + estado + `</small></div>
                            <div><a href="javascript:;" class="btn btn-sm btn-outline-primary edit-task" data-visita-id="` + arg.event.extendedProps.visitaID + `"><i class="ti-pencil" data-toggle="tooltip" title="" data-original-title="Editar Visita"></i></a>
                            </div>
                        `;
                    } else {

                        var checkFinalizado = "";

                        if (arg.event.extendedProps.finalizado == 1) {
                            checkFinalizado = "checked";
                        }


                        customDiv.innerHTML = `
                        <div class="row">
                            <div class="col-1">
                                 <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="form-checkbox">
                                        <label>
                                            <input type="checkbox" data-tarefa="` + arg.event.extendedProps.idTarefa + `" name="checkbox1"` + checkFinalizado + `>
                                            <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-11 pl-0 pr-0">
                                 <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div><label style="font-weight:bolder;">Cliente: </label> ` + arg.event.title + `</div>
                                    <div><label style="font-weight:bolder;">Assunto: </label> ` + arg.event.extendedProps.assunto + `</div>
                                    <div style="width:75%;"><label style="font-weight:bolder;">Descrição: </label> ` + arg.event.extendedProps.descricao + `</div>
                                </div>
                                <div class="pencilClick">
                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary edit-task" data-task-id="` + arg.event.extendedProps.idTarefa + `"><i class="ti-pencil" data-toggle="tooltip" title="" data-original-title="Editar Tarefa"></i></a>
                                </div>
                            </div>
                            </div>
                        </div>
                           
                           `;
                    }


                    return {
                        domNodes: [customDiv]
                    };
                },
               
                eventClick: function(info) {
                   
                   

                    if (info.event.extendedProps.tarefa == "no") {
                        $("#modalInformacaoTarefa").modal();

                       
                        $.fn.datepicker.dates['pt-BR'] = {
                            days: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
                            daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
                            daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sá"],
                            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
                            today: "Hoje",
                            clear: "Limpar",
                            format: "dd/mm/yyyy",
                            titleFormat: "MM yyyy",
                            /* Leverages same syntax as 'format' */
                            weekStart: 0
                        };


                        $('#dataInicialVisitaDireito').datepicker({
                            format: 'dd/mm/yyyy',
                            language: 'pt-BR',
                            autoclose: true
                        }).on('changeDate', function(e) {

                            var formattedDate = moment(e.date).format('YYYY-MM-DD');

                            @this.set('dataInicialVisitaDireito', formattedDate, true);

                        });

                    
                        $('.horaInicialVisitaDireito').timepicker({
                            minuteStep: 5,
                            showSeconds: false,
                            showMeridian: false,
                            defaultTime: '09:00',
                            icons: {
                                up: 'ti-angle-up',
                                down: 'ti-angle-down'
                            }
                        }).on('changeDate', function(e) {

                            var formattedDate = moment(e.date).format('HH:ii');

                            @this.set('horaInicialVisitaDireito', formattedDate, true);

                        });


                    
                        $('.horaFinalVisitaDireito').timepicker({
                            minuteStep: 5,
                            showSeconds: false,
                            showMeridian: false,
                            defaultTime: '10:00',
                            icons: {
                                up: 'ti-angle-up',
                                down: 'ti-angle-down'
                            }
                        }).on('changeDate', function(e) {

                            var formattedDate = moment(e.date).format('HH:ii');

                            @this.set('horaFinalVisitaDireito', formattedDate, true);

                        });

                        @this.set('visitaIDDireito',info.event.extendedProps.visitaID,true);
                        @this.set('dataInicialVisitaDireito',info.event.extendedProps.dataInicial,true);
                        @this.set('horaInicialVisitaDireito',info.event.extendedProps.horaInicial,true);
                        @this.set('horaFinalVisitaDireito',info.event.extendedProps.horaFinal,true);
                        @this.set('tipoVisitaEscolhidoDireito',info.event.extendedProps.idTipoVisita,true);
                        @this.set('assuntoTextVisitaDireito',info.event.extendedProps.assunto,true);

                        
                        $('#clienteVisitaIDDireito').val(JSON.stringify(info.event.extendedProps.clientId));
                        $('#dataInicialVisitaDireito').val(info.event.extendedProps.dataInicial);
                        $('#horaInicialVisitaDireito').val(info.event.extendedProps.horaInicial);
                        $('#horaFinalVisitaDireito').val(info.event.extendedProps.horaFinal);
                        $('#assunto_textDireito').val(info.event.extendedProps.assunto);             
                        $('#tipovisitaselectDireito').val(info.event.extendedProps.idTipoVisita);
                        $('#visitaIDDireito').val(info.event.extendedProps.visitaID);  

                    
                        if(info.event.extendedProps.finalizado == 1)
                        {
                            $('#clienteVisitaIDDireito').attr('readonly', true);
                            $('#dataInicialVisitaDireito').attr('readonly', true);
                            $('#horaInicialVisitaDireito').attr('readonly', true);
                            $('#horaFinalVisitaDireito').attr('readonly', true);
                            $('#assunto_textDireito').attr('readonly', true);    
                            $('#tipovisitaselectDireito').attr('readonly', true);

                            $("#addVisitaModalBtnEdita").css("display","none");
                        } 
                        else {
                            $('#clienteVisitaIDDireito').attr('readonly', false);
                            $('#dataInicialVisitaDireito').attr('readonly', false);
                            $('#horaInicialVisitaDireito').attr('readonly', false);
                            $('#horaFinalVisitaDireito').attr('readonly', false);
                            $('#assunto_textDireito').attr('readonly', false);    
                            $('#tipovisitaselectDireito').attr('readonly', false);

                            $("#addVisitaModalBtnEdita").css("display","block");
                        }


                        $('.edit-task').click(function() {
                            var taskId = $(this).data('task-id');
                            // Lógica para editar a tarefa com o id taskId
                        });
                    } else {

                        var target = $(info.jsEvent.target);

                        if (target.is('i.ti-pencil') || target.is('a.edit-task')) {
                            Livewire.emit('getTarefaInfo', info.event.extendedProps.idTarefa);
                        }

                        // Verifica se o clique foi na checkbox
                        if (target.is('input[type="checkbox"]')) {

                            if (target.prop('checked')) {

                                Livewire.emit('changeStatusTarefa', info.event.extendedProps.idTarefa, 1);

                            } else {

                                Livewire.emit('changeStatusTarefa', info.event.extendedProps.idTarefa, 0);

                            }
                        }

                    }

                }

            });

            calendar.render();

            var mesEsc = jQuery("#mesEscolhido").val();
            
            if(mesEsc != "")
            {
          
                calendar.gotoDate(mesEsc+'-01');
            }

        }

        document.addEventListener('DOMContentLoaded', function() {
            startCalendar();
        });
       
        window.addEventListener('sendToaster', function(e) {
            
            $("#modalTarefas").modal('hide');
            $("#modalAddTarefa").modal('hide');
            $("#agendarVisita").modal('hide');
            $("#modalInformacaoTarefa").modal('hide');

            if (e.detail.status == "success") {
                toastr.success(e.detail.message);
            }
           
            if (e.detail.status == "error") {
                toastr.warning(e.detail.message);
                Livewire.emit('callAddVisita');
                //$("#modalAddTarefa").modal();
                //$("#modalAddTarefa").modal('show');
            }
        });
        
        window.addEventListener('updateList', function(e) {

            $("#modalTarefas").modal('hide');
            $("#modalAddTarefa").modal('hide');
            $("#agendarVisita").modal('hide');
        
            startCalendar();
            location.reload();
        });

        window.addEventListener('openModalTarefa', function(e) {

            $("#modalTarefas").modal();

        });

        window.addEventListener('openVisitaModal', function(e) {
            $("#agendarVisita").modal('show');

            $('#clienteVisitaIDD').select2();

            @this.set('clienteVisitaID', $('#clienteVisitaIDD option:first').val() ,true);
            
            $('#clienteVisitaIDD').select2().on('change', function(e) {
                @this.set('clienteVisitaID', e.target.value, true);
            });


            $.fn.datepicker.dates['pt-BR'] = {
                days: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
                daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
                daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sá"],
                months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
                today: "Hoje",
                clear: "Limpar",
                format: "dd/mm/yyyy",
                titleFormat: "MM yyyy",
                /* Leverages same syntax as 'format' */
                weekStart: 0
            };


            $('#dataInicialVisitar').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true
            }).on('changeDate', function(e) {

                var formattedDate = moment(e.date).format('YYYY-MM-DD');
            
                @this.set('dataInicialVisita', formattedDate, true);

            });

            @this.set('horaInicialVisita', '09:00', true);
            $('.horaInicialVisita').timepicker({
                minuteStep: 5,
                showSeconds: false,
                showMeridian: false,
                defaultTime: '09:00',
                icons: {
                    up: 'ti-angle-up',
                    down: 'ti-angle-down'
                }
            }).on('changeDate', function(e) {

                var formattedDate = moment(e.date).format('HH:ii');

                @this.set('horaInicialVisita', formattedDate, true);

            });

            @this.set('horaFinalVisita', '10:00', true);
            $('.horaFinalVisita').timepicker({
                minuteStep: 5,
                showSeconds: false,
                showMeridian: false,
                defaultTime: '10:00',
                icons: {
                    up: 'ti-angle-up',
                    down: 'ti-angle-down'
                }
            }).on('changeDate', function(e) {

                var formattedDate = moment(e.date).format('HH:ii');

                @this.set('horaFinalVisita', formattedDate, true);

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

        window.addEventListener('openModalAddTarefa', function(e) {

            $("#modalAddTarefa").modal();

            $('#clienteNameTarefa').select2({}).on('change', function(e) {
                @this.set('clienteNameTarefa', e.target.value, true);
            });

            $.fn.datepicker.dates['pt-BR'] = {
                days: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
                daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
                daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sá"],
                months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
                today: "Hoje",
                clear: "Limpar",
                format: "dd/mm/yyyy",
                titleFormat: "MM yyyy",
                /* Leverages same syntax as 'format' */
                weekStart: 0
            };

            $('#dataInicialTarefa').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true
            }).on('changeDate', function(e) {

                var formattedDate = moment(e.date).format('YYYY-MM-DD');

                @this.set('dataInicialTarefa', formattedDate, true);

            });

            @this.set('horaInicialTarefa', '09:00', true);
            $('.horaInicialTarefa').timepicker({
                minuteStep: 5,
                showSeconds: false,
                showMeridian: false,
                defaultTime: '09:00',
                icons: {
                    up: 'ti-angle-up',
                    down: 'ti-angle-down'
                }
            }).on('changeDate', function(e) {

                var formattedDate = moment(e.date).format('HH:ii');

                @this.set('horaInicialTarefa', formattedDate, true);

            });

            @this.set('horaFinalTarefa', '10:00', true);
            $('.horaFinalTarefa').timepicker({
                minuteStep: 5,
                showSeconds: false,
                showMeridian: false,
                defaultTime: '10:00',
                icons: {
                    up: 'ti-angle-up',
                    down: 'ti-angle-down'
                }
            }).on('changeDate', function(e) {

                var formattedDate = moment(e.date).format('HH:ii');

                @this.set('horaFinalTarefa', formattedDate, true);
            });
        });
    </script>
</div>