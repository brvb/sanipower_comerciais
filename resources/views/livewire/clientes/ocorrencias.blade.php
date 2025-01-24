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
                        <div class="col-xl-8 col-xs-12">
                            <div class="caption uppercase">
                                <i class="ti-stats-up"></i> Ocorrências
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card-body">

                    <div id="dataTables_wrapper" class="dataTables_wrapper container"
                        style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                        <div class="left">
                            <label>
                                Mostrar
                                <select name="perPage" wire:model="perPage">
                                    <option value="10" @if ($perPage == 10) selected @endif>10</option>
                                    <option value="25" @if ($perPage == 25) selected @endif>25</option>
                                    <option value="50" @if ($perPage == 50) selected @endif>50</option>
                                    <option value="100" @if ($perPage == 100) selected @endif>100
                                    </option>
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
                                    <th>Total</th>
                                    <th>Tipo</th>
                                    <th></th>                                    
                                    <th>Ações</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalhesOcorrencias as $detalhe)
                                    <tr>
                                        <td>{{ date('Y-m-d', strtotime($detalhe->date)) }}</td>
                                        <td>{{ $detalhe->document }} Nº {{ $detalhe->document_number }}</td>
                                        <td>{{ number_format($detalhe->total, 3) }}€</td>
                                        <td>{{ $detalhe->type_1 }}</td>
                                        <td>{{ $detalhe->type_2 }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" wire:click="detalheOcorrenciasModal({{ json_encode($detalhe) }})">
                                                <i class="fas fa-info"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" wire:click="detalhesOcorrenciasModal({{ json_encode($detalhe) }})">
                                                Detalhes
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $detalhesOcorrencias->links() }}
                </div>
            </div>
        </div>

    </div>

    <!-- FIM TABELA  -->


    <!-- MODALS -->

    <div class="modal fade" id="modalComentarioOcor" tabindex="-1" role="dialog" aria-labelledby="modalComentarioOcor"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="modalComentario">Ocorrência {{ $ocorrenciaName }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="scrollModal" style="overflow-y: auto;max-height:500px;">
                    <div class="card mb-3">
                        <div class="card-body">
                            <label>Comentário</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;"
                                    wire:model.defer="comentarioOcorrencia"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-primary"
                        wire:click="sendComentario({{ json_encode($ocorrenciaID) }})">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVerComentarioOcorencia" tabindex="-1" role="dialog"
        aria-labelledby="modalVerComentarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerComentarioLabel">Comentários</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="timeline-wrapper">
                        @isset($comentario)
                            @foreach ($comentario as $comentarios)
                                <div class="timeline-item"
                                    data-date="{{ $comentarios->created_at }} &#8594; {{ $comentarios->user->name }}">
                                    <p>{{ $comentarios->comentario }}</p>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalheOcorrenciasModal" tabindex="-1" role="dialog" aria-labelledby="detalheOcorrenciasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" style="margin: 1.75rem auto;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalheOcorrenciasModalLabel">Detalhes da Ocorrência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="overflow-x:auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Descrição</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Desconto</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($detailsLine)
                                @foreach ($detailsLine['lines'] as $prod)
                                    <tr>
                                        <td>{{ $prod['reference'] }}</td>
                                        <td>{{ $prod['description'] }}</td>
                                        <td>{{ $prod['quantity'] }}</td>
                                        <td>{{ number_format($prod['price'], 3) }} €</td>
                                        <td>{{ $prod['discount'] }}</td>
                                        <td>{{ number_format($prod['total'], 3) }} €</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">Não foram encontrados registos para exibir.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="cursor:pointer">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalhesOcorrenciasModal" tabindex="-1" role="dialog" aria-labelledby="detalhesOcorrenciasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" style="margin: 1.75rem auto;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalhesOcorrenciasModalLabel">Detalhes da Ocorrência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="overflow-x:auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Por quem?</th>
                                <th>Data NC.</th>
                                <th>Nota de crédito Nº</th>
                                <th>Guia de transporte?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($detailsLine)
                                @foreach ($detailsLine['details'] as $prod)
                                    <tr>
                                        <td>{{ $prod['by_whom'] }}</td>
                                        <td>{{ $prod['credit_note_date'] }}</td>
                                        <td>{{ $prod['credit_note_number'] }}</td>
                                        <td>{{ isset($prod['transport_guide']) && $prod['transport_guide'] ? 'Sim' : 'Não'  }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">Não foram encontrados registos para exibir.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="cursor:pointer">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!----->

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


        document.addEventListener('abrirModalVerComentarioOcorrencias', function() {
            $('#modalVerComentarioOccorencia').modal('show');
        });

        document.addEventListener('openDetalheOcorrenciasModal', function() {
         $('#detalheOcorrenciasModal').modal('show');
        });

        document.addEventListener('openDetalhesOcorrenciasModal', function() {
         $('#detalhesOcorrenciasModal').modal('show');
        });
    </script>

</div>
