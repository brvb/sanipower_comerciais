<div>

    @if(Auth::user()->nivel != 3)
        <div class="row">
            <label style="padding-left:15px;">Selecione Comercial</label>
            <div class="input-group" style="padding-left:15px;margin-bottom:10px;">
            
                <select class="form-control" id="userSelected" wire:model="userSelected">
                    <option value="0">Todos</option>
                    @isset($comerciais)
                    
                        @foreach ($comerciais as $com)
                            <option value="{{ $com->id }}">{{ $com->name }}</option>
                        @endforeach

                    @endisset
                </select>
            </div>
        </div>
    @endif
    
    <div class="card mb-3" style="height: 98%;">
        <div id="calendar"></div>
    </div>

    <span class="d-none" id="values">{{$listagemCalendario}}</span>


<div class="modal fade" id="modalInformacao" tabindex="-1" role="dialog" aria-labelledby="modalInformacao" aria-hidden="true">
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
                       
                                <select class="form-control" id="clienteVisitaID" wire:model.defer="clienteVisitaID" readonly disabled>
                                    @isset($clientes)
                                        @foreach ($clientes as $clt)
                                            @isset($clt)
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
                                <input type="text" id="dataInicialVisita" class="form-control" wire:model.defer="dataInicialVisita">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="ti-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row ml-0">
                            <label>Hora Inicial</label>
                            <div class="input-group">
                                <input type="time" class="form-control horaInicialVisita" id="horaInicialVisita" value="09:00" wire:model.defer="horaInicialVisita" step="60">
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
                                <input type="time" class="form-control horaFinalVisita" id="horaFinalVisita" wire:model.defer="horaFinalVisita" step="60">
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
                                <select class="form-control" id="tipovisitaselect" wire:model.defer="tipoVisitaEscolhido">
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
                                <input type="hidden" id="visitaID" wire:model.defer="visitaID">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal" wire:click="openVisita"><i class="ti-search"></i>Visualizar</button>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-outline-primary" id="addVisitaModalBtn" wire:click="editarVisita()">Gravar</button>
                <button type="button" class="btn btn-outline-danger" onclick="confirmDeletion1()">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDeletion1() {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Esta ação não poderá ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('loader').style.display = 'block';
                    @this.call('EliminarAgendado');
                }
            });
        }
    </script>

     <script>

function startCalendarLeft() {
    var calendarValues = JSON.parse($('#values').text());
    
    var eventMap = {}; // Objeto para agrupar eventos por data

    $.each(calendarValues, function(index, valores) {
        if (valores.finalizado == 0) {
            colorState = "blue";
        } else if (valores.finalizado == 1) {
            colorState = "green";
        } else {
            colorState = "#e6e600";
        }
        
        // Verifica e converte o formato da data
        let dataInicial = valores.data_inicial;
        if (/^\d{2}-\d{2}-\d{4}$/.test(dataInicial)) {
            let [dia, mes, ano] = dataInicial.split('-');
            valores.data_inicial = `${ano}-${mes}-${dia}`;
        } else if (!/^\d{4}-\d{2}-\d{2}$/.test(dataInicial)) {
            console.error("Formato de data inválido");
        }

        let dataFormatada = valores.data_inicial; // Mantemos no formato yyyy-mm-dd

        let eventObj = {
            title: valores.cliente,
            start: valores.data_inicial + "T" + valores.hora_inicial,
            end: valores.data_inicial + "T" + valores.hora_final,
            backgroundColor: colorState,
            assunto: valores.assunto_text,
            dataInicial: dataFormatada,
            horaInicial: valores.hora_inicial,
            horaFinal: valores.hora_final,
            corVisita: valores.tipovisita.cor,
            nomeVisita: valores.tipovisita.tipo,
            idTipoVisita: valores.id_tipo_visita,
            clientId: valores.client_id,
            visitaID: valores.id,
            finalizado: valores.finalizado
        };

        // Agrupar eventos por data
        if (!eventMap[dataFormatada]) {
            eventMap[dataFormatada] = [];
        }
        
        eventMap[dataFormatada].push(eventObj);
    });

    var filteredEvents = [];

    // Limitar a 3 eventos por dia
    Object.keys(eventMap).forEach(function(date) {
        filteredEvents = filteredEvents.concat(eventMap[date].slice(0, 3));
    });

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: filteredEvents,
        locale: 'pt-br',
        contentHeight: 'auto', // Ajusta a altura para evitar sobreposição
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia',
            list: 'Lista'
        },
        views: {
            dayGridMonth: {
                dayMaxEventRows: true, // Mostra apenas um número fixo de eventos antes do "+X mais"
                moreLinkText: function(n) {
                    return `+${n} mais`; // Personaliza o botão de eventos extras
                }
            },
            timeGridWeek: {
                allDayText: 'Dia'
            },
            timeGridDay: {
                allDayText: 'Dia'
            }
        },
        eventDidMount: function(info) {
            var eventElement = info.el.closest('.fc-daygrid-event-harness');
            if (eventElement) {
                eventElement.style.backgroundColor = info.backgroundColor;
                eventElement.style.color = "white";
                eventElement.style.marginBottom = "5px";
                eventElement.style.overflow = "hidden"; // Evita que o conteúdo ultrapasse o espaço do evento
                eventElement.style.whiteSpace = "nowrap"; // Mantém o texto em uma linha
                eventElement.style.textOverflow = "ellipsis"; // Adiciona "..." se o texto for muito longo
            }
        },
        eventContent: function(arg) {
            let customDiv = document.createElement('div');
            customDiv.className = 'custom-event-content';
            customDiv.style.fontSize = "12px"; // Diminui o tamanho do texto para melhor encaixe
                
            let timeString = new Date(arg.event.start).toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit'
            }) + ' - ' + new Date(arg.event.end).toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit'
            });

            customDiv.innerHTML = '<div>' + arg.event.title + '</div><div>' + timeString + '</div>';

            return { domNodes: [customDiv] };
        },
        dateClick: function(info) {
            var clickedDate = new Date(info.dateStr).toISOString().split('T')[0];
            var checkComercial = jQuery("#userSelected").val();
            Livewire.emit("changeDashWithDate", clickedDate, checkComercial);
        },
        eventClick: function(info) {
            $("#modalInformacao").modal('show');

            $('#dataInicialVisita').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true
            }).on('changeDate', function(e) {
                var formattedDate = moment(e.date).format('YYYY-MM-DD');
                @this.set('dataInicialVisita', formattedDate, true);
            });

            @this.set('visitaID', info.event.extendedProps.visitaID, true);
            @this.set('dataInicialVisita', info.event.extendedProps.dataInicial, true);
            @this.set('horaInicialVisita', info.event.extendedProps.horaInicial, true);
            @this.set('horaFinalVisita', info.event.extendedProps.horaFinal, true);
            @this.set('tipoVisitaEscolhido', info.event.extendedProps.idTipoVisita, true);
            @this.set('assuntoTextVisita', info.event.extendedProps.assunto, true);

            $('#clienteVisitaID').val(JSON.stringify(info.event.extendedProps.clientId));
            $('#dataInicialVisita').val(info.event.extendedProps.dataInicial);
            $('#horaInicialVisita').val(info.event.extendedProps.horaInicial);
            $('#horaFinalVisita').val(info.event.extendedProps.horaFinal);
            $('#assunto_text').val(info.event.extendedProps.assunto);             
            $('#tipovisitaselect').val(info.event.extendedProps.idTipoVisita);  
            $('#visitaID').val(info.event.extendedProps.visitaID);  

            if(info.event.extendedProps.finalizado == 1) {
                $('#clienteVisitaID').attr('readonly', true);
                $('#dataInicialVisita').attr('readonly', true);
                $('#horaInicialVisita').attr('readonly', true);
                $('#horaFinalVisita').attr('readonly', true);
                $('#assunto_text').attr('readonly', true);    
                $('#tipovisitaselect').attr('readonly', true);
                $("#addVisitaModalBtn").css("display","none");
            } else {
                $('#clienteVisitaID').attr('readonly', false);
                $('#dataInicialVisita').attr('readonly', false);
                $('#horaInicialVisita').attr('readonly', false);
                $('#horaFinalVisita').attr('readonly', false);
                $('#assunto_text').attr('readonly', false);    
                $('#tipovisitaselect').attr('readonly', false);
                $("#addVisitaModalBtn").css("display","block");
            }
        }
    });

    calendar.render();
}




        

        document.addEventListener('DOMContentLoaded', function() {
           startCalendarLeft();
        });

        document.addEventListener('restartCalendar', function() {
            startCalendarLeft();
        });

        window.addEventListener('sendToasterr', function(e) {

            if (e.detail.status == "success") {
                toastr.success(e.detail.message);
            }

            if (e.detail.status == "error") {
                toastr.warning(e.detail.message);
            }

            $("#modalInformacao").modal('hide');
            $("#modalTarefas").modal('hide');
            $("#modalAddTarefa").modal('hide');
            $("#agendarVisita").modal('hide');

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
