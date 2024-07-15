<div>
    
    <div class="card mb-3" style="height: 98%;">
        <div id="calendar"></div>
    </div>

    <span class="d-none" id="values">{{$listagemCalendario}}</span>

{{-- <div class="modal fade" id="modalInformacao" tabindex="-1" role="dialog" aria-labelledby="modalInformacao"
    aria-hidden="true">
    <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="modalProdutos">Informação do Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row d-block text-center font-weight-bold">
                    <label class="text-center"><span id="visitaName"></span></label>
                </div>
                
                
                <label class="mt-4">Nome do Cliente</label>
                <div class="input-group">
                    
                    <input type="text" class="form-control" placeholder="Nome do Cliente" id="clienteName" disabled>
                </div>

                <label class="mt-4">Data (Hora Inicial / Hora Final)</label>
                <div class="input-group">
                    
                    <input type="text" class="form-control" placeholder="Hora Marcada" id="horaMarcada" disabled>
                </div>

                <label class="mt-4">Assunto</label>
                <div class="input-group">
                    <textarea type="text" id="assuntoMarcado" class="form-control" cols="4" rows="6" disabled></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="cleanSelectionQuick" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div> --}}


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

                                          @foreach($clt->customers as $cst)

                                            <option value="{{ json_encode($cst->id) }}">{{ $cst->name }}</option>

                                          @endforeach

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
                            <label>Hora Inícial</label>
                            <div class="input-group">
                                <input type="text" class="form-control horaInicialVisita" id="horaInicialVisita" wire:model.defer="horaInicialVisita">
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
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-outline-primary" id="addVisitaModalBtn" wire:click="editarVisita()">Editar</button>
            </div>
        </div>
    </div>
</div>


     <script>

        function startCalendarLeft()
        {
            var calendarValues = JSON.parse($('#values').text());
            
            var event = [];

            $.each(calendarValues, function(index, valores) {
                {

                    if(valores.finalizado == 0){
                        colorState = "blue";
                        
                    } else if(valores.finalizado == 1) {
                        colorState = "green";
                    } else {
                        colorState = "#e6e600";
                    }
                   
                    event.push({
                        title: valores.cliente,
                        start: valores.data_inicial+"T"+valores.hora_inicial,
                        end: valores.data_inicial+"T"+valores.hora_final,
                        backgroundColor: colorState,
                        assunto: valores.assunto_text,
                        dataInicial: valores.data_inicial,
                        horaInicial: valores.hora_inicial,
                        horaFinal: valores.hora_final,
                        corVisita: valores.tipovisita.cor,
                        nomeVisita: valores.tipovisita.tipo,
                        idTipoVisita : valores.id_tipo_visita,
                        clientId: valores.client_id,
                        visitaID: valores.id,
                        finalizado: valores.finalizado
                    })
                }
            });

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events:event,
            locale: 'pt-br',
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
                timeGridWeek: {
                    allDayText: 'Dia'
                },
                timeGridDay: {
                    allDayText: 'Dia'
                }
            },
            //FAZER O ABRIR POP PARA VER A INFORMAÇÃO
            eventDidMount: function (info,element) {
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
                    
                    let timeString = new Date(arg.event.start).toLocaleTimeString('pt-BR', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) + ' - ' + new Date(arg.event.end).toLocaleTimeString('pt-BR', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    var custom = customDiv.closest('.custom-event-content');
            
                    if (custom) {
                        custom.style.whiteSpace = 'normal'; // Defina a cor desejada aqui
                    }

                    customDiv.innerHTML = '<div>' + arg.event.title + '</div><div>' + timeString + '</div>';

                return { domNodes: [customDiv] };
            },
            eventClick: function(info) {

                $("#modalInformacao").modal('show');

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


                $('#dataInicialVisita').datepicker({
                    format: 'dd/mm/yyyy',
                    language: 'pt-BR',
                    autoclose: true
                }).on('changeDate', function(e) {

                    var formattedDate = moment(e.date).format('YYYY-MM-DD');

                    @this.set('dataInicialVisita', formattedDate, true);

                });

            
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


                @this.set('visitaID',info.event.extendedProps.visitaID,true);
                @this.set('dataInicialVisita',info.event.extendedProps.dataInicial,true);
                @this.set('horaInicialVisita',info.event.extendedProps.horaInicial,true);
                @this.set('horaFinalVisita',info.event.extendedProps.horaFinal,true);
                @this.set('tipoVisitaEscolhido',info.event.extendedProps.idTipoVisita,true);
                @this.set('assuntoTextVisita',info.event.extendedProps.assunto,true);

                
                $('#clienteVisitaID').val(JSON.stringify(info.event.extendedProps.clientId));
                $('#dataInicialVisita').val(info.event.extendedProps.dataInicial);
                $('#horaInicialVisita').val(info.event.extendedProps.horaInicial);
                $('#horaFinalVisita').val(info.event.extendedProps.horaFinal);
                $('#assunto_text').val(info.event.extendedProps.assunto);             
                $('#tipovisitaselect').val(info.event.extendedProps.idTipoVisita);  
                $('#visitaID').val(info.event.extendedProps.visitaID);  

             
                if(info.event.extendedProps.finalizado == 1)
                {
                    $('#clienteVisitaID').attr('readonly', true);
                    $('#dataInicialVisita').attr('readonly', true);
                    $('#horaInicialVisita').attr('readonly', true);
                    $('#horaFinalVisita').attr('readonly', true);
                    $('#assunto_text').attr('readonly', true);    
                    $('#tipovisitaselect').attr('readonly', true);

                    $("#addVisitaModalBtn").css("display","none");
                } 
                else {
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
